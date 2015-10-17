<?php

/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 11/10/15
 * Time: 05:28 PM
 */
class Person {
    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $email;

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * Person constructor.
     * @param $id int The person's integer identification.
     * @param $first_name string The person's first name.
     * @param $last_name string The person's last name.
     * @param $username string The person's username.
     * @param $email string the person's email address.
     */
    public function __construct($id, $first_name, $last_name, $username, $email) {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
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