<?php

namespace Src\Services\Validation;

class TaskValidation extends Validation
{
    /**
     * Field names and validation rules
     */
    public array $fields = [
        'name' => [
            'name' => 'User name',
            'type' => 'required|text|max:100'
        ],
        'email' => [
            'name' => 'User email',
            'type' => 'required|email|max:100'
        ],
        'post' => [
            'name' => 'Post',
            'type' => 'required|text'
        ],
        'done' => [
            'name' => 'Done',
            'type' => 'required|checkbox'
        ],
    ];
}
