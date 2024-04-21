<?php
  class Session {
    //private array $messages;

    public function __construct() {
      session_start();

      //$this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      //unset($_SESSION['messages']);
    }

    public function isLogin() : bool {
      return getUserId() !==  null;    
    }

    public function logout() {
      session_destroy();
    }

    public function getUserId() : ?int {
      return isset($_SESSION['userId']) ? $_SESSION['userId'] : null;    
    }

    public function getUserName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function getUserEmail() : ?string {
      return isset($_SESSION['email']) ? $_SESSION['email'] : null;
    }

    public function setUserId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setUserUserName(string $userName) {
      $_SESSION['userName'] = $userName;
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

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }
  }
?>