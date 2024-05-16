.headers on
.headers on
.mode columns
PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS SellerItem;
DROP TABLE IF EXISTS BuyerItem;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS WishList;
DROP TABLE IF EXISTS ChatMessage;
DROP TABLE IF EXISTS OrderItem;

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
    IsAdmin BOOLEAN DEFAULT FALSE,
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
    Stock INTEGER NOT NULL,
    Image_ TEXT,
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

CREATE TABLE ShoppingCart (
    ShoppingCartId INT AUTO_INCREMENT PRIMARY KEY DEFAULT 1,
    BuyerId INTEGER,
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
    CONSTRAINT ChatMessageId PRIMARY KEY (ChatMessageId)
    FOREIGN KEY (SenderId) REFERENCES User (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ReceiverId) REFERENCES User (UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE Images (
  id INTEGER PRIMARY KEY,
  title VARCHAR NOT NULL
);

CREATE TABLE OrderItem (
    OrderId INTEGER,
    ItemId INTEGER NOT NULL,
    Quantity INTEGER,
    BuyerId INTEGER NOT NULL,
    Adress NVARCHAR(160),
    City NVARCHAR(160),
    Country NVARCHAR(160),
    PostalCode NVARCHAR(160),
    CardNumber NVARCHAR(160),
    ExpirationDate VARCHAR(5),
    CVV VARCHAR(3),
    OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT OrderId PRIMARY KEY (OrderId)
    FOREIGN KEY (BuyerId) REFERENCES User(UserId)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item(ItemId)
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
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (1, 'johnydoe', 'John Doe', 'john@example.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', '123 Main St', 'Anytown', 'USA', '12345', false);
-- password123
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (2, 'janesmith', 'Jane Smith', 'jane@example.com', '0c6f6845bb8c62b778e9147c272ac4b5bdb9ae71', '456 Elm St', 'Othertown', 'USA', '67890', false);
-- password456
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (3, 'mick_jonh', 'Michael Johnson', 'michael@example.com', '7f6d5eea1bcef5ca6209d33b28e3aaeb3db26f24', '789 Oak St', 'Another Town', 'USA', '45678', false);
-- password789
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (4, 'embrown', 'Emily Brown', 'emily@example.com', '$2y$12$UhzD/36MRpktux7yj63RhuBaKi9/r1bHhBP7HhjAlNYC8TbPaHimy', '101 Pine St', 'Someplace', 'USA', '89012', true);
-- passwordabc
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (5, 'janedoe', 'Jane Doe', 'jane.doe@example.com', 'd5c2dc0bcfd8899ba126be5e729d4f10796c0b90', '456 Oak St', 'Sometown', 'USA', '54321',  false);
-- olaadeus23
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (6, 'markjohnson', 'Mark Johnson', 'mark.johnson@example.com', '752f5000777f76d06aa11a8882b70cc620e4deac', '789 Maple St', 'Anothertown', 'USA', '67890', false);
-- soufixe09
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (7, 'emilywilson', 'Emily Wilson', 'emily.wilson@example.com', 'f0219e4ecd66ed0df03a14df8d0891f02c216a1b', '101 Pine St', 'Yetanothertown', 'USA', '12345', false);
-- adeus5ola0
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (8, 'alexsmith', 'Alex Smith', 'alex.smith@example.com', '7375c583bb8ce9d2ff39b3ad224815a7c63ae0e6', '123 Elm St', 'Othertown', 'USA', '89012', false);
-- girafas_bonitas5
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (9, 'sarahbrown', 'Sarah Brown', 'sarah.brown@example.com', '507bb50fa8856af531bdcd68e552d2e57561a8e4', '321 Cedar St', 'Somewhere', 'USA', '45678', false);
-- naogosto8gelado
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (10, 'michaeljones', 'Michael Jones', 'michael.jones@example.com', '0c644c9f5e7b0062607c6677838fd0ee8399f5a7', '567 Pineapple St', 'Anywhere', 'USA', '13579', '0');
-- pretoebranc0



--Populate Item table
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (101, 'Sapphire Bracelet', 29, 'Blue Jewelers', 'SB2024', 'New', 'Beads and bracelets', 1, '/../pages/imgs/imgsForItems/item1.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (102, 'Emerald Earrings', 5, 'Green Gems', 'EE2024', 'Used', 'Earrings', 3, '/../pages/imgs/imgsForItems/item1.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (103, 'Amethyst Ring', 25, 'Purple Jewelry', 'AR2024', 'New', 'Rings', 2, '/../pages/imgs/imgsForItems/item1.jpg', 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (104, 'Topaz Necklace', 30, 'Golden Treasures', 'TN2024', 'Used', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item1.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (105, 'Diamond Necklace', 500, 'Diamonds Inc.', 'DN2024', 'New', 'Necklaces', 10, '/../pages/imgs/imgsForItems/item1.jpg', 1);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (106, 'Gold Bracelet', 350, 'Gold Empire', 'GB2024', 'New', 'Beads and bracelets', 5, '/../pages/imgs/imgsForItems/item1.jpg', 2);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (107, 'Silver Earrings', 80, 'Silver Works', 'SE2024', 'New', 'Earrings', 8, '/../pages/imgs/imgsForItems/item1.jpg', 3);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (108, 'Ruby Ring', 300, 'Gemstone Jewelry', 'RR2024', 'New', 'Rings', 3, '/../pages/imgs/imgsForItems/item1.jpg', 4);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (109, 'Pearl Necklace', 200, 'Pearl Paradise', 'PN2024', 'New', 'Necklaces', 6, '/../pages/imgs/imgsForItems/item1.jpg', 5);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (110, 'Leather Watch', 150, 'Watch Co.', 'LW2024', 'New', 'Clocks', 4, '/../pages/imgs/imgsForItems/item1.jpg', 6);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (111, 'Sapphire Pendant', 180, 'Blue Stone Creations', 'SP2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item1.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (112, 'Emerald Brooch', 90, 'Emerald Designs', 'EB2024', 'New', 'Accessories', 3, '/../pages/imgs/imgsForItems/item1.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (113, 'Gold Bangle', 220, 'Golden Touch', 'GB2024', 'New', 'Beads and bracelets', 1, '/../pages/imgs/imgsForItems/item1.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (114, 'Diamond Pendant Necklace', 300, 'Diamond Dreams', 'DPN2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item1.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (115, 'Diamond Stud Earrings', 150, 'Luxury Jewels', 'DSE2024', 'New', 'Earrings', 3, '/../pages/imgs/imgsForItems/item1.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (116, 'Pearl Necklace', 80, 'Ocean Pearls', 'PN2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item1.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (117, 'Ruby Bracelet', 100, 'Red Gemstones', 'RB2024', 'New', 'Beads and bracelets', 1, '/../pages/imgs/imgsForItems/item1.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (118, 'Gold Chain', 200, 'Golden Creations', 'GC2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item1.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (119, 'Silver Hoop Earrings', 50, 'Silver Treasures', 'SHE2024', 'New', 'Earrings', 3, '/../pages/imgs/imgsForItems/item1.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (120, 'Opal Ring', 120, 'Opal Jewelry Co.', 'OR2024', 'New', 'Rings', 2, '/../pages/imgs/imgsForItems/item1.jpg', 9);



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
*/
INSERT INTO SellerItem (UserId, ItemId)
VALUES (4, 104);

--Populate ShoppingCart table
--INSERT INTO ShoppingCart (ShoppingCartId, BuyerId, ItemId, Quantity)
--VALUES (1, 4, 101, 2);

--Populate Wishlist table
INSERT INTO Wishlist (WishListId, BuyerId, ItemId)
VALUES (1, 4, 101);



