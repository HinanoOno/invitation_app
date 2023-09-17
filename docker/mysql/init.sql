DROP DATABASE IF EXISTS posse;

CREATE DATABASE posse;

USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS user_details;
CREATE TABLE user_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255),
    university VARCHAR(255),
    faculty VARCHAR(255),
    grade DECIMAL(5,2),
    posse VARCHAR(255),
    discord_user_id VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

DROP TABLE IF EXISTS plans;
CREATE TABLE plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS calendars;
CREATE TABLE calendars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    start_time TIME,
    end_time TIME,
    userdetail_id INT NOT NULL,
    FOREIGN KEY (userdetail_id) REFERENCES user_details(id)
);

DROP TABLE IF EXISTS userDetail_plan;
CREATE TABLE userDetail_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userDetail_id INT NOT NULL,
    plan_id INT NOT NULL,
    status VARCHAR(50),
    FOREIGN KEY (userDetail_id) REFERENCES user_details(id),
    FOREIGN KEY (plan_id) REFERENCES plans(id)
);

DROP TABLE IF EXISTS calendar_plan;
CREATE TABLE calendar_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plan_id INT NOT NULL,
    calendar_id INT NOT NULL,
    FOREIGN KEY (plan_id) REFERENCES plans(id),
    FOREIGN KEY (calendar_id) REFERENCES calendars(id)
);
