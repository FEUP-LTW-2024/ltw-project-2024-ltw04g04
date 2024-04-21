<?php
  declare(strict_types = 1);

  class User {
    public int $userId;
    public string $userName;
    public string $name;
    public string $email;
    public string $password;
    public string $address;
    public string $city;
    public string $country;
    public string $postalCode;
    

    public function __construct(int $userId, string $userName, string $name, string $email, string $password, string $address, string $city, string $country, string $postalCode) {
      $this->userId = $userId;
      $this->userName = $userName;
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
      $this->address = $address;
      $this->city = $city;
      $this->state = $state;
      $this->country = $country;
      $this->postalCode = $postalCode;
    }


    static function registerUser(PDO $db, string $userName, string $name, string $email, string $password) {
      $stmt = $db->prepare('
        INSERT INTO User (UserName, Name_, Email, Password_)
        VALUES (?, ?, ?, ?)
      ');

      $stmt->execute(array( $userName, $name, strtolower($email), sha1($password)));
    }
    

    static function loginUser(PDO $db, string $email, string $password) : ?User {
      $stmt = $db->prepare('
          SELECT UserId, UserName, Name_, Email, Password_, Adress, City, Country, PostalCode
          FROM User
          WHERE Email = ? AND Password_ = ?
      ');
  
      $stmt->execute(array(strtolower($email), sha1($password)));
  
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
      if ($user) {
          return new User(
              $user['UserId'],
              $user['UserName'],
              $user['Name_'],
              $user['Email'],
              $user['Password_'],
              $user['Adress'] ?? "",
              $user['City'] ?? "",
              $user['Country'] ?? "",
              $user['PostalCode'] ?? ""
          );
      } else {
          return null;
      }
  }  


    static function getUserWithId(PDO $db, int $id) : User {
      $stmt = $db->prepare('
        SELECT UserId, UserName, Name_, Email, Password_, Adress, City, Country, PostalCode
        FROM User
        WHERE UserId = ?
      ');

      $stmt->execute(array($id));
      
      if ($user = $stmt->fetch()) {
        return new User(
          $user['UserId'],
          $user['UserName'],
          $user['Name_'],
          $user['Email'],
          $user['Password_'],
          $user['Adress'] !== null ? $user['Adress'] : "",
          $user['City'] !== null ? $user['City'] : "",
          $user['Country'] !== null ? $user['Country'] : "",
          $user['PostalCode'] !== null ? $user['PostalCode'] : ""
        );
      } else return null;
    }

    
    static function emailExists(PDO $db, string $email) {
      $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE lower(Email) = ?');
      $stmt->execute([strtolower($email)]);
      $count = $stmt->fetchColumn();
      return $count > 0;
    }

    static function usernameExists(PDO $db, string $userName) {
      $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE lower(UserName) = ?');
      $stmt->execute([strtolower($userName)]);
      $count = $stmt->fetchColumn();
      return $count > 0;
    }

    function saveData($db) {
      $stmt = $db->prepare('
        UPDATE User SET Username = ?, Name_ = ?, Adress = ?, City = ?, Country = ?, PostalCode = ?
        WHERE UserId = ?
      ');

      $stmt->execute(array($this->userName, $this->name, $this->address, $this->city, $this->country, $this->postalCode, $this->id));
    }

  }
?>