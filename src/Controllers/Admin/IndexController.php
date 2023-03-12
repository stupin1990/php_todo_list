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
            $fields = ['name', 'email', 'post', 'done'];
            // Save new post
            if (isset($_POST['name'])) {
                $errors = $this->handleTasks($fields, $_POST);
                if (!count($errors)) {
                    header('Location: ' . $_SERVER['REQUEST_URI']. '&success=1');
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
                    $errors = $this->handleTasks($fields, $data, $id);
                    if (count($errors)) {
                        break;
                    }
                }
                if (!Task::delete($delete_ar)) {
                    $errors[] = 'Failed to delete data!';
                }
                if (!count($errors)) {
                    header('Location: ' . $_SERVER['REQUEST_URI']. '&success=1');
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
            'page' => $this->page
        ]);
    }

    /**
     * Add or update one task
     * @param mixed $fields
     * @param mixed $data
     * @param int $id
     * 
     * @return array
     */
    public function handleTasks($fields, $data, $id = 0) : array
    {
        list($errors, $params) = $this->prepareSaveData($fields, $data, TaskValidation::getInstance());
        if (!count($errors)) {
            $fields[] = 'updated_by';
            $params[':updated_by'] = 'admin';

            $saved = $id ?
                Task::update($id, $fields, $params) :
                Task::save($fields, $params);

            if (!$saved) {
                $errors[] = "Failed to save data!";
            }
        }

        return $errors;
    }
}
