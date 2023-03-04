<form action="<?= $url ?>" method="POST" class="mb-4">
    <div class="mb-3">
        <label for="name" class="form-label">User name</label>
        <input type="text" name="name" class="form-control" id="name" value="<?= $this->name ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">User Email</label>
        <input type="email" name="email" class="form-control" value="<?= $this->email ?>" id="email" required>
    </div>

    <div class="mb-3">
        <label for="post" class="form-label">Post</label>
        <textarea class="form-control" name="post" required><?= $this->post ?></textarea>
        <?php if ($show_done) { ?>
        <div class="form-check">
            <input type="checkbox" name="done" value="1" id="done" <?= $this->done ? 'checked' : '' ?>>
            <label class="form-check-label" for="done">Done</label>
        </div>
        <?php } ?>
    </div>

    <button type="submit" class="btn btn-primary">Add</button>
</form>