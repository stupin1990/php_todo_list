<?php

namespace Src\Models;

use Src\Core\DB;
use Src\Core\Model;
use Src\Core\Config;

class Task extends Model
{
    protected static string $table_name = 'tasks';

    public static array $sort_ar = [
        'id_desc' => 'Sort tasks',
        'name_asc' => 'Name &and;',
        'name_desc' => 'Name &or;',
        'email_asc' => 'Email &and;',
        'email_desc' => 'Email &or;',
        'done_asc' => 'Done &and;',
        'done_desc' => 'Done &or;'
    ];

    protected static array $default_values = [
        'updated_at' => "NOW()"
    ];

    protected static array $not_to_update_fields = [
        'updated_by'
    ];
}
