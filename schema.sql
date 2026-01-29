-- Create database
CREATE DATABASE IF NOT EXISTS mca_enquiry;
USE mca_enquiry;

-- Create enquiries table
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
