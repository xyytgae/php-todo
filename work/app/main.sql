DROP TABLE IF EXISTS todos;

CREATE TABLE IF NOT EXISTS todos (
    id INT NOT NULL AUTO_INCREMENT,
    is_editing BOOL DEFAULT false,
    title TEXT,
    PRIMARY KEY (id)
);