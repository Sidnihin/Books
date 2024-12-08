CREATE TABLE authors (
                         id SERIAL PRIMARY KEY,
                         name VARCHAR(100) NOT NULL
);

CREATE TABLE books (
                       id SERIAL PRIMARY KEY,
                       title VARCHAR(200) NOT NULL
);

CREATE TABLE author_book (
                             author_id INT REFERENCES authors(id),
                             book_id INT REFERENCES books(id),
                             PRIMARY KEY (author_id, book_id)
);

-- Данные для авторов
INSERT INTO authors (name) VALUES
                               ('J.K. Rowling'),
                               ('George R.R. Martin'),
                               ('J.R.R. Tolkien'),
                               ('Agatha Christie'),
                               ('Stephen King'),
                               ('Arthur Conan Doyle'),
                               ('Leo Tolstoy'),
                               ('Fyodor Dostoevsky'),
                               ('Jane Austen'),
                               ('Mark Twain');

-- Данные для книг
INSERT INTO books (title) VALUES
                              ('Harry Potter and the Sorcerer''s Stone'),
                              ('Harry Potter and the Chamber of Secrets'),
                              ('A Game of Thrones'),
                              ('A Clash of Kings'),
                              ('The Fellowship of the Ring'),
                              ('The Two Towers'),
                              ('Murder on the Orient Express'),
                              ('The Shining'),
                              ('It'),
                              ('The Adventures of Sherlock Holmes'),
                              ('War and Peace'),
                              ('Anna Karenina'),
                              ('Crime and Punishment'),
                              ('Pride and Prejudice'),
                              ('Sense and Sensibility'),
                              ('The Adventures of Tom Sawyer'),
                              ('The Adventures of Huckleberry Finn'),
                              ('The Winds of Winter'),
                              ('Carrie'),
                              ('The Hobbit'),
                              ('And Then There Were None'),
                              ('Doctor Zhivago'),
                              ('Bleak House'),
                              ('David Copperfield'),
                              ('Oliver Twist'),
                              ('Great Expectations'),
                              ('Emma'),
                              ('Persuasion'),
                              ('The Great Gatsby'),
                              ('To Kill a Mockingbird');

-- Связи авторов и книг
INSERT INTO author_book (author_id, book_id) VALUES
                                                 (1, 1), (1, 2),
                                                 (2, 3), (2, 4), (2, 18),
                                                 (3, 5), (3, 6), (3, 20),
                                                 (4, 7), (4, 21),
                                                 (5, 8), (5, 9), (5, 19),
                                                 (6, 10), (6, 22),
                                                 (7, 11), (7, 12),
                                                 (8, 13),
                                                 (9, 14), (9, 15),
                                                 (10, 16), (10, 17);