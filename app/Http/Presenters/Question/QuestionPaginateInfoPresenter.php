<?php


namespace App\Http\Presenters\Question;


use App\Http\Presenters\Pagination\PaginateInfoPresenter;
use App\Services\Contracts\DTOs\Pagination\PaginationDTOMaker;

class QuestionPaginateInfoPresenter
{
    /**
     * @var PaginateInfoPresenter
     */
    private $paginateInfoPresenter;
    /**
     * @var QuestionInfoPresenter
     */
    private $questionInfoPresenter;

    public function __construct(
        PaginateInfoPresenter $paginateInfoPresenter,
        QuestionInfoPresenter $questionInfoPresenter
    ) {

        $this->paginateInfoPresenter = $paginateInfoPresenter;
        $this->questionInfoPresenter = $questionInfoPresenter;
    }

    public function transform(PaginationDTOMaker $paginationDTOMaker)
    {
        $paginateResult = $this->paginateInfoPresenter->transform($paginationDTOMaker);
        $paginateResult['items'] = $this->questionInfoPresenter->transformMany(
            $paginationDTOMaker->getItems()
        );
        return $paginateResult;
    }
}
