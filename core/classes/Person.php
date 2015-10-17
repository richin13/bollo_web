<?php

/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 11/10/15
 * Time: 05:28 PM
 */
class Person implements JsonSerializable {
    private $id;
    private $first_name;
    private $last_name;
    private $username;
    private $email;

    /**
     * Person constructor.
     * @param $id int The person's integer identification.
     * @param $first_name string The person's first name.
     * @param $last_name string The person's last name.
     * @param $username string The person's username.
     * @param $email string the person's email address.
     */
    public function __construct($id, $first_name, $last_name, $username, $email) {
        $this->id = (int)$id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize() {
        return [
            "id" => $this->getId(),
            "first_name" => $this->getFirstName(),
            "last_name" => $this->getLastName(),
            "username" => $this->getUsername(),
            "email" => $this->getEmail()
        ];
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }
}