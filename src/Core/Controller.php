<?php

namespace Src\Core;

class Controller
{
    protected int $page = 1;
    protected int $per_page;
    protected $view;
    protected $layout = 'main';
    public bool $authorized = false;

    public function __construct()
    {
        $page = $_GET['page'] ?? 1;

        $this->page = $page < 1 ? 1 : (int)$page;

        $this->per_page = Config::PER_PAGE;

        $this->view = new View;
    }

    public function isPostData(array $fields) : bool
    {
        $is_post_items = array_filter($fields, function ($item) { return isset($_POST[$item]); });
        return count($is_post_items) ? true : false;
    }

    public function prepareSaveData(array $fields, array $data) : array
    {
        $errors = $params = [];
        foreach($fields as $field) {
            if (!isset($data[$field]) && $field == 'done') {
                $params[':' . $field] = 0;
                continue;
            }
            elseif (!isset($data[$field]) && $field == 'updated_by') {
                $params[':' . $field] = $this->authorized ? 'admin' : 'guest';
                continue;
            }
            elseif (!isset($data[$field])) {
                $errors[] = "Please enter field: $field!";
                continue;
            }
            elseif ($field == 'email' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email address is invalid.";
                continue;
            }
            $params[':' . $field] = htmlentities($data[$field]);
        }

        return [$errors, $params];
    }

    public function render(string $template_name, $data = [], $layout = '')
    {
        if (!$layout) {
            $layout = $this->layout;
        }

        $data['authorized'] = $this->authorized;

        $this->view->render($template_name, $data, $layout);
    }
}