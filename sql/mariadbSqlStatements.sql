DROP DATABASE IF EXISTS barbershop;
CREATE DATABASE barbershop;
USE barbershop;
CREATE TABLE users (
                       id INT PRIMARY KEY AUTO_INCREMENT,
                       role ENUM('admin', 'customer', 'barber') NOT NULL,
                       name VARCHAR(45) NOT NULL UNIQUE,
                       firstName VARCHAR(45) NOT NULL,
                       lastName VARCHAR(45) NOT NULL,
                       telephone VARCHAR(45) NOT NULL,
                       workStart TIME,
                       workEnd TIME
);
CREATE TABLE appointments (
                              id INT PRIMARY KEY AUTO_INCREMENT,
                              slotStart DATETIME NOT NULL,
                              slotEnd DATETIME NOT NULL,
                              barber_id INT NOT NULL,
                              user_id INT NOT NULL,
                              FOREIGN KEY(barber_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
                              FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'admin', 'admin1', 'Hans-Werner', 'Kahlbohm', '08141453315', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer1', 'Thies', 'Schönwälder', '06838283528', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer2', 'Anita', 'Epple', '0281807502', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer3', 'Sonja', 'Cassirer', '07221310501', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer4', 'Erwin', 'Hollmann', '02747137730', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer5', 'Elena', 'Mezger', '06831602754', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer6', 'Irma', 'Berentelg', '06333270066', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer7', 'Florian', 'Hertz', '02655265108', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer8', 'Karla', 'Nicolaus', '08452138953', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'customer', 'customer9', 'Leonard', 'Pakuscher', '06241283449', NULL, NULL);
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'barber', 'barber1', 'Alpha', 'Andy', '0541117929', '08:00', '16:00');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'barber', 'barber2', 'Beta', 'Bea', '07729658764', '08:00', '16:00');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'barber', 'barber3', 'Cindy', 'Crawford', '06394919723', '09:00', '17:00');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, 'barber', 'barber4', 'Dicke', 'Donna', '02351753407', '09:00', '17:00');

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-09 09:00:00', '2023-02-09 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-09 11:00:00', '2023-02-09 12:00:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-09 14:30:00', '2023-02-09 15:00:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-09 15:30:00', '2023-02-09 16:00:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-10 10:30:00', '2023-02-10 11:30:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-10 12:00:00', '2023-02-10 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-10 15:00:00', '2023-02-10 16:00:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-10 15:00:00', '2023-02-10 16:00:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-11 15:00:00', '2023-02-11 16:00:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-11 09:00:00', '2023-02-11 09:30:00', 14, 11);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-11 11:00:00', '2023-02-11 12:00:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-11 12:00:00', '2023-02-11 12:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-11 15:00:00', '2023-02-11 15:30:00', 11, 14);

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-14 11:00:00', '2023-02-11 12:00:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-14 12:00:00', '2023-02-11 12:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-14 15:00:00', '2023-02-11 15:30:00', 11, 14);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-15 09:00:00', '2023-02-09 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-15 11:00:00', '2023-02-09 12:00:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-15 14:30:00', '2023-02-09 15:00:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-16 15:30:00', '2023-02-09 16:00:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-16 10:30:00', '2023-02-10 11:30:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-16 12:00:00', '2023-02-10 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-17 15:00:00', '2023-02-10 16:00:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-17 15:00:00', '2023-02-10 16:00:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-18 15:00:00', '2023-02-11 16:00:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-18 09:00:00', '2023-02-11 09:30:00', 14, 11);

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 11:00:00', '2023-02-11 12:00:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 12:00:00', '2023-02-11 12:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 15:00:00', '2023-02-11 15:30:00', 11, 14);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 09:00:00', '2023-02-09 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 11:00:00', '2023-02-09 12:00:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-22 14:30:00', '2023-02-09 15:00:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-22 15:30:00', '2023-02-09 16:00:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-23 10:30:00', '2023-02-10 11:30:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-23 12:00:00', '2023-02-10 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-24 15:00:00', '2023-02-10 16:00:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-24 15:00:00', '2023-02-10 16:00:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-25 15:00:00', '2023-02-11 16:00:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-25 09:00:00', '2023-02-11 09:30:00', 14, 11);

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-28 11:00:00', '2023-02-11 12:00:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-28 12:00:00', '2023-02-11 12:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-01 15:00:00', '2023-02-11 15:30:00', 11, 14);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-01 09:00:00', '2023-02-09 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-02 11:00:00', '2023-02-09 12:00:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-02 14:30:00', '2023-02-09 15:00:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 15:30:00', '2023-02-09 16:00:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 10:30:00', '2023-02-10 11:30:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 12:00:00', '2023-02-10 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 15:00:00', '2023-02-10 16:00:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-04 15:00:00', '2023-02-10 16:00:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-04 15:00:00', '2023-02-11 16:00:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-04 09:00:00', '2023-02-11 09:30:00', 14, 11);

SELECT * FROM users;
SELECT * FROM appointments;
use barbershop;
