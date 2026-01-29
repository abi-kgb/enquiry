# MySQL Setup Instructions

## Prerequisites
1. Install MySQL Server on your system if not already installed
2. Make sure MySQL is running

## Setup Steps

### 1. Install Dependencies
```bash
npm install
```

This will install the `mysql2` package that replaced `mongoose`.

### 2. Create MySQL Database
Run the following SQL commands in your MySQL client (e.g., MySQL Workbench, phpMyAdmin, or command line):

```sql
CREATE DATABASE IF NOT EXISTS mca_enquiry;
USE mca_enquiry;

CREATE TABLE IF NOT EXISTS enquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  course VARCHAR(255) NOT NULL,
  message TEXT,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_date (date)
);
```

**Or** run the provided schema file from the command line:
```bash
mysql -u root -p < schema.sql
```

### 3. Configure Database Connection
Create a `.env` file in the root directory and add your MySQL settings:

```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=your_password_here
DB_NAME=mca_enquiry
PORT=3000
SESSION_SECRET=your_secret_here
ADMIN_USERNAME=admin
ADMIN_PASSWORD=admin123
```

The `server.js` file is already configured to read these variables automatically.

### 4. Start the Server
```bash
npm start
```

Or for development with auto-restart:
```bash
npm run dev
```

### 5. Verify Connection
When the server starts, you should see:
```
✅ MySQL Connected
Server running at http://localhost:3000
```

## Key Changes from MongoDB

| Feature | MongoDB | MySQL |
|---------|---------|-------|
| ID Field | `_id` (ObjectId) | `id` (Auto-increment INT) |
| Driver | mongoose | mysql2 |
| Connection | Direct connection | Connection pool |
| Insert | `new Model().save()` | `INSERT` query |
| Find All | `.find().sort()` | `SELECT ... ORDER BY` |
| Delete | `.findByIdAndDelete()` | `DELETE WHERE id = ?` |

## Troubleshooting

### Connection Error
If you see "❌ MySQL Connection Error":
- Verify MySQL is running
- Check username/password in server.js
- Ensure database `mca_enquiry` exists

### Table doesn't exist
Run the schema.sql file to create the table.

### Port already in use
If port 3000 is already in use, change the port in server.js line 77.
