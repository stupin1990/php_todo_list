<?php

namespace Src\Core;

class Config {
    public const DB_HOST = 'localhost';
    public const DB_NAME = 'todo';
    public const DB_USER = 'root';
    public const DB_PASS = '123456';

    public const PER_PAGE = 3;
    public const TITLE = 'PHP TODO LIST';

    public const USERS = [
        'admin' => '123'
    ];
}