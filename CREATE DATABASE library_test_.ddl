CREATE DATABASE library_test;
USE library_test;

CREATE TABLE IF NOT EXISTS books (
    ISBN VARCHAR(50) PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Copyright VARCHAR(10),
    Edition VARCHAR(50),
    Price DECIMAL(10, 2),
    Qty INT
);