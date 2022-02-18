<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{

    public function login()
    {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if(!password_verify($password,$user->getPassword())){
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        setcookie("user", $email, time() + (86400 * 30), "/");

        if($user->getIsAdmin()){
            setcookie("admin", 1, time() + (86400 * 30), "/");
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/profile");
    }
}