<?php
  class Session {

    public function __construct() {
      $domain = $_SERVER['HTTP_HOST'];
      session_set_cookie_params(0, '/', $domain, true, true);

      session_start();

      if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
      }
    }

    public function isLogin() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getUserId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function getUserName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function getUserEmail() : ?string {
      return isset($_SESSION['email']) ? $_SESSION['email'] : null;
    }

    public function isAdmin(): bool {
      return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
    }

    public function setUserId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setUserUsername(string $username) {
      $_SESSION['username'] = $username;
    }

    public function setUserName(string $name) {
      $_SESSION['name'] = $name;
    }

    public function setUserEmail(string $email){
      $_SESSION['email'] = $email;
    }

    public function setPassword(string $password) {
      $_SESSION['password'] = $password;
    }

    public function setCountry(string $country) {
      $_SESSION['country'] = $country;
    }

    public function setCity(string $city) {
      $_SESSION['city'] = $city;
    }

    public function setAddress(string $address) {
      $_SESSION['address'] = $address;
    }

    public function setPostalCode(string $postalCode) {
      $_SESSION['postalCode'] = $postalCode;
    }

    public function setIsAdmin(bool $admin) {
      $_SESSION['admin'] = $admin;
    }
  }
?>