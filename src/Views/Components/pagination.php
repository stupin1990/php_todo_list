<ul class="pagination">
    <li class="page-item <?= $prev_page == $current_page ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>page=<?= $prev_page ?>">Previous</a></li>
    <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <li class="page-item <?= $current_page == $i ? 'active' : '' ?>"><a class="page-link" href="<?= $url ?>page=<?= $i ?>"><?= $i ?></a></li>
    <?php } ?>
    <li class="page-item <?= $next_page == $current_page ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>page=<?= $next_page ?>">Next</a></li>
</ul>