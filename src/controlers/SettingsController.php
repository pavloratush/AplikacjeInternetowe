<?php

require_once 'AppController.php';


class SettingsController extends AppController
{

    public function settings()
    {
        if ($_COOKIE["user"]) {

            $this->render('settings');
        } else
            $this->render('login', ['messages' => ['You have to be logged in!']]);

    }

    public function logOut()
    {
        setcookie("user", "", time() - 3600);
        if ($_COOKIE["admin"]) {
            setcookie("admin", "", time() - 3600);
        }
        $this->render('login', ['messages' => ['Successfully logged out']]);
    }


}