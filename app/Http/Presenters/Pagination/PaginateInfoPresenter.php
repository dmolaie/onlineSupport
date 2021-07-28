<?php


namespace App\Http\Presenters\Pagination;

use App\Services\Contracts\DTOs\Pagination\PaginationDTOMaker;

class PaginateInfoPresenter
{

    public function transform(PaginationDTOMaker $paginationDTO)
    {
        return [
            'current_page'   => $paginationDTO->getCurrentPage(),
            'first_page_url' => $paginationDTO->getFirstPageUrl(),
            'from'           => $paginationDTO->getFrom(),
            'last_page'      => $paginationDTO->getLastPage(),
            'last_page_url'  => $paginationDTO->getLastPageUrl(),
            'next_page_url'  => $paginationDTO->getNextPageUrl(),
            'path'           => $paginationDTO->getPath(),
            'per_page'       => $paginationDTO->getPerPage(),
            'prev_page_url'  => $paginationDTO->getPrevPageUrl(),
            'to'             => $paginationDTO->getTo(),
            'total'          => $paginationDTO->getTotal(),
        ];
    }
}
