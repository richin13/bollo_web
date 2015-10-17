<?php

/**
 *
 * @file          ProblemLog.php
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
 * Date: 25/10/15
 * Time: 12:56 PM
 */
class ProblemLog extends Entry implements JsonSerializable {
    private $dough;

    /**
     * @param int $id
     * @param int $bakery
     * @param string $description
     * @param string $date
     * @param string $hour
     * @param int $dough
     */
    public function __construct($id, $bakery, $description, $date, $hour, $dough) {
        parent::__construct($id, $bakery, $description, $date, $hour);
        $this->dough = (int)$dough;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize() {
        $array = parent::jsonSerialize();
        $array['dough'] = $this->getDough();
        return $array;
    }

    /**
     * @return int
     */
    public function getDough() {
        return $this->dough;
    }

    /**
     * @param int $dough
     */
    public function setDough($dough) {
        $this->dough = $dough;
    }
}