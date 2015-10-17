<?php

/**
 *
 * @file          Production.php
 * @author        ricardo
 * @version       2.1.23
 * @copyright     (c) 2015 Ricardo Madriz
 * @licensing     GNU GPL 2.0
 * @link          http://www.TEST.net
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Date: 11/11/15
 * Time: 08:40 PM
 */
class Production implements JsonSerializable {
    private $bakery_id;
    private $date;
    private $quantity;

    /**
     * Production constructor.
     * @param $_id int Bakery id
     * @param $_date string Date
     * @param $_quant int Bread quantity
     */
    public function __construct($_id, $_date, $_quant) {
        $this->bakery_id = (int)$_id;
        $this->date = $_date;
        $this->quantity = (int)$_quant;
    }

    /**
     * @return int
     */
    public function getBakeryId() {
        return $this->bakery_id;
    }

    /**
     * @param int $bakery_id
     */
    public function setBakeryId($bakery_id) {
        $this->bakery_id = $bakery_id;
    }

    /**
     * @return string
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
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
            "bakery" => $this->bakery_id,
            "date" => $this->date,
            "quantity" => $this->quantity
        ];
    }
}