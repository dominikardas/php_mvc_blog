DROP DATABASE IF EXISTS MVC_Blog;
CREATE DATABASE MVC_Blog;

USE MVC_Blog;

CREATE TABLE IF NOT EXISTS Users (

    userId INT AUTO_INCREMENT NOT NULL,

    fname VARCHAR(64),
    lname VARCHAR(64),

    username VARCHAR(64),
    password VARCHAR(64),
    email VARCHAR(64),
    
    profilePicture VARCHAR(64),

    PRIMARY KEY (userId)
);

CREATE TABLE IF NOT EXISTS Categories (

    categoryId INT AUTO_INCREMENT NOT NULL,
    categoryName VARCHAR(64) UNIQUE,
    categoryTitle VARCHAR(64),

    PRIMARY KEY (categoryId)
);

CREATE TABLE IF NOT EXISTS Posts(

    postId INT AUTO_INCREMENT NOT NULL,
    
    title VARCHAR(128) NOT NULL,
    slug VARCHAR(50) NOT NULL,
    published BOOLEAN,
    publishedAt DATE,
    smallDesc TEXT,
    content TEXT,
    postImage VARCHAR(255) NOT NULL,
    authorName VARCHAR(128) NOT NULL,
    categoryName VARCHAR(64) NOT NULL,

    PRIMARY KEY (postId)
);

-- Test data

INSERT INTO Users (fname, lname, username) VALUES ('Dominik', 'Kardas', 'dominik');

INSERT INTO Categories (categoryName, categoryTitle) VALUES 
    ('category1', 'First category'), 
    
    ('category2', 'Second category'), 
    
    ('category3', 'Third category');