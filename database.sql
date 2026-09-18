-- Optional manual import. If you just run login.php / register.php,
-- config.php will auto-create this database and these tables for you.

CREATE DATABASE IF NOT EXISTS smart_travel_planner CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smart_travel_planner;

CREATE TABLE IF NOT EXISTS service_providers (
 provider_id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(120) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 phone VARCHAR(30),
 company_name VARCHAR(150),
 address VARCHAR(255),
 profile_image VARCHAR(255),
 status ENUM('active','suspended','pending') DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS listings (
 listing_id INT AUTO_INCREMENT PRIMARY KEY,
 provider_id INT NOT NULL,
 listing_type ENUM('Travel Package','Hotel','Transport') NOT NULL,
 name VARCHAR(180) NOT NULL,
 destination VARCHAR(150) NOT NULL,
 description TEXT,
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 availability INT NOT NULL DEFAULT 0,
 image VARCHAR(255),
 status ENUM('active','inactive') DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (provider_id) REFERENCES service_providers(provider_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bookings (
 booking_id INT AUTO_INCREMENT PRIMARY KEY,
 listing_id INT NOT NULL,
 provider_id INT NOT NULL,
 customer_name VARCHAR(120) NOT NULL,
 customer_email VARCHAR(150),
 booking_date DATE NOT NULL,
 guests INT NOT NULL DEFAULT 1,
 total_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
 status ENUM('Pending','Confirmed','Rejected','Completed') DEFAULT 'Pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (listing_id) REFERENCES listings(listing_id) ON DELETE CASCADE,
 FOREIGN KEY (provider_id) REFERENCES service_providers(provider_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS notifications (
 notification_id INT AUTO_INCREMENT PRIMARY KEY,
 provider_id INT NOT NULL,
 booking_id INT NULL,
 message VARCHAR(255) NOT NULL,
 is_read TINYINT(1) DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (provider_id) REFERENCES service_providers(provider_id) ON DELETE CASCADE,
 FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS feedback (
 feedback_id INT AUTO_INCREMENT PRIMARY KEY,
 provider_id INT NOT NULL,
 listing_id INT NULL,
 customer_name VARCHAR(120) NOT NULL,
 rating TINYINT NOT NULL,
 comment TEXT,
 reply TEXT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (provider_id) REFERENCES service_providers(provider_id) ON DELETE CASCADE,
 FOREIGN KEY (listing_id) REFERENCES listings(listing_id) ON DELETE SET NULL,
 CHECK (rating BETWEEN 1 AND 5)
);

-- No demo/dummy data. Create a real account via register.php.
