DROP DATABASE IF EXISTS MVC_Blog;
CREATE DATABASE MVC_Blog;

USE MVC_Blog;

CREATE TABLE IF NOT EXISTS Users (

    userId INT AUTO_INCREMENT NOT NULL,

    fname VARCHAR(64),
    lname VARCHAR(64),

    username VARCHAR(64),
    password VARCHAR(64),

    isAdmin BOOLEAN,

    PRIMARY KEY (userId)
);

CREATE TABLE IF NOT EXISTS Categories (

    categoryId INT AUTO_INCREMENT NOT NULL,
    categoryName VARCHAR(64) UNIQUE,
    categoryDisplay VARCHAR(64),
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

INSERT INTO Users (fname, lname, username, isAdmin) VALUES ('Dominik', 'Kardas', 'dominik', 'true');

INSERT INTO Categories (categoryName, categoryDisplay, categoryTitle) VALUES 
    ('category1', 'Category 1', 'First category'), 
    
    ('category2', 'Category 2','Second category'), 
    
    ('category3', 'Category 3','Third category');