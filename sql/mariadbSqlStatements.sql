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
                       workEnd TIME,
                       password VARCHAR(255) NOT NULL
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

INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'admin', 'admin1', 'Hans-Werner', 'Kahlbohm', '08141453315', NULL, NULL, '$2y$10$unsd6crph57cdzNCcv4JaOsvNdj0Jdtvgum2qZW29NQxpcvUw4THG');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer1', 'Thies', 'Schönwälder', '06838283528', NULL, NULL, '$2y$10$f/SbDt9PNetB9I3uXWzg5.fSTMRh0Ti2k2vYjoUtvEEvoEJyLeiqG');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer2', 'Anita', 'Epple', '0281807502', NULL, NULL, '$2y$10$GCSm4IykbvheXdppcQAi6u4UMdSeFVstdMtpMf2uMVQHbRBJltIse');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer3', 'Sonja', 'Cassirer', '07221310501', NULL, NULL, '$2y$10$k36s8KmU0NQIMMeJp0.eausKuqiJT5VX8Nm0mr5iq0nz6YBphFmJW');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer4', 'Erwin', 'Hollmann', '02747137730', NULL, NULL, '$2y$10$pqLte80AAuslMTtVw4WymOOEyR6Dj00BEQwcm/bk6BR3Ufaaa0jUa');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer5', 'Elena', 'Mezger', '06831602754', NULL, NULL, '$2y$10$aTCVBsWr5sdNOIFrujQtme.Xfuu1fSAeWdQFpe3pkyefU/3fKQ/Sq');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer6', 'Irma', 'Berentelg', '06333270066', NULL, NULL, '$2y$10$OR8wqVSRM362dpEo4nRqG.KCKW0M7cgGD8zS9W8LJHoaFUH4KRWfC');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer7', 'Florian', 'Hertz', '02655265108', NULL, NULL, '$2y$10$YsiAuGsh0TfJKHLKolaY3OutEzswfudkAaXiYD/pIIQi9r9YOlLXy');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer8', 'Karla', 'Nicolaus', '08452138953', NULL, NULL, '$2y$10$s2Lfkzv5jh8vFCjMkVvFAOUCMqaT5CTZ7y3C85utADiO6K0RdRWAu');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'customer', 'customer9', 'Leonard', 'Pakuscher', '06241283449', NULL, NULL, '$2y$10$9J3LsfMbmBif8jE8i2ob0.Ndk8e.09EY9PXjYF1ra447cAjjSS8KK');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'barber', 'barber1', 'Alpha', 'Andy', '0541117929', '08:00', '16:00', '$2y$10$l2gVu3Ormk2BOwxnaTs9Z.AvgZ.aJmed7rXef4JkPFOfdNhttksdq');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'barber', 'barber2', 'Beta', 'Bea', '07729658764', '08:00', '16:00', '$2y$10$RQEPi5iB.S3HGR.W8Zn37emaV1NIN0y4Iiohx1jCwStSJi.ecze8.');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'barber', 'barber3', 'Cindy', 'Crawford', '06394919723', '09:00', '17:00', '$2y$10$coE6woIPaNmUl8odx89peuq8gEZ.HROrD3cZPJGMG9XYLLor8PPqO');
INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, 'barber', 'barber4', 'Dicke', 'Donna', '02351753407', '09:00', '17:00', '$2y$10$0BWq8T5iejJFegFeP1NUwOQOYQQUG4f/V/gIvpk4Ie1ZHj/B6lNwm');

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 11:00:00', '2023-02-21 11:30:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 12:00:00', '2023-02-21 12:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 15:00:00', '2023-02-21 15:30:00', 11, 14);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 09:00:00', '2023-02-21 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-21 11:00:00', '2023-02-21 12:00:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-22 14:30:00', '2023-02-22 15:00:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-22 15:30:00', '2023-02-22 16:00:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-23 10:30:00', '2023-02-23 11:30:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-23 12:00:00', '2023-02-23 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-24 15:00:00', '2023-02-24 16:00:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-24 15:00:00', '2023-02-24 16:00:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-25 15:00:00', '2023-02-25 16:00:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-25 09:00:00', '2023-02-25 09:30:00', 14, 11);

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-28 11:00:00', '2023-02-28 11:30:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-02-28 12:00:00', '2023-02-28 12:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-01 15:00:00', '2023-03-01 15:30:00', 11, 14);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-01 09:00:00', '2023-03-01 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-02 11:00:00', '2023-03-02 11:30:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-02 14:30:00', '2023-03-02 15:30:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 15:30:00', '2023-03-03 16:30:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 10:30:00', '2023-03-03 11:00:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 12:00:00', '2023-03-03 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-03 15:00:00', '2023-03-03 15:30:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-04 15:00:00', '2023-03-04 15:30:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-04 15:00:00', '2023-03-04 15:30:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-04 09:00:00', '2023-03-04 09:30:00', 14, 11);

INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-07 11:30:00', '2023-03-07 12:30:00', 14, 12);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-07 13:00:00', '2023-03-07 13:30:00', 12, 13);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-08 15:30:00', '2023-03-08 16:00:00', 11, 14);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-08 09:00:00', '2023-03-08 09:30:00', 11, 2);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-09 12:00:00', '2023-03-09 12:30:00', 12, 3);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-09 15:30:00', '2023-03-09 16:00:00', 13, 4);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-10 15:30:00', '2023-03-10 16:30:00', 14, 5);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-10 10:00:00', '2023-03-10 10:30:00', 13, 6);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-10 12:00:00', '2023-03-10 12:30:00', 12, 7);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-10 14:00:00', '2023-03-10 14:30:00', 11, 8);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-11 12:00:00', '2023-03-11 12:30:00', 13, 9);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-11 13:00:00', '2023-03-11 14:30:00', 12, 10);
INSERT INTO appointments (id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '2023-03-11 09:00:00', '2023-03-11 09:30:00', 14, 11);

DELIMITER //
DROP TRIGGER IF EXISTS insert_user;
CREATE TRIGGER insert_user
    BEFORE INSERT
    ON users
    FOR EACH ROW
BEGIN
    IF NEW.role = 'barber' THEN
        IF NEW.workStart IS NULL OR NEW.workEnd IS NULL THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Bitte Start- und Endzeit für den Frisör eintragen';
        END IF;
    END IF;
END //
DELIMITER ;

DELIMITER //
DROP TRIGGER IF EXISTS update_user;
CREATE TRIGGER update_user
    BEFORE UPDATE
    ON users
    FOR EACH ROW
BEGIN
    IF NEW.role = 'barber' THEN
        IF NEW.workStart IS NULL OR NEW.workEnd IS NULL THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Bitte Start- und Endzeit für den Frisör eintragen';
        END IF;
    END IF;
END //
DELIMITER ;


SELECT * FROM users;
SELECT * FROM appointments;
use barbershop;