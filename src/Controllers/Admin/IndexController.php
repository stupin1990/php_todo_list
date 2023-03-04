<?php

namespace Src\Controllers\Admin;

use Src\Core\AdminController;
use Src\Models\Task;
use Src\Services\Validation\TaskValidation;

class IndexController extends AdminController
{
    public function index()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fields = ['name', 'email', 'post', 'done', 'updated_by'];
            // Save new post
            if (isset($_POST['name'])) {
                list($errors, $params) = $this->prepareSaveData($fields, $_POST, TaskValidation::getInstance());
                if (!count($errors)) {
                    $errors = Task::add($fields, $params);
                }
                if (!count($errors)) {
                    header("Location: /admin/index?success=1");
                    die;
                }
            }
            // Update exists posts
            elseif ($_POST['task']) {
                $delete_ar = [];
                foreach ($_POST['task'] as $id => $data) {
                    if (isset($data['delete'])) {
                        $delete_ar[] = $id;
                        continue;
                    }
                    list($errors, $params) = $this->prepareSaveData($fields, $data, TaskValidation::getInstance());
                    if (!count($errors)) {
                        $_errors = Task::update($id, $fields, $params);
                        $errors = array_merge($errors, $_errors);
                    }
                }
                if (count($delete_ar) && !Task::delete($delete_ar)) {
                    $errors[] = 'Failed to delete data!';
                }
                if (!count($errors)) {
                    header("Location: /admin/index?success=1");
                    die;
                }
            }
        }

        $sort_by = $_GET['sort'] ?? '';

        $tasks = Task::selectPaginate(['id', 'name', 'email', 'post', 'done'], $this->page, $sort_by, $this->per_page);

        $this->render('admin/index', [
            'tasks' => $tasks,
            'success' => $_GET['success'] ?? 0,
            'errors' => $errors,
            'sort_ar' => Task::$sort_ar,
            'sort' => $sort_by,
        ]);
    }
}
