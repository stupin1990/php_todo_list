<?php

namespace Src\Services\Validation;

class TaskValidation extends Validation
{
    public array $fields = [
        'name' => [
            'name' => 'User name',
            'type' => 'text:100'
        ],
        'email' => [
            'name' => 'User email',
            'type' => 'email:100'
        ],
        'post' => [
            'name' => 'Post',
            'type' => 'text'
        ],
        'done' => [
            'name' => 'Done',
            'type' => 'checkbox'
        ],
    ];
}
