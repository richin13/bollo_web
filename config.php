<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On'); #Debug purposes!

define('DIR_BOLLO', __DIR__);

require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

/* Classes */
require_once 'core/classes/Bakery.php';
require_once 'core/classes/Entry.php';
require_once 'core/classes/GeneralLog.php';
require_once 'core/classes/Person.php';
require_once 'core/classes/ProblemLog.php';
require_once 'core/classes/Production.php';

/* Core */
require_once 'core/conn.php';
require_once 'core/email.php';
require_once 'core/query.php';
require_once 'core/security.php';

if (defined("BOLLO_WEB")) {
    $bollo_web = array();

    /* Is there any user logged in? */
    $bollo_web['user_in'] = isset($_SESSION['user_id']);

    /* Establish the website's configuration */
    $bollo_web['title'] = "Bollo Web Interface | ";
    if (!$bollo_web['user_in']) {
        if (isset($_GET['signup'])) {
            $bollo_web['title'] .= "Registrarse";
        } elseif (isset($_GET['activate'])) {
            $bollo_web['title'] .= "Activar cuenta";
        } elseif (isset($_GET['forgot'])) {
            if (empty($_GET['forgot'])) {
                $bollo_web['title'] .= "Recuperar cuenta";
            } else {
                $bollo_web['title'] .= "Ingresar nueva contraseña";
            }
        } elseif (isset($_GET['about'])) {
            $bollo_web['title'] .= "Acerca";
        } else {
            $bollo_web['title'] .= "Índice";
        }
    } else {
        if (isset($_GET['bakeries'])) {
            $bollo_web['title'] .= "Panaderías";
        } elseif (isset($_GET[''])) {

        } elseif (isset($_GET['about'])) {
            $bollo_web['title'] .= "Acerca";
        } else {
            $bollo_web['title'] .= "Bienvenido";
        }
    }

    /* Sessions stuff */
    if (!$bollo_web['user_in']) {
        if (isset($_COOKIE['session_persist'])) {//Returning user
            $user = get_session($_COOKIE['session_persist']);//FIXME: Potential security flaw
            if ($user) {
                $user = get_user("user_id", $user);
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getFirstName();
                $_SESSION['user_lname'] = $user->getLastName();
                $_SESSION['user'] = $user->getUsername();
                $_SESSION['user_email'] = $user->getEmail();
                $bollo_web['user'] = $user;

                $bollo_web['user_in'] = true;
            } else {
                die("Session hijacked!");
            }
        }
    } else {
        //It is already in, let's check if want to get out or something
        if (isset($_GET['logout'])) {
            if (isset($_COOKIE['session_persist'])) {
                if (!delete_session($_SESSION['user_id'])) die("Couldn't clear the session cookie!");
                unset($_COOKIE['session_persist']);
                setcookie("session_persist", null, -1, "/");
            }
            session_destroy();
            $bollo_web['user_in'] = false;
            header("Location: /bollo_web?welcome");
        } elseif (isset($_GET['something'])) {

        }
    }

    /* Proper includes */
    $bollo_web['include_err'] = false;
    if (!$bollo_web['user_in']) {
        if (isset($_GET['signup'])) {
            $bollo_web['include_once'] = 'content/signup.php';
        } elseif (isset($_GET['activate'])) {
            $bollo_web['include_once'] = 'content/activate.php';
        } elseif (isset($_GET['success'])) {
            $bollo_web['include_once'] = 'content/success.php';
        } elseif (isset($_GET['forgot'])) {
            $bollo_web['include_once'] = 'content/forgot.php';
        } elseif (isset($_GET['faqs'])) {
            $bollo_web['include_once'] = 'content/faqs.php';
        } elseif (isset($_GET['about'])) {
            $bollo_web['include_once'] = 'content/about.php';
        } elseif (isset($_GET['thisTextMustBeSuperSecret!__-___'])) {
            $bollo_web['include_once'] = 'content/chart_content.php';
        } else {
            if (!count($_GET) || isset($_GET['welcome'])) {
                $bollo_web['include_once'] = 'content/welcome.php';
            } else {
                $bollo_web['include_err'] = true;
                $bollo_web['include_once'] = 'content/404.php';
            }
        }
    } else {
        $bollo_web['include_once'] = 'content/cp-navbar.php';
        if (isset($_GET['about'])) {
            $bollo_web['include_once'] = 'content/about.php';
        } elseif (isset($_GET['faqs'])) {
            $bollo_web['include_once'] = 'content/faqs.php';
        } elseif (isset($_GET['bakery'])) {
            if (!empty($_GET['bakery']) && !is_numeric($_GET['bakery'])) {
                $bollo_web['include_err'] = true;
                $bollo_web['include_once'] = 'content/404.php';
            } else {
                $bollo_web['include_once'] = 'content/bakery_content.php';
            }
        } elseif (isset($_GET['create'])) {
            if (!empty($_GET['create'])) {
                $bollo_web['include_err'] = true;
                $bollo_web['include_once'] = 'content/404.php';
            } else {
                $bollo_web['include_once'] = 'content/create_bakery.php';
            }
        } elseif (isset($_GET['modify'])) {
            if (!is_numeric($_GET['modify']) || empty($_GET['modify'])) {
                $bollo_web['include_err'] = true;
                $bollo_web['include_once'] = 'content/404.php';
            } else {
                $bollo_web['include_once'] = 'content/modify_bakery.php';
            }
        } elseif (isset($_GET['delete'])) {
            if (!is_numeric($_GET['delete']) || empty($_GET['delete'])) {
                $bollo_web['include_err'] = true;
                $bollo_web['include_once'] = 'content/404.php';
            } else {
                $bollo_web['include_once'] = 'content/delete_bakery.php';
            }
        } elseif (isset($_GET['events'])) {
            $bollo_web['include_once'] = 'content/events-entries.php';
        } elseif (isset($_GET['problems'])) {
            $bollo_web['include_once'] = 'content/problems-entries.php';
        } elseif (isset($_GET['charts'])) {
            $bollo_web['include_once'] = 'content/chart_content.php';
        } else {
            if (!count($_GET) || isset($_GET['welcome'])) {
                $bollo_web['include_once'] = 'content/welcome.php';
            } else {
                $bollo_web['include_err'] = true;
                $bollo_web['include_once'] = 'content/404.php';
            }
        }
    }
}

if (defined("NEED_TELEGRAM")) {
    require_once 'vendor/autoload.php';
}

function get_token($length = 8) {
    return $token = bin2hex(openssl_random_pseudo_bytes($length));
}

function provinces() {
    return [
        "1" => "San José",
        "2" => "Alajuela",
        "3" => "Cartago",
        "4" => "Heredia",
        "5" => "Guanacaste",
        "6" => "Puntarenas",
        "7" => "Limón",
    ];
}

