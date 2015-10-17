<?php
/**
 *
 * @file          logout.php
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
 * Time: 12:21 AM
 */
session_start();
if (session_destroy()) {
    header("Location: index.php");
}
die;