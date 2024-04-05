.headers on
.headers on
.mode columns
PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Seller;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Admi;
DROP TABLE IF EXISTS Buyer;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS WishList;


/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE User
(
    UserId INTEGER NOT NULL,
    Name_ NVARCHAR(160)  NOT NULL,
    Username NVARCHAR(160)  NOT NULL,
    Email NVARCHAR(160)  NOT NULL,
    Password_ NVARCHAR(160)  NOT NULL
    CONSTRAINT UserId PRIMARY KEY  (UserId)
);

CREATE TABLE Seller
(
    UserId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION,
);

CREATE TABLE Buyer
(
    UserId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION,
);

CREATE TABLE Admi
(
    UserId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION,
);

CREATE TABLE Item
(
    ItemId INTEGER NOT NULL,
    Brand VARCHAR(50) NOT NULL,
    Model VARCHAR(50) NOT NULL,
    Condition VARCHAR(50) NOT NULL,
    image_ BLOB,
    Size_ INTEGER NOT NULL,
    CONSTRAINT ItemId PRIMARY KEY  (ItemId)
);

CREATE TABLE ShoppingCart (
    ShoppingCartId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES Buyer(UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item(ItemId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE WishList (
    WishListId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES Buyer(UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item(ItemId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);


/*******************************************************************************
   Create Foreign Keys
********************************************************************************/
