.headers on
.headers on
.mode columns
PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS SellerItem;
DROP TABLE IF EXISTS BuyerItem;
DROP TABLE IF EXISTS Admi;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS WishList;
DROP TABLE IF EXISTS ChatMessage;


/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE User
(
    UserId INTEGER,
    Username NVARCHAR(160)  NOT NULL,
    Name_ NVARCHAR(160)  NOT NULL,
    Email NVARCHAR(160)  NOT NULL,
    Password_ NVARCHAR(160)  NOT NULL,
    Adress NVARCHAR(160),
    City NVARCHAR(160),
    Country NVARCHAR(160),
    PostalCode NVARCHAR(160),
    CONSTRAINT UserId PRIMARY KEY (UserId)
);

CREATE TABLE Category
(
    CategoryId INTEGER,
    CategoryName VARCHAR(50) UNIQUE NOT NULL,
    CONSTRAINT CategoryId PRIMARY KEY (CategoryId)
);

CREATE TABLE Item
(
    ItemId INTEGER NOT NULL,
    Name_ INTEGER NOT NULL,
    Price INTEGER NOT NULL, 
    Brand VARCHAR(50) NOT NULL,
    Model VARCHAR(50) NOT NULL,
    Condition VARCHAR(50) NOT NULL,
    Category INTEGER NOT NULL,
    Image_ BLOB,
    Size_ INTEGER NOT NULL,
    CONSTRAINT ItemId PRIMARY KEY (ItemId)
    FOREIGN KEY (Category) REFERENCES Category (CategoryName)
);

CREATE TABLE SellerItem
(
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE BuyerItem
(
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE Admi
(
    UserId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE ShoppingCart (
    ShoppingCartId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    Quantity INTEGER NOT NULL DEFAULT 1,
    FOREIGN KEY (BuyerId) REFERENCES User (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE WishList (
    WishListId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES User (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE ChatMessage (
    ChatMessageId INTEGER,
    SenderId INTEGER NOT NULL,
    ReceiverId INTEGER NOT NULL,
    Message_ TEXT NOT NULL,
    Date_ VARCHAR(50) NOT NULL,
    Time_ VARCHAR(50) NOT NULL,
    FOREIGN KEY (SenderId) REFERENCES User (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ReceiverId) REFERENCES User (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);


/*******************************************************************************
   Populate Tables
********************************************************************************/


-- Populate Category table
INSERT INTO Category (CategoryId, CategoryName) VALUES (1, 'Beads and bracelets');
INSERT INTO Category (CategoryId, CategoryName) VALUES (2, 'Earrings');
INSERT INTO Category (CategoryId, CategoryName) VALUES (3, 'Rings');
INSERT INTO Category (CategoryId, CategoryName) VALUES (4, 'Necklaces');
INSERT INTO Category (CategoryId, CategoryName) VALUES (5, 'Accessories');
INSERT INTO Category (CategoryId, CategoryName) VALUES (6, 'Clocks');


-- Populate User table
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (1, 'johnydoe', 'John Doe', 'john@example.com', 'password123', '123 Main St', 'Anytown', 'USA', '12345');
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (2, 'janesmith', 'Jane Smith', 'jane@example.com', 'password456', '456 Elm St', 'Othertown', 'USA', '67890');
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (3, 'mick_jonh', 'Michael Johnson', 'michael@example.com', 'password789', '789 Oak St', 'Another Town', 'USA', '45678');
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (4, 'embrown', 'Emily Brown', 'emily@example.com', '963c8b37b3615f3c7f88cbb0f6becff1ffe726f4', '101 Pine St', 'Someplace', 'USA', '89012');
-- passwordabc

--Populate Item table
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (101, 'Name1', 29, 'Brand A', 'Model X', 'New', 'Beads and bracelets', NULL, 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (102, 'Name2', 5, 'Brand B', 'Model Y', 'Used', 'Earrings', NULL, 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (103, 'Name3', 25, 'Brand C', 'Model Z', 'New', 'Rings', NULL, 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (104, 'Name4', 30, 'Brand D', 'Model W', 'Used', 'Necklaces', NULL, 10);

--Populate ChatMessage table
INSERT INTO ChatMessage (ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_)
VALUES (1, 1, 4, 'ola!', '25/4/2024', '12h40');
INSERT INTO ChatMessage (ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_)
VALUES (2, 4, 1, 'hey', '25/4/2024', '14h40');
INSERT INTO ChatMessage (ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_)
VALUES (3, 4, 2, 'tudo bem amigo?', '27/4/2024', '19h40');

--Populate SellerItem table
INSERT INTO SellerItem (UserId, ItemId)
VALUES (1, 101);
/*
INSERT INTO SellerItem (UserId, ItemId)
VALUES (2, 102);
INSERT INTO SellerItem (UserId, ItemId)
VALUES (3, 103);
INSERT INTO SellerItem (UserId, ItemId)
VALUES (4, 104);*/

--Populate ShoppingCart table
INSERT INTO ShoppingCart (ShoppingCartId, BuyerId, ItemId)
VALUES (1, 4, 101);  

