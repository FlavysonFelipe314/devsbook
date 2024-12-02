<?php

namespace Models;

class User {
    private $id;
    private $email;
    private $password;
    private $name;
    private $birthdate;
    private $city;
    private $work;
    private $avatar;
    private $cover;
    private $token;

    public $following;
    public $followers;
    public $fotos;

    public function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = ucwords($name);
    }

    public function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setWork($work) {
        $this->work = $work;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function setCover($cover) {
        $this->cover = $cover;
    }

    public function setToken($token) {
        $this->token = $token;
    }



    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function getCity() {
        return $this->city;
    }

    public function getWork() {
        return $this->work;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getCover() {
        return $this->cover;
    }

    public function getToken() {
        return $this->token;
    }
}
