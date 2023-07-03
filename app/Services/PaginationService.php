<?php

namespace App\Services;

use Illuminate\Pagination\Paginator;

class PaginationService {

    public static function setCurrentPage(int $currentPage): void {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
    }

}
