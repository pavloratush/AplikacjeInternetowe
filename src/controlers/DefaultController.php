<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        $this->render('login');
    }

    public function friends()
    {
        if ($_COOKIE["user"]) {
            $this->render('friends');
        }else
        $this->render('login', ['messages' => ['You have to be logged in!']]);
    }


    public function settings()
    {
        if ($_COOKIE["user"]) {

            $this->render('settings');
        }else
        $this->render('login', ['messages' => ['You have to be logged in!']]);

    }

}

