<div>
    <?php
    if ((int) $page > 1) {
        $prev = (float) $page - 1;
        _e(
            '<div class="pagination"><a href = ' .
                $finalurl .
                "pageno=" .
                $prev .
                "><</a></div>"
        );
    }
    if ((int) $page < $number_of_page) {
        $next = (float) $page + 1;
        _e(
            '<div class="pagination"><a href = ' .
                $finalurl .
                "pageno=" .
                $next .
                ">></a></div>"
        );
    }
    for ($page = 1; $page <= $number_of_page; $page++) {
        if ($page == $current_page) {
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