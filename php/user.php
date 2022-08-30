<?php

class User {

    private $username;
    private $email;
    private $password;
    private $searchHistory;
    private $favourite;

    public function __construct($username, $email, $password, $searchHistory, $favourite) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->searchHistory = $searchHistory;
        $this->favourite = $favourite;

    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSearchHistory() {
        return $this->searchHistory;
    }

    public function getFavourite() {
        return $this->favourite;
    }

}

?>