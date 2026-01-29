require('dotenv').config();
const express = require("express");
const mysql = require("mysql2/promise");
const bodyParser = require("body-parser");
const cors = require("cors");
const session = require("express-session");

const app = express();

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(express.static("public"));

// MySQL Connection Pool
const pool = mysql.createPool({
    host: process.env.DB_HOST || "localhost",
    user: process.env.DB_USER || "root",
    password: process.env.DB_PASSWORD || "",
    database: process.env.DB_NAME || "mca_enquiry",
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// Test MySQL Connection
pool.getConnection()
    .then(connection => {
        console.log("✅ MySQL Connected");
        connection.release();
    })
    .catch(err => {
        console.log("❌ MySQL Connection Error:", err);
    });

// API Route
app.post("/enquiry", async (req, res) => {
    console.log("👉 DATA RECEIVED FROM FORM:", req.body); // DEBUG

    try {
        const { name, email, phone, course, message } = req.body;
        const query = "INSERT INTO enquiries (name, email, phone, course, message) VALUES (?, ?, ?, ?, ?)";
        await pool.execute(query, [name, email, phone, course, message]);
        console.log("✅ DATA SAVED");
        res.json({ success: true });
    } catch (err) {
        console.log("❌ SAVE ERROR:", err);
        res.json({ success: false });
    }
});

app.use(session({
    secret: process.env.SESSION_SECRET || "mca_admin_secret",
    resave: false,
    saveUninitialized: false,   // ⭐ VERY IMPORTANT
    cookie: {
        maxAge: 60 * 60 * 1000  // 1 hour
    }
}));

const ADMIN = {
    username: process.env.ADMIN_USERNAME || "admin",
    password: process.env.ADMIN_PASSWORD || "admin123"
};

app.post("/admin/login", (req, res) => {
    const { username, password } = req.body;

    if (username === ADMIN.username && password === ADMIN.password) {
        req.session.admin = true;
        res.json({ success: true });
    } else {
        res.json({ success: false });
    }
});

// Server Start
const PORT = process.env.PORT || 3000;
app.listen(PORT, '0.0.0.0', () => {
    console.log(`Server running at http://localhost:${PORT}`);
});

function checkAdmin(req, res, next) {
    if (req.session.admin) next();
    else res.status(401).json({ error: "Unauthorized" });
}

app.get("/admin/enquiries", checkAdmin, async (req, res) => {
    try {
        const [rows] = await pool.execute("SELECT * FROM enquiries ORDER BY date DESC");
        res.json(rows);
    } catch (err) {
        console.log("❌ FETCH ERROR:", err);
        res.status(500).json({ error: "Failed to fetch enquiries" });
    }
});

app.delete("/admin/enquiry/:id", checkAdmin, async (req, res) => {
    try {
        await pool.execute("DELETE FROM enquiries WHERE id = ?", [req.params.id]);
        res.json({ success: true });
    } catch (err) {
        console.log("❌ DELETE ERROR:", err);
        res.json({ success: false });
    }
});

// Middleware to check session for page access
function checkAdminPage(req, res, next) {
    if (req.session.admin) {
        next();
    } else {
        res.redirect("/admin-login.html");
    }
}

// Serve Admin Dashboard (Protected)
app.get("/admin.html", checkAdminPage, (req, res) => {
    res.sendFile(__dirname + "/private/admin.html");
});

