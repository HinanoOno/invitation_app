DROP DATABASE IF EXISTS posse;

CREATE DATABASE posse;

USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
INSERT INTO users (email,password) VALUES ('hinagon1231@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.');

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
    image VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
INSERT INTO user_details (user_id,name,university,faculty,grade,posse,discord_user_id) VALUES (1,'小野','慶應','理工',3,'①','1231','img1.jpg');

DROP TABLE IF EXISTS plans;
CREATE TABLE plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO plans (name) VALUES ('業務'), ('縦モク/横モク/MU'), ('カリキュラム'), ('その他');

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
    status BOOLEAN NOT NULL,
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
