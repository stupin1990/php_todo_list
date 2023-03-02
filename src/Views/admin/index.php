<div class="mx-2">
    <h4>Edit tasks</h4>

    <?php if ($success) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>Tasks was saved!</div>   
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <?php if ($errors) { ?>
    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div><?= $error ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php } ?>
    
    <div class="d-flex mt-2">
    <?php if ($tasks['total']) { ?>
        <form action="<?= $url ?>" method="POST">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Post</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
        <?php foreach ($tasks['data'] as $task) { ?>
            <tr>
                <td><?= $task['id'] ?></th>
                <td><input type="text" name="task[<?= $task['id'] ?>][name]" class="form-control" value="<?= $task['name'] ?>" required></td>
                <td><input type="email" name="task[<?= $task['id'] ?>][email]" class="form-control" value="<?= $task['email'] ?>" required></td>
                <td>
                    <textarea class="form-control" name="task[<?= $task['id'] ?>][post]" required><?= $task['post'] ?></textarea>
                    <div class="form-check">
                        <input type="checkbox" id="done_<?= $task['id'] ?>" name="task[<?= $task['id'] ?>][done]" value="1" <?= $task['done'] ? ' checked' : '' ?>>
                        <label class="form-check-label" for="done_<?= $task['id'] ?>">Done</label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" name="task[<?= $task['id'] ?>][delete]" value="1">
                    </div>
                </td>
            </tr>
        <?php } ?>
        </table>
        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    <?php } else { ?>
        <div class="alert alert-secondary" role="alert">
            There are no tasks!
        </div>
    <?php } ?>
    </div>

    <?php if ($tasks['pages'] > 1) { ?>
        <div class="mt-4">
        <?php $this->renderPartial('/Components/pagination', [
            'pages' => $tasks['pages'],
            'current_page' => $tasks['current_page'],
            'next_page' => $tasks['next_page'],
            'prev_page' => $tasks['prev_page'],
            'per_page' => $tasks['per_page'],
            'total' => $tasks['total'],
            'url' => $url
        ]) ?>
        </div>
    <?php } ?>

    <h4>Add new task</a></h4>
        
    <form action="<?= $url ?>" method="POST" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">User name</label>
            <input type="text" name="new_task[name]" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">User Email</label>
            <input type="email" name="new_task[email]" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
            <label for="post" class="form-label">Post</label>
            <textarea class="form-control" name="new_task[post]" required></textarea>
            <div class="form-check">
                <input type="checkbox" name="new_task[done]" value="1" id="done">
                <label class="form-check-label" for="done">Done</label>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

</div>