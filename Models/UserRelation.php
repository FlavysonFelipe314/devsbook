<?php

namespace Models;

class UserRelation {
    private $id;
    private $user_from;
    private $user_to;


    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserFrom($id) {
        $this->user_from = $id;
    }

    public function setUserTo($id) {
        $this->user_to= $id;
    }



    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserFrom() {
        return $this->user_from;
    }

    public function getUserTo() {
        return $this->user_to;
    }
}
