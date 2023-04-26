Use Trackit;

SHOW TABLES;

SELECT * FROM users;
SELECT * FROM projects;
SELECT * FROM user_projects;
SELECT * FROM tickets;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE projects (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  projectName VARCHAR(255) NOT NULL,
  description TEXT
);

CREATE TABLE user_projects (
  id INT NOT NULL AUTO_INCREMENT,
  userId INT NOT NULL,
  projectId INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (userId) REFERENCES users(id),
  FOREIGN KEY (projectId) REFERENCES projects(id)
);

CREATE TABLE tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ticketName VARCHAR(255) NOT NULL,
  category VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'todo',
  projectId INT NOT NULL,
  FOREIGN KEY (projectId) REFERENCES projects (id)
);

SELECT projects.*
FROM projects
JOIN user_projects ON projects.id = user_projects.projectId
WHERE user_projects.userId = 1;

-- DROP TABLE users;
-- DROP TABLE tickets;
-- ALTER TABLE users DROP COLUMN id;

DESCRIBE users;
DESCRIBE projects;
DESCRIBE tickets;

INSERT INTO users (username, password) VALUES ('admin', 'a');
INSERT INTO users (username, password) VALUES ('DylanDinger', 'password456');
INSERT INTO user_projects (userId, projectId) VALUES (1, 10);

ALTER TABLE user_projects ADD CONSTRAINT unique_membership UNIQUE (userId, projectId);
-- DELETE FROM user_projects WHERE id = 4;
ALTER TABLE users
RENAME COLUMN email TO username;

