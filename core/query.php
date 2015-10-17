<?php
require_once "conn.php";
require_once "classes/Person.php";

/**
 * Checks whether an API token is a valid one.
 * @param $token string API token to be checked.
 * @return bool true if the API token is valid, false otherwise.
 */
function check_api_token($token) {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_api WHERE api_token = $1";
    pg_prepare($conn, "check_api_token", $sql);
    $result = pg_execute($conn, "check_api_token", array($token));

    return pg_num_rows($result) > 0;
}

/**
 * Assign a 'forgotten-password-token' to a given user.
 * @param $token string Forgotten-password-token used to recover the account.
 * @param $email string Email address of the person who forgot its password.
 * @return bool true if the token was successfully assigned, false otherwise.
 */
function assign_token($token, $email) {
    $conn = BolloConn::getConn();

    $sql = "UPDATE bollo_user SET user_forgot_token =$1 WHERE user_email = $2";
    pg_prepare($conn, "asign_token", $sql);
    $result = pg_execute($conn, "asign_token", array($token, $email));

    return boolval($result);
}

/**
 * Saves the new user's password to the database.
 *
 * @param $password string SHA1 hash corresponding to new user password.
 * @param $token string The secure token generated at forgotten password request.
 * @return bool true if the reset password was successful, false otherwise.
 */
function reset_password($password, $token) {
    $conn = BolloConn::getConn();
    $password = sha1($password);

    $sql = "UPDATE bollo_user SET user_password = $1, user_forgot_token = NULL
    WHERE user_forgot_token=$2";
    pg_prepare($conn, "res_passw", $sql);

    $result = pg_execute($conn, "res_passw", array($password, $token));

    return boolval($result);

}

/**
 * Saves a new Person into the database.
 * @param $f_name string The first name of the person.
 * @param $l_name string The last name of the person.
 * @param $uname string username (nickname) of the person.
 * @param $pw string SHA1 hash for the person's password.
 * @param $email string email of the person.
 * @param null $phone The telegram's phone number of the person.
 * @return bool true if the person was added successfully, false otherwise.
 */
function sign_up($f_name, $l_name, $uname, $pw, $email, $phone = NULL) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_user(user_fname, user_lname, user_username,
      user_password, user_email, usr_phone) VALUES($1, $2, $3, $4, $5, $6)";
    pg_prepare($conn, "sign_up", $sql);
    $result = pg_execute($conn, "sign_up", array($f_name, $l_name, $uname, $pw, $email, $phone));

    return boolval($result);
}

/**
 * This function is called right after a new account is created.
 * It creates a new inactive account associated to the brand new created account.
 * @param $username string Person's username.
 * @param $token string Activation token.
 * @return bool true if the inactive account was successfully created, false otherwise.
 */
function create_inactive_user($username, $token) {
    $conn = BolloConn::getConn();

    $id = user_id($username);//we just added, check is unnecessary!

    $sql = "INSERT INTO bollo_inactive_account(iaccout_activation_token,
      iaccount_user_id, iaccount_user) VALUES($1, $2, $3)";
    pg_prepare($conn, "create_iuser", $sql);
    $result = pg_execute($conn, "create_iuser", array($token, $id, $username));

    return boolval($result);
}

/**
 * Activates a recently-registered person.
 *
 * @param $token string The activation token.
 * @return bool true if the user's account was successfully activated, false otherwise.
 */
function activate_user($token) {
    $conn = BolloConn::getConn();

    $sql = "DELETE FROM bollo_inactive_account WHERE iaccout_activation_token = $1";
    pg_prepare($conn, "activate_user", $sql);
    $result = pg_execute($conn, "activate_user", array($token));

    return boolval($result);
}

/**
 * Fetch the unique integer identifier associated to the given username.
 * @param $username string person's username.
 * @return int Unique integer identifier associated to the given username.
 */
function user_id($username) {
    $conn = BolloConn::getConn();

    $sql = "SELECT user_id FROM bollo_user WHERE user_username = $1";
    pg_prepare($conn, "user_id", $sql);
    $result = pg_execute($conn, "user_id", array($username));

    if ($result) {
        return pg_fetch_row($result)["user_id"];
    } else {
        return -1;
    }
}

/**
 * Method used to get the information of certain user given its id, user or email.
 * @param $column_name string Name of the column where to apply the filter.
 * @param $id string|int Unique attribute used to find an username in the DB.
 * @return bool|Person Returns a Person object if the username with the give
 * id exists. False otherwise.
 */
function get_user($column_name, $id) {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_user WHERE $1 = $2";
    pg_prepare($conn, "get_user", $sql);
    $result = pg_execute($conn, "get_user", array($column_name, $id));

    if(pg_num_rows($result) > 0) {
        $row = pg_fetch_array($result);
        $person = new Person($row['0'], $row['1'], $row['2'], $row['3'], $row['5']);
        return $person;
    } else {
        return false;
    }
}

/**
 * Deletes an specific person from the database.
 *
 * @param $username string The person's nickname.
 * @return bool true if the person was successfully deleted, false otherwise.
 */
function delete_user($username) {
    $conn = BolloConn::getConn();

    $sql = "DELETE FROM bollo_user WHERE user_username = $1";
    pg_prepare($conn, "delete_user", $sql);
    $result = pg_execute($conn, "delete_user", array($username));

    return boolval($result);
}
/* Bakery section */
function add_bakery($name, $province, $city) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_bakery(bakery_name, bakery_state, bakery_city)
    VALUES ($1, $2, $3)";
    pg_prepare($conn, "add_bakery", $sql);
    $result = pg_execute($conn,"add_bakery", array($name, $province, $city));

    return boolval($result);
}

/**
 * Method used to fetch all the information about a bakery.
 * @param $id int Unique attribute used to identify a bakery.
 * @return Bakery|bool all the information about the specified bakery.
 */
function get_bakery($id) {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_bakery WHERE bakery_id = $1";
    pg_prepare($conn, "get_bakery", $sql);
    $result = pg_execute($conn, "get_bakery", array($id));

    if(pg_num_rows($result)) {
        $row = pg_fetch_array($result);
        $bakery = new Bakery($row['0'], $row['1'], $row['2'], $row['3'], $row['4']);
        return $bakery;
    } else {
        return false;
    }
}