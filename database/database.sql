.headers on
.headers on
.mode columns
PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS SellerItems;
DROP TABLE IF EXISTS BuyerItems;
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
    Name_ NVARCHAR(160)  NOT NULL,
    Email NVARCHAR(160)  NOT NULL,
    Password_ NVARCHAR(160)  NOT NULL,
    Adress NVARCHAR(160),
    City NVARCHAR(160),
    Country NVARCHAR(160),
    PostalCode NVARCHAR(160),
    CONSTRAINT UserId PRIMARY KEY (UserId)
);

CREATE TABLE SellerItems
(
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE BuyerItems
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
INSERT INTO Category (CategoryName) VALUES ('BNecklaces');
INSERT INTO Category (CategoryName) VALUES ('Accessories');
INSERT INTO Category (CategoryName) VALUES ('Clocks');
