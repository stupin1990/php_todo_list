<?php

namespace Src\Core;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->layout = 'admin';

        $this->per_page = 5;

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($path, '/admin/index/login') === false && !$this->isAuthorized()) {
            header("Location: /admin/index/login");
            die;
        }
    }

    protected function isAuthorized()
    {
        ini_set('session.use_only_cookies', 1);
        session_start([
            'cookie_lifetime' => 0,
        ]);
        if (isset($_SESSION['user'])) {
            foreach (Config::USERS as $user => $pass) {
                if ($_SESSION['user'] == sha1($user . $pass)) {
                    $this->authorized = true;
                    return true;
                }
            }
        }

        return false;
    }

    protected function auth($user, $password)
    {
        foreach (Config::USERS as $u => $p) {
            if ($user == $u && $password == $p) {
                $_SESSION['user'] = sha1($user . $password);
                return true;
            }
        }

        return false;
    }

    public function login()
    {
        if ($this->isAuthorized()) {
            header("Location: /admin/index");
            die;
        }

        $errors = [];
        if (isset($_POST['user']) && isset($_POST['password'])) {
            if (!$this->auth($_POST['user'], $_POST['password'])) {
                $errors[] = 'Invalid user name or password!';
            } else {
                header("Location: /admin/index");
                die;
            }
        }

        $this->render('admin/login', [
            'errors' => $errors
        ]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: /admin/index/login");
    }
}
