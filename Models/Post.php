<?php

namespace Models;

class Post {
    private $id;
    private $id_user;
    private $type;
    private $created_at;
    private $body;
    private $mine;

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function setMine($mine) {
        $this->mine = $mine;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function getType() {
        return $this->type;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getBody() {
        return $this->body;
    }

    public function getMine() {
        return $this->mine;
    }
}


interface PostDao{
}
