<?php

namespace Src\Core;

/**
* Trait that implements authentication methods
 */
trait Auth
{
    protected $login_url = '/admin/index/login';
    protected $redirect_url = '/admin/index';
    protected $login_view = 'admin/login';

    /**
     * Check that user is authenticated, redirect if not
     * @return void
     */
    protected function checkAuthentication() : void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($path, $this->login_url) === false && !$this->isAuthenticated()) {
            header("Location: {$this->login_url}");
            die;
        }
    }

    /**
     * Start session and check if authenticated user is exist
     * @return bool
     */
    protected function isAuthenticated() : bool
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

    /**
     * Add authenticated user to session
     * @param mixed $user
     * @param mixed $password
     * 
     * @return bool
     */
    protected function auth($user, $password) : bool
    {
        if (isset(Config::USERS[$user]) && Config::USERS[$user] == $password) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    /**
     * Main action for auth page
     */
    public function login()
    {
        if ($this->isAuthenticated()) {
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

    /**
     * Logout action
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: {$this->login_url}");
    }
}