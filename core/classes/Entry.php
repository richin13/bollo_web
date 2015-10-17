<?php

/**
 *
 * @file          Entry.php
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
 * Date: 22/10/15
 * Time: 11:17 PM
 */
class Entry implements JsonSerializable {
    protected $id;
    protected $bakery;//as name, not id
    protected $description;
    protected $date;
    protected $hour;

    /**
     * Logbook constructor.
     * @param $id int
     * @param $bakery int Bakery id
     * @param $description string
     * @param $date string
     * @param $hour string
     */
    public function __construct($id, $bakery, $description, $date, $hour) {
        $this->id = (int)$id;
        $this->bakery = (int)$bakery;
        $this->description = $description;
        $this->date = $date;
        $this->hour = $hour;
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
            "bakery" => $this->getBakery(),
            "description" => $this->getDescription(),
            "date" => $this->getDate(),
            "hour" => $this->getHour()
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
     * @return int
     */
    public function getBakery() {
        return $this->bakery;
    }

    /**
     * @param int $bakery
     */
    public function setBakery($bakery) {
        $this->bakery = $bakery;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
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
     * @return string
     */
    public function getHour() {
        return $this->hour;
    }

    /**
     * @param string $hour
     */
    public function setHour($hour) {
        $this->hour = $hour;
    }
}