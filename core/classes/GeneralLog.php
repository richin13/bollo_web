<?php

/**
 *
 * @file          GeneralLog.php
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
 * Time: 12:52 PM
 */
class GeneralLog extends Entry implements JsonSerializable {

    /**
     * GeneralLog constructor.
     */
    public function __construct($id, $bakery, $description, $date, $hour) {
        parent::__construct($id, $bakery, $description, $date, $hour);
    }
}