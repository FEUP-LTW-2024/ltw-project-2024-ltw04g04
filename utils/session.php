<?php
  class Session {
    //private array $messages;

    public function __construct() {
      session_start();

      //$this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      //unset($_SESSION['messages']);
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

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }
  }
?>