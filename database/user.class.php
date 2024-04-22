<?php
  declare(strict_types = 1);

  class User {
    public int $userId;
    public string $username;
    public string $name;
    public string $email;
    public string $password;
    public string $address;
    public string $city;
    public string $country;
    public string $postalCode;
    

    public function __construct(int $userId, string $username, string $name, string $email, string $password, string $address, string $city, string $country, string $postalCode) {
      $this->userId = $userId;
      $this->username = $username;
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
      $this->address = $address;
      $this->city = $city;
      $this->state = $state;
      $this->country = $country;
      $this->postalCode = $postalCode;
    }


    static function registerUser(PDO $db, string $username, string $name, string $email, string $password) {
      $stmt = $db->prepare('
        INSERT INTO User (Username, Name_, Email, Password_)
        VALUES (?, ?, ?, ?)
      ');

      $stmt->execute(array( $username, $name, strtolower($email), sha1($password)));
    }
    

    static function loginUser(PDO $db, string $email, string $password) : ?User {
      $stmt = $db->prepare('
          SELECT UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode
          FROM User
          WHERE Email = ? AND Password_ = ?
      ');
  
      $stmt->execute(array(strtolower($email), sha1($password)));
  
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
      if ($user) {
          return new User(
              $user['UserId'],
              $user['Username'],
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
        SELECT UserId, Username, Name_, Email, Password_, Adress, City, Country, PostalCode
        FROM User
        WHERE UserId = ?
      ');

      $stmt->execute(array($id));
      
      if ($user = $stmt->fetch()) {
        return new User(
          $user['UserId'],
          $user['Username'],
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

    static function usernameExists(PDO $db, string $username) {
      $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE lower(Username) = ?');
      $stmt->execute([strtolower($username)]);
      $count = $stmt->fetchColumn();
      return $count > 0;
    }

    static function saveData(PDO $db, string $username_, string $name_, string $address_, string $city_, string $country_, string $postalCode_, int $id_) {
      $stmt = $db->prepare('
        UPDATE User SET Username = ?, Name_ = ?, Adress = ?, City = ?, Country = ?, PostalCode = ?
        WHERE UserId = ?
      ');

      $stmt->execute(array($username_, $name_, $address_, $city_, $country_, $postalCode_, $id_));
    }

  }
?>