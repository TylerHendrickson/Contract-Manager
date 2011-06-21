<?php

require_once dirname(__FILE__) . './../util/db.php';
require_once dirname(__FILE__) . './../util/util.php';

class User {

    private $id;
    private $name;
    private $pass;
    private $email;
    private $address;
    private $city;
    private $state;
    private $zip;
    private $phone;
    private $type;  //Contractor or contractee

    public function setId($newId) {
        $this->id = $newId;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($newName) {
        $this->name = $newName;
    }

    public function getName() {
        return $this->name;
    }

    public function setPass($newPass) {
        $this->pass = $newPass;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setEmail($newEmail) {
        $this->email = $newEmail;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setAddress($newAddress) {
        $this->address = $newAddress;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setCity($newCity) {
        $this->city = $newCity;
    }

    public function getCity() {
        return $this->city;
    }

    public function setState($newState) {
        $this->state = $newState;
    }

    public function getState() {
        return $this->state;
    }

    public function setZip($newZip) {
        $this->zip = $newZip;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setPhone($newPhone) {
        $this->phone = $newPhone;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setType($newType) {
        $this->type = $newType;
    }

    public function getType() {
        return $this->type;
    }

    function __construct($name, $email, $address, $city, $state, $phone, $type) {
        $this->setName($name);
        $this->setPass($this->makePass());
        $this->setEmail($email);
        $this->setAddress($address);
        $this->setCity($city);
        $this->setState($state);
        $this->setPhone($phone);
        $this->setType($type);
    }

    function makePass() {
        $newPass = rand(1111, 9999);
        return $newPass;
    }

    private function buildUserFromResult($result) {
        $users = User::buildUsersFromResult($result);
        return $users[0];
    }

    private function buildUsersFromResult($result) {
        $columns = array(
            'id',
            'name',
            'pass',
            'email',
            'address',
            'city',
            'state',
            'zip',
            'phone',
            'type'
        );
        $map = $result->bindColumnsByArray($columns);
        $users = array();
        while ($result->fetch()) {
            $user = new User(NULL, NULL, NULL, NULL, NULL, NULL, NULL);
            $user->setId($map['id']);
            $user->setName($map['name']);
            $user->setPass($map['pass']);
            $user->setEmail($map['email']);
            $user->setAddress($map['address']);
            $user->setCity($map['city']);
            $user->setState($map['state']);
            $user->setZip($map['zip']);
            $user->setPhone($map['phone']);
            $user->setType($map['type']);
            array_push($users, $user);
        }
        return $users;
    }

    function getAllUsers() {
        $db = new DB();
        $sql = "SELECT id, name, pass, email, address, city, state, zip, phone, type 
            FROM users";
        $result = $db->execute($sql);
        return User::buildUsersFromResult($result);
    }

    function getUserByName($name) {
        $db = new DB();
        $sql = "SELECT id, name, pass, email, address, city, state, zip, phone, type FROM 
            users WHERE name = ?";
        $result = $db->execute($sql, array($name));
        if ($result->rowCount() == 0) {
            return new User(NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        }
        return User::buildUserFromResult($result);
    }

    function getUserById($id) {
        $db = new DB();
        $sql = "SELECT id, name, pass, email, address, city, state, zip, phone, type 
            FROM users WHERE id = ?";
        $result = $db->execute($sql, array($id));
        if ($result->rowCount() == 0) {
            return new User(NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        }
        return User::buildUserFromResult($result);
    }

    function create($user) {
        $db = new DB();
        $id = -1;
        $db->beginTransaction();
        $sql = "INSERT INTO 'users' 
            ('id', 'name', 'pass', 'email', 'address', 'city', 'state', 'zip', 'phone', 'type') 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $db->execute($sql, array(
            $user->name,
            $user->pass,
            $user->email,
            $user->address,
            $user->city,
            $user->state,
            $user->zip,
            $user->phone,
            $user->type
        ));
        $id = $db->lastInsertId();
        $db->commit();
        $db->disconnect();
        return $id;
    }

    function update($user) {
        $db = new DB();
        $db->beginTransaction();
        $sql = "UPDATE 'users' 
            SET 'name' = ?, 'pass' = ?, 'email' = ?, 'address' = ?, 'city' = ?, 'state' = ?, 'zip' = ?, 'phone' = ?, 'type' = ? 
            WHERE 'id' = ? LIMIT 1;";
        $db->execute($sql, array(
            $user->name,
            $user->pass,
            $user->email,
            $user->address,
            $user->city,
            $user->state,
            $user->zip,
            $user->phone,
            $user->type,
            $user->id
        ));
        $db->commit();
        $db->disconnect();
        return TRUE;
    }

    function delete($user) {
        $db = new DB();
        $db->beginTransaction();
        $sql = "DELETE FROM 'users' WHERE 'id' = ? LIMIT 1;";
        $db->execute($sql, array($user->id));
        $db->commit();
        $db->disconnect();
        return TRUE;
    }

}

?>
