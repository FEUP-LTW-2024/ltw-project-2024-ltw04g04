<?php
  declare(strict_types = 1);

  class User {
    public int $userId;
    public string $name;
    public string $email;
    public string $password;
    public string $address;
    public string $city;
    public string $country;
    public string $postalCode;
    

    public function __construct(int $userId, string $name, string $email, string $password, string $address, string $city, string $country, string $postalcode) {
      $this->userId = $userId;
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
      $this->address = $address;
      $this->city = $city;
      $this->state = $state;
      $this->country = $country;
      $this->postalcode = $postalcode;
    }


    static function registerUser(PDO $db, string $name, string $email, string $password) {
      $stmt = $db->prepare('
        INSERT INTO User (Name_, Email, Password_)
        VALUES (?, ?, ?)
      ');

      $stmt->execute(array($name, strtolower($email), sha1($password)));
    }
    

    static function loginUser(PDO $db, string $email, string $password) : ?User {
      $stmt = $db->prepare('
          SELECT UserId, Name_, Email, Password_, Adress, City, Country, PostalCode
          FROM User
          WHERE Email = ? AND Password_ = ?
      ');
  
      $stmt->execute(array(strtolower($email), sha1($password)));
  
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
      if ($user) {
        echo 'ENTROU';
          return new User(
              $user['UserId'],
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
        SELECT UserId, Name_, Email, Password_, Adress, City, Country, PostalCode
        FROM User
        WHERE UserId = ?
      ');

      $stmt->execute(array($id));
      
      if ($user = $stmt->fetch()) {
        return new User(
          $user['UserId'],
          $user['Name_'],
          $user['Email'],
          $user['Password_'],
          $user['Address'] !== null ? $user['Address'] : "",
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

  }
?>