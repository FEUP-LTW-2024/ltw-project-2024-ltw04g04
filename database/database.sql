.headers on
.headers on
.mode columns
PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS SellerItem;
DROP TABLE IF EXISTS BuyerItem;
DROP TABLE IF EXISTS Admi;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS WishList;


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


CREATE TABLE Category
(
    CategoryName VARCHAR(50) NOT NULL,
    CONSTRAINT CategoryName PRIMARY KEY (CategoryName)
);

CREATE TABLE Item
(
    ItemId INTEGER NOT NULL,
    Name_ INTEGER NOT NULL,
    Price INTEGER NOT NULL, 
    Brand VARCHAR(50) NOT NULL,
    Model VARCHAR(50) NOT NULL,
    Condition VARCHAR(50) NOT NULL,
    Category VARCHAR(50) NOT NULL,
    Image_ BLOB,
    Size_ INTEGER NOT NULL,
    CONSTRAINT ItemId PRIMARY KEY  (ItemId)
    FOREIGN KEY (Category) REFERENCES Category (CategoryName)
);


CREATE TABLE ShoppingCart (
    ShoppingCartId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES Buyer (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE WishList (
    WishListId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES Buyer (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);



/*******************************************************************************
   Populate Tables
********************************************************************************/

INSERT INTO Category (CategoryName) VALUES ('Beads and bracelets');
INSERT INTO Category (CategoryName) VALUES ('Earrings');
INSERT INTO Category (CategoryName) VALUES ('Rings');
INSERT INTO Category (CategoryName) VALUES ('Necklaces');
INSERT INTO Category (CategoryName) VALUES ('Accessories');
INSERT INTO Category (CategoryName) VALUES ('Clocks');


-- Populate User table
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (1, 'johnydoe', 'John Doe', 'john@example.com', 'password123', '123 Main St', 'Anytown', 'USA', '12345');
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (2, 'janesmith', 'Jane Smith', 'jane@example.com', 'password456', '456 Elm St', 'Othertown', 'USA', '67890');
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (3, 'mick_jonh', 'Michael Johnson', 'michael@example.com', 'password789', '789 Oak St', 'Another Town', 'USA', '45678');
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode)
VALUES (4, 'embrown', 'Emily Brown', 'emily@example.com', 'passwordabc', '101 Pine St', 'Someplace', 'USA', '89012');


--Populate Item table
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (101, 'Name1', 29, 'Brand A', 'Model X', 'New', 'Beads and bracelets', NULL, 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (102, 'Name2', 5, 'Brand B', 'Model Y', 'Used', 'Earrings', NULL, 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (103, 'Name3', 25, 'Brand C', 'Model Z', 'New', 'Rings', NULL, 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Image_, Size_)
VALUES (104, 'Name4', 30, 'Brand D', 'Model W', 'Used', 'Necklaces', NULL, 10);


--Populate SellerItem table
/*INSERT INTO SellerItem (UserId, ItemId)
VALUES (1, 101);
INSERT INTO SellerItem (UserId, ItemId)
VALUES (2, 102);
INSERT INTO SellerItem (UserId, ItemId)
VALUES (3, 103);
INSERT INTO SellerItem (UserId, ItemId)
VALUES (4, 104);*/
