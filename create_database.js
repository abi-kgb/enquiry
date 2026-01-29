// Simple Node.js script to create the MySQL database and table
const mysql = require("mysql2/promise");

async function createDatabase() {
    try {
        // First connect without specifying database
        const connection = await mysql.createConnection({
            host: "localhost",
            user: "root",
            password: ""  // Add your MySQL password here if needed
        });

        console.log("✅ Connected to MySQL");

        // Create database
        await connection.query("CREATE DATABASE IF NOT EXISTS mca_enquiry");
        console.log("✅ Database 'mca_enquiry' created");

        // Use the database
        await connection.query("USE mca_enquiry");
        console.log("✅ Using database 'mca_enquiry'");

        // Create table
        const createTableQuery = `
            CREATE TABLE IF NOT EXISTS enquiries (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                course VARCHAR(255) NOT NULL,
                message TEXT,
                date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_date (date)
            )
        `;

        await connection.query(createTableQuery);
        console.log("✅ Table 'enquiries' created");

        // Verify table
        const [tables] = await connection.query("SHOW TABLES");
        console.log("\n📋 Tables in database:", tables);

        const [columns] = await connection.query("DESCRIBE enquiries");
        console.log("\n📋 Table structure:");
        console.table(columns);

        await connection.end();
        console.log("\n✅ Database setup complete! You can now start your server.");

    } catch (err) {
        console.error("❌ Error:", err.message);
        if (err.code === 'ECONNREFUSED') {
            console.error("\n⚠️  MySQL server is not running or not accessible.");
            console.error("   Please make sure MySQL is installed and running.");
        }
    }
}

createDatabase();
