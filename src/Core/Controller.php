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

    /**
     * Prepearing post dato for saving in model
     * @param array $fields - items that should be added and validated from $data array
     * @param array $data - fields => values array
     * @param ValidationInterface $validator - validation interface
     * 
     * @return array [$errors, $params]
     */
    public function prepareSaveData(array $fields, array $data, ValidationInterface $validator): array
    {
        $errors = $params = [];
        foreach ($fields as $field) {
            $validated = $validator->validate($field, $data[$field] ?? '');
            $params[':' . $field] = $validated['value'];
            if ($validated['error']) {
                $errors[] = $validated['error'];
            }
        }

        return [$errors, $params];
    }

    /**
     * Invoking render method from view
     * @param string $template_name
     * @param array $data
     * @param string $layout
     * 
     * @return void
     */
    public function render(string $template_name, $data = [], $layout = '') : void
    {
        if (!$layout) {
            $layout = $this->layout;
        }

        $data['authorized'] = $this->authorized;

        $this->view->render($template_name, $data, $layout);
    }
}
