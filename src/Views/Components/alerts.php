<?php if ($success) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <div>Task was added!</div>   
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