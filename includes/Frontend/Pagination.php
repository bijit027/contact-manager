<div>
    <?php
    if ((int) $page > 1) {
        $prev = (float) $page - 1;
        _e('<div class="pagination"><a href = ' . $finalurl . "pageno=" . $prev . "><</a></div>");
    }
    if ((int) $page < $numberOfPage) {
        $next = (float) $page + 1;
        _e('<div class="pagination"><a href = ' . $finalurl . "pageno=" . $next . ">></a></div>");
    }
    for ($page = 1; $page <= $numberOfPage; $page++) {
        if ($page == $currentPage) {
            _e(
                '<div class="pagination"><a class="active" href = ' .
                    $finalurl .
                    "pageno=" .
                    $page .
                    ">" .
                    $page .
                    " </a></div>"
            );
        } else {
            _e(
                '<div class="pagination"><a class="" href = ' .
                    $finalurl .
                    "pageno=" .
                    $page .
                    ">" .
                    $page .
                    " </a></div>"
            );
        }
    }
    ?>
</div>