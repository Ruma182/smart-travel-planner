CREATE DATABASE IF NOT EXISTS smart_travel_local_explorer CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smart_travel_local_explorer;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'Local Explorer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS local_explorer (
    explorer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    location VARCHAR(150) NOT NULL,
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS local_recommendation (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    explorer_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100),
    location VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (explorer_id) REFERENCES local_explorer(explorer_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS destination_info (
    info_id INT AUTO_INCREMENT PRIMARY KEY,
    explorer_id INT NOT NULL,
    destination_id INT NOT NULL DEFAULT 0,
    description TEXT,
    photos VARCHAR(255),
    visiting_guidelines TEXT,
    recommended_activities TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (explorer_id) REFERENCES local_explorer(explorer_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS travel_tip (
    tip_id INT AUTO_INCREMENT PRIMARY KEY,
    explorer_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (explorer_id) REFERENCES local_explorer(explorer_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS question_response (
    response_id INT AUTO_INCREMENT PRIMARY KEY,
    explorer_id INT NOT NULL,
    traveler_id INT NOT NULL,
    question TEXT NOT NULL,
    response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (explorer_id) REFERENCES local_explorer(explorer_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS explorer_feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    explorer_id INT NOT NULL,
    traveler_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (explorer_id) REFERENCES local_explorer(explorer_id) ON DELETE CASCADE
);
