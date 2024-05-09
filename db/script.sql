CREATE DATABASE tasklist;

USE tasklist;

CREATE TABLE users(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(90) NOT NULL,
    email VARCHAR(120) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NULL
)ENGINE=InnoDB;

CREATE TABLE tasks(

    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    taskname VARCHAR(90) NOT NULL,
    situation ENUM('À FAZER', 'CONCLUÍDA', 'CANCELADA') DEFAULT 'À FAZER',
    user_id INT NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)

)Engine=InnoDB;