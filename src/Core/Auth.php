<?php

namespace Src\Core;

trait Auth
{
    protected $login_url = '/admin/index/login';
    protected $redirect_url = '/admin/index';
    protected $login_view = 'admin/login';

    protected function checkAuthorize()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($path, $this->login_url) === false && !$this->isAuthorized()) {
            header("Location: {$this->login_url}");
            die;
        }
    }

    protected function isAuthorized()
    {
        ini_set('session.use_only_cookies', 1);
        session_start([
            'cookie_lifetime' => 0,
        ]);
        if (isset($_SESSION['user']) && isset(Config::USERS[$_SESSION['user']])) {
            $this->authorized = true;
            return true;
        }

        return false;
    }

    protected function auth($user, $password)
    {
        if (isset(Config::USERS[$user]) && Config::USERS[$user] == $password) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    public function login()
    {
        if ($this->isAuthorized()) {
            header("Location: {$this->redirect_url}");
            die;
        }

        $errors = [];
        if (isset($_POST['user']) && isset($_POST['password'])) {
            if (!$this->auth($_POST['user'], $_POST['password'])) {
                $errors[] = 'Invalid user name or password!';
            } else {
                header("Location: {$this->redirect_url}");
                die;
            }
        }

        $this->render($this->login_view, [
            'errors' => $errors
        ]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: {$this->login_url}");
    }
}