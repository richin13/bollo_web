<?php

/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 17/10/15
 * Time: 02:10 PM
 */
class Bakery {
    public $id;
    public $name;
    public $province;
    public $city;
    public $stock;

    /**
     * Bakery constructor.
     * @param $id int Attribute used to identify a bakery.
     * @param $name string The name of the bakery.
     * @param $province int The province where the bakery is located.
     * @param $city string  The city where the bakery is located.0
     * @param $stock int The current stock of the bakery.
     */
    public function __construct($id, $name, $province, $city, $stock) {
        $this->id = $id;
        $this->name = $name;
        $this->province = $province;
        $this->city = $city;
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getProvince() {
        return $this->province;
    }

    /**
     * @param int $province
     */
    public function setProvince($province) {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getStock() {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock) {
        $this->stock = $stock;
    }
}