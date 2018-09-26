--  Create table Books
CREATE TABLE books (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(30) NOT NULL,
release_year YEAR NOT NULL,
format VARCHAR(50)
);

-- Insert Data to table books
INSERT INTO books (title, release_year, format) VALUES
('Cardinal', 1930, 'Norway'),
('sDddddss', 1950, 'fddss'),
('dfsdd', 1970, 'Mfldd');

--  Create table stars and Foreign key book_id
CREATE TABLE stars (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
books_id int UNSIGNED NOT NULL,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL
);

--  Add Foreign key to table stars
ALTER TABLE stars ADD FOREIGN KEY (books_id) REFERENCES books(id);

-- Insert Data to table stars
INSERT INTO stars (books_id, first_name, last_name) VALUES
(2, 'First_name 1', 'Last Name 1'),
(1, 'First_name 2', 'LastName 2'),
(3, 'First_name 3', 'LastName 3');