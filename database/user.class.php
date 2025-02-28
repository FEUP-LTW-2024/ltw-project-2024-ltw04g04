<?php
  declare(strict_types = 1);

  class User {
      public int $userId;
      public string $username;
      public string $name;
      public string $email;
      public string $password;
      public string $profileImage;
      public string $address;
      public string $city;
      public string $country;
      public string $postalCode;
      public bool $isAdmin; 

      public function __construct(int $userId, string $username, string $name, string $email, string $password, string $profileImage, string $address, string $city, string $country, string $postalCode, bool $isAdmin = false) {
          $this->userId = $userId;
          $this->username = $username;
          $this->name = $name;
          $this->email = $email;
          $this->password = $password;
          $this->profileImage = $profileImage;
          $this->address = $address;
          $this->city = $city;
          $this->country = $country;
          $this->postalCode = $postalCode;
          $this->isAdmin = $isAdmin; 
      }


      static function registerUser(PDO $db, string $username, string $name, string $email, string $password) {
          $stmt = $db->prepare('
              INSERT INTO User (Username, Name_, Email, Password_)
              VALUES (?, ?, ?, ?)
          ');

          $stmt->execute(array($username, $name, strtolower($email), $password));
      }

      static function loginUser(PDO $db, string $email, string $password) : ?User {
          $stmt = $db->prepare('
              SELECT UserId, Username, Name_, Email, Password_, ProfileImage, Adress, City, Country, PostalCode, IsAdmin
              FROM User
              WHERE Email = ?
          ');

          $stmt->execute(array(strtolower($email)));

          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($user && password_verify($password, $user['Password_'])) {
              return new User(
                  $user['UserId'],
                  $user['Username'],
                  $user['Name_'],
                  $user['Email'],
                  $user['Password_'],
                  $user['ProfileImage'] ?? ('/../pages/imgs/user-icon.png'),
                  $user['Adress'] ?? "",
                  $user['City'] ?? "",
                  $user['Country'] ?? "",
                  $user['PostalCode'] ?? "",
                  $user['IsAdmin'] == true
              );
          } else {
              return null;
          }
      }

      static function getUserWithId(PDO $db, int $id) : ?User {
          $stmt = $db->prepare('
              SELECT UserId, Username, Name_, Email, Password_, ProfileImage, Adress, City, Country, PostalCode, IsAdmin
              FROM User
              WHERE UserId = ?
          ');

          $stmt->execute(array($id));

          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($user) {
              return new User(
                  $user['UserId'],
                  $user['Username'],
                  $user['Name_'],
                  $user['Email'],
                  $user['Password_'],
                  $user['ProfileImage'] ?? ('/../pages/imgs/user-icon.png'),
                  $user['Adress'] ?? "",
                  $user['City'] ?? "",
                  $user['Country'] ?? "",
                  $user['PostalCode'] ?? "",
                  $user['IsAdmin'] == true
              );
          } else {
              return null;
          }
      }

      
    static function adressIsComplete(PDO $db, int $userId) {
      $stmt = $db->prepare('SELECT Adress, City, Country, PostalCode FROM User WHERE UserId = ?');
      $stmt->execute([$userId]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
          if ($user['Adress'] && $user['City'] && $user['Country'] && $user['PostalCode']) {
              return true; 
          } else {
              return false; 
          }
      } else {
          return false;
      }
    }

    public static function getAddressInfo(PDO $db, int $userId): array {
      $stmt = $db->prepare('SELECT Adress, City, Country, PostalCode FROM User WHERE UserId = ?');
      $stmt->execute([$userId]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      return [$user['Adress'], $user['City'], $user['Country'], $user['PostalCode']];
    }

    
    static function emailExists(PDO $db, string $email) {
      $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE lower(Email) = ?');
      $stmt->execute([strtolower($email)]);
      $count = $stmt->fetchColumn();
      return $count > 0;
    }

    static function usernameExists(PDO $db, string $username) {
      $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE lower(Username) = ?');
      $stmt->execute([strtolower($username)]);
      $count = $stmt->fetchColumn();
      return $count > 0;
    }

    static function updateUser(PDO $db, string $username_, string $name_, string $address_, string $city_, string $country_, string $postalCode_, int $id_) {
      $stmt = $db->prepare('
        UPDATE User SET Username = ?, Name_ = ?, Adress = ?, City = ?, Country = ?, PostalCode = ?
        WHERE UserId = ?
      ');

      $stmt->execute(array($username_, $name_, $address_, $city_, $country_, $postalCode_, $id_));
    }

    static function updateUserProfileImage(PDO $db, string $imageLink, int $userId) {
        $stmt = $db->prepare('
          UPDATE User SET ProfileImage = ?
          WHERE UserId = ?
        ');
  
        $stmt->execute(array($imageLink, $userId));
      }

    public static function upgradeUserToAdmin(PDO $db, int $user_id) {
      $stmt = $db->prepare('UPDATE User SET isAdmin = true WHERE userId = ?');
      $stmt->execute([$user_id]);
    }


    public static function downgradeUser(PDO $db, int $user_id) {
        $stmt = $db->prepare('UPDATE User SET isAdmin = false WHERE userId = ?');
        $stmt->execute([$user_id]);
    }

    public static function getAllUsersExceptCurrent(PDO $db, int $currentUserId): array {
        $stmt = $db->prepare('SELECT * FROM User WHERE UserId != ?');
        $stmt->execute([$currentUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSellerAverageRating(PDO $pdo, int $userId) {
        $stmt = $pdo->prepare('SELECT AVG(Rating) as averageRating FROM SellerRating WHERE SellerId = ?');
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? round($result['averageRating'], 2) : 'No ratings';
    }

    public static function getTopSellers(PDO $pdo, $limit = 5): array  {
        $query = "SELECT SellerId, AVG(rating) AS average_rating
                  FROM SellerRating
                  GROUP BY SellerId
                  ORDER BY average_rating DESC
                  LIMIT :limit";
    
        $statement = $pdo->prepare($query);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
    
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOrdersBySeller(PDO $pdo, int $sellerId) {
      $stmt = $pdo->prepare('
          SELECT o.OrderId, o.ItemId, o.Quantity, o.BuyerId, i.Name_ AS ItemName, u.Name_ AS BuyerName
          FROM OrderItem o
          JOIN Item i ON o.ItemId = i.ItemId
          JOIN User u ON o.BuyerId = u.UserId
          JOIN SellerItem si ON i.ItemId = si.ItemId
          WHERE si.UserId = ?
      ');
      $stmt->execute([$sellerId]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
  
  }

?>