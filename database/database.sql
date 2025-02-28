.headers on
.headers on
.mode columns
PRAGMA FOREIGN_KEYS = ON;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Condition;
DROP TABLE IF EXISTS Size_;
DROP TABLE IF EXISTS Model;
DROP TABLE IF EXISTS Brand;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS SellerItem;
DROP TABLE IF EXISTS BuyerItem;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS WishList;
DROP TABLE IF EXISTS ChatMessage;
DROP TABLE IF EXISTS OrderItem;
DROP TABLE IF EXISTS SellerRating;

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
    ProfileImage TEXT,
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

CREATE TABLE Model
(
    ModelId INTEGER,
    ModelName VARCHAR(50) UNIQUE NOT NULL,
    CONSTRAINT ModelId PRIMARY KEY (ModelId)
);

CREATE TABLE Brand
(
    BrandId INTEGER,
    BrandName VARCHAR(50) UNIQUE NOT NULL,
    CONSTRAINT BrandId PRIMARY KEY (BrandId)
);

CREATE TABLE Condition
(
    ConditionId INTEGER,
    ConditionName VARCHAR(50) UNIQUE NOT NULL,
    CONSTRAINT ConditionId PRIMARY KEY (ConditionId)
);

CREATE TABLE Size_
(
    SizeId INTEGER,
    SizeVal INTEGER UNIQUE NOT NULL,
    CONSTRAINT SizeId PRIMARY KEY (SizeId)
);

CREATE TABLE Item
(
    ItemId INTEGER NOT NULL,
    Name_ NVARCHAR(160)  NOT NULL,
    Price INTEGER NOT NULL, 
    Brand VARCHAR(50) NOT NULL,
    Model VARCHAR(50) NOT NULL,
    Condition VARCHAR(50) NOT NULL,
    Category INTEGER NOT NULL,
    Stock INTEGER NOT NULL,
    Image_ TEXT,
    Size_ INTEGER NOT NULL,
    CONSTRAINT ItemId PRIMARY KEY (ItemId),
    FOREIGN KEY (Category) REFERENCES Category (CategoryName)
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (Model) REFERENCES Model (ModelName)
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (Brand) REFERENCES Brand (BrandName)
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (Condition) REFERENCES Condition (ConditionName)
        ON DELETE NO ACTION ON UPDATE NO ACTION
    FOREIGN KEY (Size_) REFERENCES Size_ (SizeVal)
        ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE SellerItem
(
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
        ON DELETE CASCADE ON UPDATE CASCADE
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE BuyerItem
(
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
        ON DELETE CASCADE ON UPDATE CASCADE
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ShoppingCart (
    ShoppingCartId INTEGER,
    BuyerId INTEGER,
    ItemId INTEGER NOT NULL,
    Quantity INTEGER NOT NULL DEFAULT 1,
    CONSTRAINT ShoppingCartId PRIMARY KEY (ShoppingCartId)
    FOREIGN KEY (BuyerId) REFERENCES User (UserId)
        ON DELETE CASCADE ON UPDATE NO ACTION
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId)
        ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE WishList (
    WishListId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES User (UserId)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES Item (ItemId)
        ON DELETE CASCADE ON UPDATE CASCADE
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
        ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (ItemId) REFERENCES Item(ItemId)
        ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE SellerRating (
    RatingId INTEGER PRIMARY KEY,
    SellerId INTEGER NOT NULL,
    RaterId INTEGER NOT NULL,
    Rating INTEGER NOT NULL CHECK(Rating >= 1 AND Rating <= 5),
    FOREIGN KEY (SellerId) REFERENCES User(UserId)
        ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (RaterId) REFERENCES User(UserId)
        ON DELETE CASCADE ON UPDATE NO ACTION
);


/*******************************************************************************
   Triggers
********************************************************************************/

CREATE TRIGGER item_delete_cart
AFTER DELETE ON Item
FOR EACH ROW
BEGIN
    DELETE FROM ShoppingCart WHERE ItemId = OLD.ItemId;
END;


CREATE TRIGGER item_delete_wishlist
AFTER DELETE ON Item
FOR EACH ROW
BEGIN
    DELETE FROM WishList WHERE ItemId = OLD.ItemId;
END;


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

-- Populate Size table
INSERT INTO Size_ (SizeId, SizeVal) VALUES (1, 1);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (2, 2);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (3, 3);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (4, 4);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (5, 5);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (6, 6);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (7, 7);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (8, 8);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (9, 9);
INSERT INTO Size_ (SizeId, SizeVal) VALUES (10, 10);

-- Populate User table
INSERT INTO User (UserId, Username, Name_, Email, Password_, ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (1, 'johnydoe', 'John Doe', 'john@example.com', '$2y$12$M.LBS3MI2km/1ygZqPgON.6xGYu1EFpjWtQJ6bHeciwgRoW9ytZ4K','/../pages/imgs/imgsForProfile/user1.jpg', '123 Main St', 'Anytown', 'USA', '12345', false);
-- Jooe1996

INSERT INTO User (UserId, Username, Name_, Email, Password_,ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (2, 'janesmith', 'Jane Smith', 'jane@example.com', '$2y$12$u6KWrcQy6dni8OuGkGELEe1Ar5ZmTlF05pOh/tpH3EYhicYE8Qzjm','/../pages/imgs/imgsForProfile/user2.jpg', '456 Elm St', 'Othertown', 'USA', '67890', false);
-- password456

INSERT INTO User (UserId, Username, Name_, Email, Password_,ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (3, 'mick_jonh', 'Michael Johnson', 'michael@example.com', '$2y$12$psmZQiJrw6G9IYpHncAiRu46sgkMtNa1gRXsEvBLIOwB9Uai8lHhu','/../pages/imgs/imgsForProfile/user3.jpg', '789 Oak St', 'Another Town', 'USA', '45678', false);
-- password789

INSERT INTO User (UserId, Username, Name_, Email, Password_, ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (4, 'embrown', 'Emily Brown', 'emily@example.com', '$2y$12$UhzD/36MRpktux7yj63RhuBaKi9/r1bHhBP7HhjAlNYC8TbPaHimy', '/../pages/imgs/imgsForProfile/cat.jpg', '101 Pine St', 'Someplace', 'USA', '89012', true);
-- passwordabc

INSERT INTO User (UserId, Username, Name_, Email, Password_,ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (5, 'janedoe', 'Jane Doe', 'jane.doe@example.com', '$2y$12$mYIREu6jvIP4dMBhbAA6huVIn0I.0Gynw8Lk3wexZoDgIVoefdi0i','/../pages/imgs/imgsForProfile/user5.jpg', '456 Oak St', 'Sometown', 'USA', '54321',  false);
-- olaadeus23

INSERT INTO User (UserId, Username, Name_, Email, Password_,ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (6, 'markjohnson', 'Mark Johnson', 'mark.johnson@example.com', '$2y$12$uNRNrA884zEjsZUEsZdTQOgbIXd.YuoZngYq8FjUrNjNp1qFNr7Zy','/../pages/imgs/imgsForProfile/user6.jpg', '789 Maple St', 'Anothertown', 'USA', '67890', false);
-- soufixe09

INSERT INTO User (UserId, Username, Name_, Email, Password_,ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (7, 'emilywilson', 'Emily Wilson', 'emily.wilson@example.com', '$2y$12$SBmPTty8/CwWvzGMa3TIk.MUmpSTpiRNbbArfzQeBB3MDPd7TrW2K','/../pages/imgs/imgsForProfile/user7.jpg', '101 Pine St', 'Yetanothertown', 'USA', '12345', false);
-- adeUs5ola0

INSERT INTO User (UserId, Username, Name_, Email, Password_,ProfileImage, Adress, City, Country, PostalCode, IsAdmin)
VALUES (8, 'alexsmith', 'Alex Smith', 'alex.smith@example.com', '$2y$12$omlp4.V8W/8tmABj0.9EJO2kwfFPGCx0j.mH9qErszFxjE0DL2E..','/../pages/imgs/imgsForProfile/user8.jpg', '123 Elm St', 'Othertown', 'USA', '89012', false);
-- girafas_bonitas5

INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (9, 'sarahbrown', 'Sarah Brown', 'sarah.brown@example.com', '$2y$12$YiETOsqls8mk1zbyP5AG5uausnnr5jcyoNnrjTvN7dWiYD8gEMjPe', '321 Cedar St', 'Somewhere', 'USA', '45678', false);
-- naogosto8gelado

INSERT INTO User (UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode, IsAdmin)
VALUES (10, 'michaeljones', 'Michael Jones', 'michael.jones@example.com', '$2y$12$0AdjcyrjwQaB6yd7Apa61ObuRiblm2j0HlvT9igGblp57fF.ddFDS', '567 Pineapple St', 'Anywhere', 'USA', '13579', '0');
-- pretoebranc0


-- Populate Rating table
INSERT INTO SellerRating (RatingId, SellerId, RaterId, Rating)
VALUES (1, 1, 2, 4),
       (2, 1, 3, 5),
       (3, 1, 4, 3),
       (4, 2, 1, 5),
       (5, 2, 3, 4),
       (6, 2, 5, 4),
       (7, 3, 1, 3),
       (8, 3, 2, 4),
       (9, 3, 6, 2),
       (10, 4, 1, 5),
       (11, 4, 2, 4),
       (12, 4, 3, 4),
       (13, 5, 1, 3),
       (14, 5, 4, 4),
       (15, 5, 7, 5),
       (16, 6, 1, 4),
       (17, 6, 2, 3),
       (18, 6, 8, 4),
       (19, 7, 1, 5),
       (20, 7, 3, 4),
       (21, 7, 5, 3),
       (22, 8, 1, 4),
       (23, 8, 2, 5),
       (24, 8, 9, 3),
       (25, 9, 1, 4),
       (26, 9, 3, 3),
       (27, 9, 10, 5),
       (28, 10, 1, 3),
       (29, 10, 4, 4),
       (30, 10, 6, 2);


-- Populando Condition
INSERT INTO Condition (ConditionId, ConditionName)
VALUES (1, 'New');
INSERT INTO Condition (ConditionId, ConditionName)
VALUES (2, 'Used');
INSERT INTO Condition (ConditionId, ConditionName)
VALUES (3, 'Refurbished');
INSERT INTO Condition (ConditionId, ConditionName)
VALUES (4, 'Like New');
INSERT INTO Condition (ConditionId, ConditionName)
VALUES (5, 'Damaged');

-- Populando Brand
INSERT INTO Brand (BrandId, BrandName)
VALUES (1, 'Blue Jewelers');
INSERT INTO Brand (BrandId, BrandName)
VALUES (2, 'Green Gems');
INSERT INTO Brand (BrandId, BrandName)
VALUES (3, 'Purple Jewelry');
INSERT INTO Brand (BrandId, BrandName)
VALUES (4, 'Golden Treasures');
INSERT INTO Brand (BrandId, BrandName)
VALUES (5, 'Diamonds Inc.');
INSERT INTO Brand (BrandId, BrandName)
VALUES (6, 'Gold Empire');
INSERT INTO Brand (BrandId, BrandName)
VALUES (7, 'Silver Works');
INSERT INTO Brand (BrandId, BrandName)
VALUES (8, 'Gemstone Jewelry');
INSERT INTO Brand (BrandId, BrandName)
VALUES (9, 'Pearl Paradise');
INSERT INTO Brand (BrandId, BrandName)
VALUES (10, 'Watch Co.');
INSERT INTO Brand (BrandId, BrandName)
VALUES (11, 'Blue Stone Creations');
INSERT INTO Brand (BrandId, BrandName)
VALUES (12, 'Emerald Designs');
INSERT INTO Brand (BrandId, BrandName)
VALUES (13, 'Golden Touch');
INSERT INTO Brand (BrandId, BrandName)
VALUES (14, 'Diamond Dreams');
INSERT INTO Brand (BrandId, BrandName)
VALUES (15, 'Luxury Jewels');
INSERT INTO Brand (BrandId, BrandName)
VALUES (16, 'Ocean Pearls');
INSERT INTO Brand (BrandId, BrandName)
VALUES (17, 'Red Gemstones');
INSERT INTO Brand (BrandId, BrandName)
VALUES (18, 'Golden Creations');
INSERT INTO Brand (BrandId, BrandName)
VALUES (19, 'Silver Treasures');
INSERT INTO Brand (BrandId, BrandName)
VALUES (20, 'Opal Jewelry Co.');

-- Populando Model
INSERT INTO Model (ModelId, ModelName)
VALUES (1, 'SB2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (2, 'EE2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (3, 'AR2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (4, 'TN2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (5, 'DN2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (6, 'GB2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (7, 'SE2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (8, 'RR2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (9, 'PN2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (10, 'LW2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (11, 'SP2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (12, 'EB2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (13, 'DPN2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (14, 'DSE2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (16, 'RB2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (17, 'GC2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (18, 'SHE2024');
INSERT INTO Model (ModelId, ModelName)
VALUES (19, 'OR2024');

--Populate Item table
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (101, 'Sapphire Bracelet', 29, 'Blue Jewelers', 'SB2024', 'New', 'Beads and bracelets', 1, '/../pages/imgs/imgsForItems/item1.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (102, 'Emerald Earrings', 5, 'Green Gems', 'EE2024', 'Used', 'Earrings', 3, '/../pages/imgs/imgsForItems/item2.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (103, 'Amethyst Ring', 25, 'Purple Jewelry', 'AR2024', 'New', 'Rings', 2, '/../pages/imgs/imgsForItems/item3.jpg', 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (104, 'Topaz Necklace', 30, 'Golden Treasures', 'TN2024', 'Used', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item4.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (105, 'Diamond Necklace', 500, 'Diamonds Inc.', 'DN2024', 'New', 'Necklaces', 10, '/../pages/imgs/imgsForItems/item5.jpg', 1);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (106, 'Gold Bracelet', 350, 'Gold Empire', 'GB2024', 'New', 'Beads and bracelets', 5, '/../pages/imgs/imgsForItems/item6.jpg', 2);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (107, 'Silver Earrings', 80, 'Silver Works', 'SE2024', 'New', 'Earrings', 8, '/../pages/imgs/imgsForItems/item7.jpg', 3);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (108, 'Ruby Ring', 300, 'Gemstone Jewelry', 'RR2024', 'New', 'Rings', 3, '/../pages/imgs/imgsForItems/item8.jpg', 4);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (109, 'Pearl Necklace', 200, 'Pearl Paradise', 'PN2024', 'New', 'Necklaces', 6, '/../pages/imgs/imgsForItems/item9.jpg', 5);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (110, 'Leather Watch', 150, 'Watch Co.', 'LW2024', 'New', 'Clocks', 4, '/../pages/imgs/imgsForItems/item10.jpg', 6);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (111, 'Sapphire Pendant', 180, 'Blue Stone Creations', 'SP2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item11.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (112, 'Emerald Brooch', 90, 'Emerald Designs', 'EB2024', 'New', 'Accessories', 3, '/../pages/imgs/imgsForItems/item12.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (113, 'Gold Bangle', 220, 'Golden Touch', 'GB2024', 'New', 'Beads and bracelets', 1, '/../pages/imgs/imgsForItems/item13.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (114, 'Diamond Pendant Necklace', 300, 'Diamond Dreams', 'DPN2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item14.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (115, 'Diamond Stud Earrings', 150, 'Luxury Jewels', 'DSE2024', 'New', 'Earrings', 3, '/../pages/imgs/imgsForItems/item15.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (116, 'Pearl Necklace', 80, 'Ocean Pearls', 'PN2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item16.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (117, 'Ruby Bracelet', 100, 'Red Gemstones', 'RB2024', 'New', 'Beads and bracelets', 1, '/../pages/imgs/imgsForItems/item17.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (118, 'Gold Chain', 200, 'Golden Creations', 'GC2024', 'New', 'Necklaces', 5, '/../pages/imgs/imgsForItems/item18.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (119, 'Silver Hoop Earrings', 50, 'Silver Treasures', 'SHE2024', 'New', 'Earrings', 3, '/../pages/imgs/imgsForItems/item19.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (120, 'Opal Ring', 120, 'Opal Jewelry Co.', 'OR2024', 'New', 'Rings', 2, '/../pages/imgs/imgsForItems/item20.jpg', 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (121, 'Turquoise Bracelet', 45, 'Blue Jewelers', 'SB2024', 'New', 'Beads and bracelets', 4, '/../pages/imgs/imgsForItems/item21.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (122, 'Onyx Earrings', 60, 'Green Gems', 'EE2024', 'New', 'Earrings', 6, '/../pages/imgs/imgsForItems/item22.jpg', 8);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (123, 'Sapphire Ring', 250, 'Blue Jewelers', 'SB2024', 'New', 'Rings', 3, '/../pages/imgs/imgsForItems/item23.jpg', 9);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (124, 'Emerald Pendant', 150, 'Emerald Designs', 'EB2024', 'New', 'Necklaces', 2, '/../pages/imgs/imgsForItems/item24.jpg', 10);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (125, 'Quartz Watch', 80, 'Watch Co.', 'LW2024', 'Used', 'Clocks', 5, '/../pages/imgs/imgsForItems/item25.jpg', 6);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (126, 'Silver Bracelet', 55, 'Silver Works', 'SE2024', 'New', 'Beads and bracelets', 4, '/../pages/imgs/imgsForItems/item26.jpg', 7);
INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (127, 'Gold Earrings', 100, 'Golden Touch', 'GB2024', 'New', 'Earrings', 3, '/../pages/imgs/imgsForItems/item27.jpg', 8);


INSERT INTO Item (ItemId, Name_, Price, Brand, Model, Condition, Category, Stock, Image_, Size_)
VALUES (130, 'Topaz Earrings', 90, 'Golden Treasures', 'TN2024', 'New', 'Earrings', 5, '/../pages/imgs/imgsForItems/item30.jpg', 8);




--Populate ChatMessage table
INSERT INTO ChatMessage (ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_)
VALUES (1, 1, 4, 'ola!', '25/4/2024', '12h40');
INSERT INTO ChatMessage (ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_)
VALUES (2, 4, 1, 'hey', '25/4/2024', '14h40');
INSERT INTO ChatMessage (ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_)
VALUES (3, 4, 2, 'tudo bem amigo?', '27/4/2024', '19h40');

--Populate SellerItem table
INSERT INTO SellerItem (UserId, ItemId) VALUES (1, 101);
INSERT INTO SellerItem (UserId, ItemId) VALUES (1, 130);
INSERT INTO SellerItem (UserId, ItemId) VALUES (2, 127);
INSERT INTO SellerItem (UserId, ItemId) VALUES (2, 102);
INSERT INTO SellerItem (UserId, ItemId) VALUES (3, 103);
INSERT INTO SellerItem (UserId, ItemId) VALUES (4, 104);
INSERT INTO SellerItem (UserId, ItemId) VALUES (4, 105);
INSERT INTO SellerItem (UserId, ItemId) VALUES (4, 106);
INSERT INTO SellerItem (UserId, ItemId) VALUES (4, 126);
INSERT INTO SellerItem (UserId, ItemId) VALUES (4, 125);
INSERT INTO SellerItem (UserId, ItemId) VALUES (5, 124);
INSERT INTO SellerItem (UserId, ItemId) VALUES (5, 123);
INSERT INTO SellerItem (UserId, ItemId) VALUES (5, 107);
INSERT INTO SellerItem (UserId, ItemId) VALUES (5, 108);
INSERT INTO SellerItem (UserId, ItemId) VALUES (6, 109);
INSERT INTO SellerItem (UserId, ItemId) VALUES (6, 122);
INSERT INTO SellerItem (UserId, ItemId) VALUES (7, 121);
INSERT INTO SellerItem (UserId, ItemId) VALUES (7, 110);
INSERT INTO SellerItem (UserId, ItemId) VALUES (7, 111);
INSERT INTO SellerItem (UserId, ItemId) VALUES (8, 112);
INSERT INTO SellerItem (UserId, ItemId) VALUES (8, 120);
INSERT INTO SellerItem (UserId, ItemId) VALUES (8, 119);
INSERT INTO SellerItem (UserId, ItemId) VALUES (9, 118);
INSERT INTO SellerItem (UserId, ItemId) VALUES (9, 113);
INSERT INTO SellerItem (UserId, ItemId) VALUES (9, 114);
INSERT INTO SellerItem (UserId, ItemId) VALUES (9, 115);
INSERT INTO SellerItem (UserId, ItemId) VALUES (10, 117);
INSERT INTO SellerItem (UserId, ItemId) VALUES (10, 116);


--Populate Wishlist table
INSERT INTO Wishlist (WishListId, BuyerId, ItemId)
VALUES (1, 4, 101);
