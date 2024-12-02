<?php

namespace Models;

interface UserDao{
    public function create(User $u);
    public function update(User $u);
    public function delete($id);
    public function findById($id);
    public function findByName($name);
    public function findByToken($token);
    public function findByEmail($email);
    public function findAll();
}
