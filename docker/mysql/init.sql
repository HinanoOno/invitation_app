DROP DATABASE IF EXISTS posse;

CREATE DATABASE posse;

USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
INSERT INTO users (email,password) VALUES ('taiki@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'), ('k.keio1256@gmail.com', '$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.') ,('hinagon1231@gmail.com', '$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('chiyoko@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('suzuki@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('haruka@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('ryudai@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('jun@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('taiki@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.');

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
INSERT INTO user_details (user_id,name,university,faculty,grade,posse,discord_user_id,image) VALUES (1,'鈴木大騎','慶應義塾','商',3.5,'①','1038013869949464616','suzuki.jpeg'),(2,'岩城和輝','慶應義塾','経済',3.0,'①','1031514540304760852', 'kazu.JPG'),(3,'小野媛乃','慶應義塾','理工',3.0,'①','1031511085745983518', 'hinano.jpg'),(4,'林千翼子','慶應義塾','商',1.0,'①','1026860996637245560','chiyoko.jpg'),(5,'三木晴加','慶應義塾','商',1.5,'①','1026860989586608148', 'haruka.JPG'),(6,'穴田竜大','慶應義塾','理工',1.5,'①','923134354056691722', 'ryudai.jpg'),(7,'石井潤','立教','経営',1.0,'①','1031511009480949800', 'jun.jpg'),(8,'壇野太紀','慶應義塾','環境情報',1.5,'①','698827317400829962', 'taiki.jpg');
;

DROP TABLE IF EXISTS plans;
CREATE TABLE plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO plans (name) VALUES ('業務'), ('縦・横モク'), ('カリキュラム'), ('MU'), ('その他');

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
