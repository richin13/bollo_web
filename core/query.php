<?php
/**
 * Assign a 'forgotten-password-token' to a given user.
 * @param $token string Forgotten-password-token used to recover the account.
 * @param $id int user id of the person who forgot its password.
 * @return bool true if the token was successfully assigned, false otherwise.
 */
function assign_token($id, $token) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO forgotten_pwds VALUES (DEFAULT, $1, DEFAULT, $2)";
    pg_prepare($conn, "asign_token", $sql);
    $result = pg_execute($conn, "asign_token", array($token, $id));

    pg_close($conn);
    return $result !== FALSE;
}

function check_ft_data($data, $id) {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_user WHERE user_forgot_token = $1 AND user_id = $2";
    pg_prepare($conn, "check_ft_data", $sql);
    $result = pg_execute($conn, "check_ft_data", array($data, $id));

    pg_close($conn);
    return pg_num_rows($result) > 0;
}

/**
 * Saves the new user's password to the database.
 * @param $id int user's id.
 * @param $password string SHA256 hash corresponding to new user's password.
 * @param $data string The secure token generated at forgotten password request.
 * @return bool true if the reset password was successful, false otherwise.
 */
function reset_password($id, $password, $data) {
    $data = str_replace(" ", "+", pg_escape_string($data));//Potentially unsafe
    if (valid_fpwd_token($id, $data)) {
        $conn = BolloConn::getConn();

        $sql = "UPDATE bollo_user SET user_password = $1
            WHERE user_id = $2";
        pg_prepare($conn, "reset_pwd", $sql);
        $result = pg_execute($conn, "reset_pwd", array($password, $id));

        pg_close($conn);
        return boolval($result);
    } else {
        return false;
    }
}

function valid_fpwd_token($id, $token) {
    $conn = BolloConn::getConn();

    $sql = "SELECT fpwd_id FROM forgotten_pwds WHERE fpwd_token = $1 AND fpwd_user = $2";
    pg_prepare($conn, "validate_fpwd_token", $sql);
    $result = pg_execute($conn, "validate_fpwd_token", array($token, $id));

    pg_close($conn);
    return pg_num_rows($result) > 0;
}

/**
 * @param $username string Can be both, the username or the email.
 * @param $password string SHA1 hash corresponding to the user's password.
 * @return Person|boolean The user's object, false if a bad username/password combination was given.
 */
function login($username, $password) {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_user WHERE user_email = $1
            OR user_username = $1 AND user_password = $2";
    pg_prepare($conn, "login", $sql);
    $result = pg_execute($conn, "login", array($username, $password));
    pg_close($conn);
    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_array($result);
        return new Person($row[0], $row[1], $row[2], $row[3], $row[5]);
    } else {
        return false;
    }
}

function create_session($token, $ip, $id) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_session VALUES(DEFAULT, $1, $2, DEFAULT, $3)";
    pg_prepare($conn, "art", $sql);
    $result = pg_execute($conn, "art", array($token, $ip, $id));

    pg_close($conn);
    return $result !== FALSE;
}

/**
 * Saves a new Person into the database.
 * @param $fn string The first name of the person.
 * @param $ln string The last name of the person.
 * @param $uname string username (nickname) of the person.
 * @param $pw string SHA1 hash for the person's password.
 * @param $email string email of the person.
 * @return bool true if the person was added successfully, false otherwise.
 */
function sign_up($fn, $ln, $uname, $pw, $email) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_user VALUES(DEFAULT, $1, $2, $3, $4, $5)
        RETURNING user_id";
    pg_prepare($conn, "sign_up", $sql);
    $result = pg_execute($conn, "sign_up", array($fn, $ln, $uname, $pw, $email));

    pg_close($conn);
    if ($result) {
        $row = pg_fetch_array($result);
        return $row['0'];
    }

    return false;
}

/**
 * This function is called right after a new account is created.
 * It creates a new inactive account associated to the brand new created account.
 * @param $username string Person's username.
 * @param $token string Activation token.
 * @return bool true if the inactive account was successfully created, false otherwise.
 */
function create_inactive_user($id, $username, $token) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO inactive_account VALUES(DEFAULT, $1, $2, $3)";
    pg_prepare($conn, "create_iuser", $sql);
    $result = pg_execute($conn, "create_iuser", array($token, $id, $username));

    pg_close($conn);
    return $result !== FALSE;
}

function is_iaccount($id) {
    $conn = BolloConn::getConn();

    $sql = "SELECT user_id, inactive_account.iaccount_user_id FROM bollo_user
              INNER JOIN inactive_account
              ON bollo_user.user_id = inactive_account.iaccount_user_id
              AND bollo_user.user_username = inactive_account.iaccount_user
              WHERE user_username = $1";
    pg_prepare($conn, "check_iuser", $sql);
    $result = pg_execute($conn, "check_iuser", array($id));

    pg_close($conn);
    return (pg_num_rows($result) > 0);
}

/**
 * Activates a recently-registered person.
 *
 * @param $token string The activation token.
 * @return bool true if the user's account was successfully activated, false otherwise.
 */
function activate_user($token) {
    if (!empty($token)) {
        $conn = BolloConn::getConn();

        $token = str_replace(" ", "+", pg_escape_string($conn, $token));//FIXME: Potential security flaw
        $sql = "SELECT * FROM inactive_account WHERE iaccount_activation_token = '$token'";

        if (pg_num_rows(pg_query($conn, $sql))) {
            $sql = "DELETE FROM inactive_account WHERE iaccount_activation_token = '$token'";
            $result = pg_query($conn, $sql);
            pg_close($conn);
            return $result !== FALSE;
        }
    }
    return false;
}

/**
 * Fetch the unique integer identifier associated to the given username.
 * @param $id string person's username or email.
 * @return int Unique integer identifier associated to the given username.
 */
function user_id($id) {
    $conn = BolloConn::getConn();

    $id = pg_escape_string($conn, $id);
    $sql = "SELECT user_id FROM bollo_user
          WHERE user_username = '$id' OR user_email = '$id'";
    $result = pg_query($conn, $sql);

    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_array($result);
        return $row["user_id"];
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
    $column_name = pg_escape_string($conn, $column_name);
    $sql = "SELECT * FROM bollo_user WHERE $column_name = $1";
    pg_prepare($conn, "get_user", $sql);
    $result = pg_execute($conn, "get_user", array($id));

    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_array($result);
        $person = new Person($row['0'], $row['1'], $row['2'], $row['3'], $row['5']);
        return $person;
    } else {
        return false;
    }
}

/**
 * @param $token string session token.
 * @return bool the user's id corresponding to the given session token.
 */
function get_session($token) {
    $conn = BolloConn::getConn();
    $token = str_replace(" ", "+", pg_escape_string($conn, $token));//FIXME: Potentially unsafe
    $sql = "SELECT sess_user FROM bollo_session WHERE session_token = '$token'";
    $result = pg_query($conn, $sql);

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_array($result);
        return $row[0];
    }

    return false;
}

function delete_session($id) {
    $conn = BolloConn::getConn();

    $sql = "DELETE FROM bollo_session WHERE sess_user = $1";
    pg_prepare($conn, "delete_session", $sql);
    $result = pg_execute($conn, "delete_session", array($id));

    return boolval($result);
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

    pg_close($conn);
    return $result !== FALSE;
}

/* Bakery section */
function add_bakery($name, $province, $city) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_bakery(bakery_name, bakery_state, bakery_city)
    VALUES ($1, $2, $3) RETURNING bakery_id";
    pg_prepare($conn, "add_bakery", $sql);
    $result = pg_execute($conn, "add_bakery", array($name, $province, $city));

    pg_close($conn);
    if ($result) {
        return pg_fetch_array($result)[0];//Check if works!
    }

    return false;
}

function edit_bakery($id, $name, $province, $city) {
    $conn = BolloConn::getConn();

    $sql = "UPDATE bollo_bakery SET bakery_name = $1, bakery_state = $2, bakery_city = $3
            WHERE bakery_id = $4";
    pg_prepare($conn, "add_bakery", $sql);
    return pg_execute($conn, "add_bakery", array($name, $province, $city, $id));
}

function delete_bakery($id) {
    $conn = BolloConn::getConn();

    $sql = "DELETE FROM bollo_bakery WHERE bakery_id = $1";
    pg_prepare($conn, "delete_bakery", $sql);

    $result = pg_execute($conn, "delete_bakery", array($id));

    pg_close($conn);
    return $result;
}

/**
 * Method used to fetch all the information about a bakery.
 * @param $id int Unique attribute used to identify a bakery.
 * @return array|bool all the information about the specified bakery.
 */
function get_bakery($id = 0) {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_bakery";
    if ($id) {
        $id = pg_escape_string($conn, $id);
        $sql .= " WHERE bakery_id = " . $id;
    }
    $sql .= " ORDER BY bakery_id";
    $result = pg_query($conn, $sql);
    pg_close($conn);
    if ($result) {
        $bakeries = array();
        while ($row = pg_fetch_array($result)) {
            $bakery = new Bakery($row['0'], $row['1'],
                $row['2'], $row['3'], $row['4'],
                $row['5'], $row['6']);
            $bakeries[] = $bakery;
        }
        return $bakeries;
    } else {
        return false;
    }
}

/**
 * @param $bakery_id int The bakery id
 * @return array|bool An array with the information of the current status of the bakery, false if the bakery doesn't exists.
 */
function get_status($bakery_id) {
    $conn = BolloConn::getConn();

    $bakery_id = pg_escape_string($conn, $bakery_id);
    $sql = "SELECT bakery_progress, bakery_status FROM bollo_bakery WHERE bakery_id = $bakery_id";
    $result = pg_query($conn, $sql);

    if ($result) {
        if (pg_num_rows($result) > 0) {
            $row = pg_fetch_array($result);
            return array((int)$row[0], $row[1]);
        }
    }

    pg_close($conn);
    return false;
}

function set_stock($id, $stock, $add = false) {
    $conn = BolloConn::getConn();

    if ($add) {
        $sql = "UPDATE bollo_bakery SET bakery_stock = bakery_stock + $1 WHERE bakery_id = $2";
    } else {
        $sql = "UPDATE bollo_bakery SET bakery_stock = $1 WHERE bakery_id = $2";
    }
    pg_prepare($conn, "set_stock", $sql);
    $result = pg_execute($conn, "set_stock", array($stock, $id));

    pg_close($conn);
//    return $result !== TRUE;
    return boolval($result);
}

function set_status($id, $progress, $description) {
    $conn = BolloConn::getConn();
    $sql = "UPDATE bollo_bakery
            SET bakery_progress = $1, bakery_status = $2
            WHERE bakery_id = $3
            RETURNING bakery_id";
    pg_prepare($conn, "set_status", $sql);

    $result = pg_execute($conn, "set_status", array($progress, $description, $id));
    pg_close($conn);
    if ($result) {
        return pg_num_rows($result) > 0;
    } else {
        return false;
    }
}

function all_bakeries() {
    $conn = BolloConn::getConn();

    $sql = "SELECT * FROM bollo_bakery ORDER BY bakery_id";
    $result = pg_query($conn, $sql);
    $bakeries = array();

    while ($row = pg_fetch_array($result)) {
        $bakery = new Bakery($row['0'], $row['1'], $row['2'],
            $row['3'], $row['4'], $row['5'], $row['6']);
        $bakeries[] = $bakery;
    }

    pg_close($conn);
    return $bakeries;
}

function log_events($id = 0) {
    $conn = BolloConn::getConn();

    $sql = "SELECT logbook_id, bollo_bakery.bakery_id, logbook_description,
            to_char(logbook_date, 'DD-MM-YYYY'), to_char(logbook_date, 'HH24:MI:SS')
            FROM bollo_logbook
            INNER JOIN bollo_bakery ON bollo_bakery.bakery_id = bollo_logbook.logbook_bakery
            INNER JOIN bollo_logbook_general
            ON bollo_logbook.logbook_id = bollo_logbook_general.logbook_general_id";
    if ($id) {
        $id = pg_escape_string($id);
        $sql .= " AND logbook_bakery = '$id'";
    }
    $result = pg_query($conn, $sql);
    $events = array();

    if ($result) {
        while ($row = pg_fetch_array($result)) {
            $event = new GeneralLog($row['0'], $row['1'], $row['2'], $row['3'], $row['4']);
            $events[] = $event;
        }
    } else {
        $events[] = "ERROR";
    }

    return $events;
}

function log_problems($id = 0) {
    $conn = BolloConn::getConn();

    $sql = "SELECT logbook_id, bollo_bakery.bakery_id, logbook_description,
            bollo_logbook_problem.problem_dough, to_char(logbook_date, 'DD-MM-YYYY'),
            to_char(logbook_date, 'HH24:MI:SS')
            FROM bollo_logbook
            INNER JOIN bollo_bakery ON bollo_bakery.bakery_id = bollo_logbook.logbook_bakery
            INNER JOIN bollo_logbook_problem ON bollo_logbook.logbook_id = bollo_logbook_problem.logbook_problem_id";
    if ($id) {
        $id = pg_escape_string($id);
        $sql .= " AND logbook_bakery = '$id'";
    }
    $result = pg_query($conn, $sql);
    $problems = array();

    if ($result) {
        while ($row = pg_fetch_array($result)) {
            $problem = new ProblemLog($row['0'], $row['1'], $row['2'], $row['4'], $row['5'], $row['3']);
            $problems[] = $problem;
        }
    } else {
        $problems[] = "ERROR";
    }

    return $problems;
}

function add_production($id, $quantity) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_production VALUES (DEFAULT, $1, DEFAULT, $2)";
    pg_prepare($conn, "add_production", $sql);

    $result = pg_execute($conn, "add_production", array($quantity, $id));

    pg_close($conn);
    return boolval($result);
}

function get_production($bakery_id) {
    $conn = BolloConn::getConn();

    $sql = "SELECT to_char(date_trunc('day', production_date), 'DD-MM-YYYY') AS \"Fecha\",
            SUM(production_quantity) AS \"Total\", bakery_id
            FROM bollo_production WHERE bakery_id = $1
            GROUP BY 1, 3
            ORDER BY 1";

    pg_prepare($conn, "get_b_production", $sql);
    $result = pg_execute($conn, "get_b_production", array($bakery_id));
    $production = array();

    if ($result) {
        while ($row = pg_fetch_array($result)) {
            $p = new Production($row[2], $row[0], $row[1]);
            $production[] = $p;
        }

        return $production;
    }

    return false;
}

function get_general_production() {
    $conn = BolloConn::getConn();

    $sql = "SELECT to_char(date_trunc('day', production_date), 'DD-MM-YYYY') AS \"Fecha\",
            SUM(production_quantity) AS \"Total\", bakery_id
            FROM bollo_production
            GROUP BY 1, 3
            ORDER BY 1";

    pg_prepare($conn, "get_production", $sql);
    $result = pg_execute($conn, "get_production", array());
    $production = array();

    if ($result) {
        while ($row = pg_fetch_array($result)) {
            $p = new Production($row[2], $row[0], $row[1]);
            $production[] = $p;
        }

        return $production;
    }

    return false;
}


/* Logbook entries */
function add_parent_entry($bid, $msg) {
    $conn = BolloConn::getConn();

    $sql = "INSERT INTO bollo_logbook VALUES (DEFAULT, $1, DEFAULT, $2)
            RETURNING logbook_id";
    pg_prepare($conn, "add_pentry", $sql);

    $result = pg_execute($conn, "add_pentry", array($msg, $bid));

    if ($result) {
        return pg_fetch_array($result)[0];
    }

    return 0;
}

function add_event_entry($id) {
    if ($id) {
        $conn = BolloConn::getConn();

        $sql = "INSERT INTO bollo_logbook_general VALUES($1)";
        pg_prepare($conn, "event_entry", $sql);
        $result = pg_execute($conn, "event_entry", array($id));

        if ($result) return true;
    }

    return false;
}

function add_problem_entry($id, $dough) {
    if ($id) {
        $conn = BolloConn::getConn();

        $sql = "INSERT INTO bollo_logbook_problem VALUES($1, $2)";
        pg_prepare($conn, "event_entry", $sql);
        $result = pg_execute($conn, "event_entry", array($id, $dough));

        if ($result) return true;
    }

    return false;
}
