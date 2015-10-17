<?php

/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 17/10/15
 * Time: 02:10 PM
 */
class Bakery implements JsonSerializable {
    private $id;
    private $name;
    private $province;
    private $city;
    private $stock;
    private $progress;
    private $status;

    /**
     * Bakery constructor.
     * @param $id int Attribute used to identify a bakery.
     * @param $name string The name of the bakery.
     * @param $province int The province where the bakery is located.
     * @param $city string  The city where the bakery is located.0
     * @param $stock int The current stock of the bakery.
     * @param $progress int The progress of the current operation
     * being performed in the bakery.
     * @param $status string A brief description about the process
     * being made in the bakery.
     */
    public function __construct($id, $name, $province, $city, $stock, $progress, $status) {
        $this->id = (int)$id;
        $this->name = $name;
        $this->province = (int)$province;
        $this->city = $city;
        $this->stock = (int)$stock;
        $this->progress = (int)$progress;
        $this->status = $status;
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
            "id" => $this->id,
            "name" => $this->name,
            "province" => $this->province,
            "city" => $this->city,
            "stock" => $this->stock,
            "progress" => $this->progress,
            "status" => $this->status
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
     * @return int
     */
    public function getStock() {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock) {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getProgress() {
        return $this->progress;
    }

    /**
     * @param int $progress
     */
    public function setProgress($progress) {
        $this->progress = $progress;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }


}