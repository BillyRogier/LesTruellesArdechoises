<?php

namespace Core\Login;

use App;
use Core\Error\Error;

class Login
{
    private $db;

    public function __construct($table)
    {
        $this->db = App::getInstance()->getTable($table);
    }

    public function verify($email, $password)
    {
        $error = new Error();
        $user = $this->db->findOneBy(['email' => $email]);

        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                if ($user->getType() == 1) {
                    $_SESSION['admin'] = $user->getId();
                } else {
                    $_SESSION['user'] = $user->getId();
                }
            } else {
                $error->danger("Incorrect Password", 'password');
            }
        } else {
            $error->danger("Unknown user", 'email');
        }
    }

    public function register($email, $password)
    {
        $error = new Error();
        $emailTaken = $this->db->findAllBy(['email' => $email]);

        if ($emailTaken) {
            // $error->danger("Email already taken");
        } else {
            if (7 > strlen($password)) { //check if string meets 8 or more characters
                // $error->danger("Password is short");
            }
            if (strcspn($password, '0123456789') == strlen($password)) { //check if string has numbers
                // $error->danger("No number");
            }
            if (strcspn($password, 'abcdefghijklmnopqrstuvwxyz') == strlen($password)) { //check if string has small letters
                // $error->danger("No small letter");
            }
            if (strcspn($password, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') == strlen($password)) { //check if string has capital letters
                // $error->danger("No capital letter");
            }
            if (strcspn($password, '{}[]|()_\/?§!$£') == strlen($password)) {
                // $error->danger("No special character");
            }
        }

        if ($_SESSION['message'] == "") {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->db
                ->setEmail($email)
                ->setPassword($password)
                ->flush();

            $userid = $this->db->lastInsertId();
            $_SESSION['admin'] = $userid;
        }
    }

    public function logout()
    {
        session_destroy();
    }
}
