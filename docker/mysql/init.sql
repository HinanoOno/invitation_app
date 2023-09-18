DROP DATABASE IF EXISTS posse;

CREATE DATABASE posse;

USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
INSERT INTO users (email,password) VALUES ('suzuki@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'), ('k.keio1256@gmail.com', '$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.') ,('hinagon1231@gmail.com', '$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('chiyoko@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('haruka@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('ryudai@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('jun@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.'),('taiki@gmail.com','$2y$10$tG4YEwUHd6.op.tMSYDoCufeFj83bk/AzRhm2L2V/Q48w5WXf03j.');

DROP TABLE IF EXISTS user_details;
CREATE TABLE user_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255),
    university VARCHAR(255),
    faculty VARCHAR(255),
    grade DECIMAL(5,1),
    posse VARCHAR(255),
    discord_user_id VARCHAR(255),
    image VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
INSERT INTO user_details (user_id,name,university,faculty,grade,posse,discord_user_id,image) VALUES (1,'鈴木大騎','慶應義塾','商',3.5,'①','1038013869949464616','suzukitaiki.jpeg'),(2,'岩城和輝','慶應義塾','経済',3.0,'①','1031514540304760852', 'kazu.JPG'),(3,'小野媛乃','慶應義塾','理工',3.0,'①','1031511085745983518', 'hinano.jpg'),(4,'林千翼子','慶應義塾','商',1.0,'①','1026860996637245560','chiyoko.jpg'),(5,'三木晴加','慶應義塾','商',1.5,'①','1026860989586608148', 'haruka.JPG'),(6,'穴田竜大','慶應義塾','理工',1.5,'①','923134354056691722', 'ryudai.jpg'),(7,'石井潤','立教','経営',1.0,'①','1031511009480949800', 'jun.jpg'),(8,'檀野太紀','慶應義塾','環境情報',1.5,'①','698827317400829962', 'taiki.jpg');
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
INSERT INTO calendars (date, start_time, end_time, userdetail_id) VALUES
('2023-09-06', '01:00:00', '04:00:00', 6),
('2023-09-17', '01:00:00', '04:00:00', 2),
('2023-09-16', '01:00:00', '04:00:00', 4),
('2023-09-23', '01:00:00', '04:00:00', 7),
('2023-09-18', '01:00:00', '04:00:00', 8),
('2023-09-09', '01:00:00', '04:00:00', 1),
('2023-09-30', '01:00:00', '04:00:00', 2),
('2023-09-11', '01:00:00', '04:00:00', 1),
('2023-09-23', '01:00:00', '04:00:00', 8),
('2023-09-17', '01:00:00', '04:00:00', 5),
('2023-09-08', '01:00:00', '04:00:00', 4),
('2023-09-05', '01:00:00', '04:00:00', 5),
('2023-09-02', '01:00:00', '04:00:00', 5),
('2023-09-16', '01:00:00', '04:00:00', 1),
('2023-09-08', '01:00:00', '04:00:00', 8),
('2023-09-26', '01:00:00', '04:00:00', 6),
('2023-09-15', '01:00:00', '04:00:00', 5),
('2023-09-09', '01:00:00', '04:00:00', 3),
('2023-09-17', '01:00:00', '04:00:00', 2),
('2023-09-11', '01:00:00', '04:00:00', 1),
('2023-09-18', '01:00:00', '04:00:00', 6),
('2023-09-28', '01:00:00', '04:00:00', 1),
('2023-09-12', '01:00:00', '04:00:00', 8),
('2023-09-15', '01:00:00', '04:00:00', 1),
('2023-09-16', '01:00:00', '04:00:00', 2),
('2023-09-29', '01:00:00', '04:00:00', 2),
('2023-09-01', '01:00:00', '04:00:00', 3),
('2023-09-06', '01:00:00', '04:00:00', 3),
('2023-09-22', '01:00:00', '04:00:00', 4),
('2023-09-16', '01:00:00', '04:00:00', 7),
('2023-09-18', '01:00:00', '04:00:00', 1),
('2023-09-05', '01:00:00', '04:00:00', 4),
('2023-09-09', '01:00:00', '04:00:00', 4),
('2023-09-24', '01:00:00', '04:00:00', 2),
('2023-09-12', '01:00:00', '04:00:00', 6),
('2023-09-28', '01:00:00', '04:00:00', 6),
('2023-09-30', '01:00:00', '04:00:00', 5),
('2023-09-25', '01:00:00', '04:00:00', 3),
('2023-09-27', '01:00:00', '04:00:00', 3),
('2023-09-13', '01:00:00', '04:00:00', 5),
('2023-09-01', '01:00:00', '04:00:00', 7),
('2023-09-06', '01:00:00', '04:00:00', 2),
('2023-09-03', '01:00:00', '04:00:00', 6),
('2023-09-27', '01:00:00', '04:00:00', 4),
('2023-09-15', '01:00:00', '04:00:00', 8),
('2023-09-10', '01:00:00', '04:00:00', 6),
('2023-09-09', '01:00:00', '04:00:00', 2),
('2023-09-11', '01:00:00', '04:00:00', 2),
('2023-09-23', '01:00:00', '04:00:00', 2),
('2023-09-27', '01:00:00', '04:00:00', 4),
('2023-09-13', '01:00:00', '04:00:00', 3),
('2023-09-25', '01:00:00', '04:00:00', 4),
('2023-09-21', '01:00:00', '04:00:00', 1),
('2023-09-12', '01:00:00', '04:00:00', 2),
('2023-09-01', '01:00:00', '04:00:00', 4),
('2023-09-07', '01:00:00', '04:00:00', 7),
('2023-09-28', '01:00:00', '04:00:00', 5),
('2023-09-07', '01:00:00', '04:00:00', 5),
('2023-09-11', '01:00:00', '04:00:00', 4);




DROP TABLE IF EXISTS userDetail_plan;
CREATE TABLE userDetail_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userDetail_id INT NOT NULL,
    plan_id INT ,
    status BOOLEAN NOT NULL,
    FOREIGN KEY (userDetail_id) REFERENCES user_details(id),
    FOREIGN KEY (plan_id) REFERENCES plans(id)
);
INSERT INTO userDetail_plan (userDetail_id,plan_id,status) VALUES (7,3,1),(3,2,1),(4,4,1),(5,5,1);



DROP TABLE IF EXISTS calendar_plan;
CREATE TABLE calendar_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plan_id INT NOT NULL,
    calendar_id INT NOT NULL,
    FOREIGN KEY (plan_id) REFERENCES plans(id),
    FOREIGN KEY (calendar_id) REFERENCES calendars(id)
);

INSERT INTO calendar_plan (plan_id,calendar_id) VALUES (3,1),(4,2),(3,3),(3,4),(2,5),(4,6),(2,7),(4,8),(1,9),(1,10),(5,11),(3,12),(1,13),(5,14),(3,15),(3,16),(1,17),(4,18),(4,19),(5,20),(5,21),(3,22),(1,23),(1,24),(4,25),(5,26),(2,27),(3,28),(1,29),(2,30),(3,31),(1,32),(2,33),(5,34),(4,35),(5,36),(5,37),(1,38),(2,39),(3,40),(5,41),(4,42),(5,43),(5,44),(5,45),(1,46),(2,47),(3,48),(5,49),(4,50),(1,51),(4,52),(1,53),(2,54),(5,55),(2,56),(2,57),(2,58);
