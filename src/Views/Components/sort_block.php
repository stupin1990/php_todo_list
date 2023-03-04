<form action="<?= $url ?>" method="GET">
<select class="form-select" name="sort" onchange="submit()">
    <?php foreach ($sort_ar as $sort_val => $sort_name) { ?>
    <option value="<?= $sort_val ?>" <?= $sort_val == $sort ? 'selected' : '' ?>><?= $sort_name ?></option>
    <?php } ?>
</select>
</form>
