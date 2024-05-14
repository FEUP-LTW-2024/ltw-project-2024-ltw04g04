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

CREATE TABLE ShoppingCart (
    ShoppingCartId INTEGER,
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
VALUES (1, 'johnydoe', 'John Doe', 'john@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', '123 Main St', 'Anytown', 'USA', '12345', false);
-- password123
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (2, 'janesmith', 'Jane Smith', 'jane@example.com', 'c6ba91b90d922e159893f46c387e5dc1b3dc5c101a5a4522f03b987177a24a91', '456 Elm St', 'Othertown', 'USA', '67890', false);
-- password456
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (3, 'mick_jonh', 'Michael Johnson', 'michael@example.com', '5efc2b017da4f7736d192a74dde5891369e0685d4d38f2a455b6fcdab282df9c', '789 Oak St', 'Another Town', 'USA', '45678', false);
-- password789
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (4, 'embrown', 'Emily Brown', 'emily@example.com', '963c8b37b3615f3c7f88cbb0f6becff1ffe726f4', '101 Pine St', 'Someplace', 'USA', '89012', true);
-- passwordabc
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (5, 'janedoe', 'Jane Doe', 'jane.doe@example.com', 'cb7136bb81e63b9dd98c4736bade626b6685d3a6a22129075416dd88afaf075d', '456 Oak St', 'Sometown', 'USA', '54321',  false);
-- olaadeus23
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (6, 'markjohnson', 'Mark Johnson', 'mark.johnson@example.com', '71154ca37013e686b818dad0a16c584c8253d4ed892068cad81c5e9642e0c0c4', '789 Maple St', 'Anothertown', 'USA', '67890', false);
-- soufixe09
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (7, 'emilywilson', 'Emily Wilson', 'emily.wilson@example.com', '55729422f621f9d6fef830924ea4c74f3db4f3aac1017d4e98a8011fd5304130', '101 Pine St', 'Yetanothertown', 'USA', '12345', false);
-- adeus5ola0
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (8, 'alexsmith', 'Alex Smith', 'alex.smith@example.com', 'bd09f7ad06c6ca58501394524cdddf77f50dbcc28df10f67fc7f06af329abf8b', '123 Elm St', 'Othertown', 'USA', '89012', false);
-- girafas_bonitas5
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (9, 'sarahbrown', 'Sarah Brown', 'sarah.brown@example.com', 'd0430590a251acc9ed7744831a7a8a51705689cff6ba141f8bf82a15d9f5b415', '321 Cedar St', 'Somewhere', 'USA', '45678', false);
-- naogosto8gelado
INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (10, 'michaeljones', 'Michael Jones', 'michael.jones@example.com', '1f4b817f73ca25b782ee67c5822f6ebcbd62c76b90bc3b5448bb17f0632f56db', '567 Pineapple St', 'Anywhere', 'USA', '13579', '0');
-- pretoebranc0



--Populate Item table
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (101, 'Sapphire Bracelet', 29, 'Blue Jewelers', 'SB2024', 'New', 'Beads and bracelets', 1, '/pages/imgs/itemId1', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (102, 'Emerald Earrings', 5, 'Green Gems', 'EE2024', 'Used', 'Earrings', 3, NULL, 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (103, 'Amethyst Ring', 25, 'Purple Jewelry', 'AR2024', 'New', 'Rings', 2, NULL, 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (104, 'Topaz Necklace', 30, 'Golden Treasures', 'TN2024', 'Used', 'Necklaces', 5, NULL, 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (105, 'Diamond Necklace', 500, 'Diamonds Inc.', 'DN2024', 'New', 'Necklaces', 10, NULL, 1);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (106, 'Gold Bracelet', 350, 'Gold Empire', 'GB2024', 'New', 'Beads and bracelets', 5, NULL, 2);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (107, 'Silver Earrings', 80, 'Silver Works', 'SE2024', 'New', 'Earrings', 8, NULL, 3);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (108, 'Ruby Ring', 300, 'Gemstone Jewelry', 'RR2024', 'New', 'Rings', 3, NULL, 4);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (109, 'Pearl Necklace', 200, 'Pearl Paradise', 'PN2024', 'New', 'Necklaces', 6, NULL, 5);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (110, 'Leather Watch', 150, 'Watch Co.', 'LW2024', 'New', 'Clocks', 4, NULL, 6);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (111, 'Sapphire Pendant', 180, 'Blue Stone Creations', 'SP2024', 'New', 'Necklaces', 5, NULL, 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (112, 'Emerald Brooch', 90, 'Emerald Designs', 'EB2024', 'New', 'Accessories', 3, NULL, 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (113, 'Gold Bangle', 220, 'Golden Touch', 'GB2024', 'New', 'Beads and bracelets', 1, NULL, 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (114, 'Diamond Pendant Necklace', 300, 'Diamond Dreams', 'DPN2024', 'New', 'Necklaces', 5, NULL, 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (115, 'Diamond Stud Earrings', 150, 'Luxury Jewels', 'DSE2024', 'New', 'Earrings', 3, NULL, 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (116, 'Pearl Necklace', 80, 'Ocean Pearls', 'PN2024', 'New', 'Necklaces', 5, NULL, 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (117, 'Ruby Bracelet', 100, 'Red Gemstones', 'RB2024', 'New', 'Beads and bracelets', 1, NULL, 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (118, 'Gold Chain', 200, 'Golden Creations', 'GC2024', 'New', 'Necklaces', 5, NULL, 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (119, 'Silver Hoop Earrings', 50, 'Silver Treasures', 'SHE2024', 'New', 'Earrings', 3, NULL, 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (120, 'Opal Ring', 120, 'Opal Jewelry Co.', 'OR2024', 'New', 'Rings', 2, NULL, 9);



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
INSERT INTO ShoppingCart (ShoppingCartId, BuyerId, ItemId, Quantity)
VALUES (1, 4, 101, 2);

--Populate Wishlist table
INSERT INTO Wishlist (WishListId, BuyerId, ItemId)
VALUES (1, 4, 101);



