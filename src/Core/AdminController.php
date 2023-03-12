<?php

namespace Src\Core;

class AdminController extends Controller
{
    use Auth;

    public function __construct()
    {
        parent::__construct();

        $this->layout = 'admin';

        $this->per_page = 5;

        $this->checkAuthentication();
    }
}
