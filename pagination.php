<?php

function paginate($page, $limit = 10) {
    $page = max(1, intval($page));
    $offset = ($page - 1) * $limit;
    return [$limit, $offset];
}

function totalPages($total, $limit) {
    return ceil($total / $limit);
}
