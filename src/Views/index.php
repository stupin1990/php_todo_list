<div class="mx-2">
    <h4>Tasks</h4>

    <?php $this->renderPartial('/Components/alerts', [
        'success' => $success,
        'errors' => $errors,
    ]) ?>

    <div class="card-20">
        <?php $this->renderPartial('/Components/sort_block', [
            'url' => $url,
            'sort_ar' => $sort_ar,
            'sort' => $sort
        ]) ?>
    </div>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 mx-0 mb-4">
    <?php if ($tasks['total']) { ?>
        <?php foreach ($tasks['data'] as $task) { ?>
            <div class="col-4 card me-2 mt-2 card-20">
                <div class="card-body">
                    <h5 class="card-title"><?= $task['name'] ?></h5>
                    <h5 class="card-title"><?= $task['email'] ?></h5>
                    <p class="card-text"><?= $task['post'] ?></p>
                    <span class="badge text-bg-<?= $task['done'] ? 'success' : 'danger' ?>"><?= $task['done'] ? 'Done' : 'Undone' ?></span>
                    <?php if ($task['updated_by'] == 'admin') { ?>
                        <span class="badge text-bg-info">Updated by admin</span>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="alert alert-secondary mt-2" role="alert">
            There are no tasks!
        </div>
    <?php } ?>
    </div>

    <?php if ($tasks['pages'] > 1) { ?>
        <?php $this->renderPartial('Components/pagination', [
            'pages' => $tasks['pages'],
            'current_page' => $tasks['current_page'],
            'next_page' => $tasks['next_page'],
            'prev_page' => $tasks['prev_page'],
            'per_page' => $tasks['per_page'],
            'total' => $tasks['total'],
            'url' => $url
        ]) ?>
    <?php } ?>

    <h4>Add new task</a></h4>

    <?php $this->renderPartial('/Components/add_form', [
        'url' => $url,
        'show_done' => 0
    ]) ?>

</div>
