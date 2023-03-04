<?php

namespace Src\Core;

use Src\Services\Validation\ValidationInterface;

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

        $this->view = new View();
    }

    public function prepareSaveData(array $fields, array $data, ValidationInterface $validator): array
    {
        $errors = $params = [];
        foreach ($fields as $field) {
            if ($field == 'updated_by') {
                $params[':' . $field] = $this->authorized ? 'admin' : 'guest';
            } else {
                $validated = $validator->validate($field, $data[$field] ?? '');
                $params[':' . $field] = $validated['value'];
                if ($validated['error']) {
                    $errors[] = $validated['error'];
                }
            }
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
