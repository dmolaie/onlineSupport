<?php

namespace App\Services\Contracts\DTOs\Pagination;


use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PaginationDTOMaker
 */
class PaginationDTOMaker
{
    /**
     * @var int
     */
    protected $currentPage;
    /**
     * @var string
     */
    protected $firstPageUrl;
    /**
     * @var int
     */
    protected $from;
    /**
     * @var int
     */
    protected $lastPage;
    /**
     * @var string
     */
    protected $lastPageUrl;
    /**
     * @var string
     */
    protected $nextPageUrl;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var int
     */
    protected $perPage;
    /**
     * @var null|string
     */
    protected $prevPageUrl;
    /**
     * @var int
     */
    protected $to;
    /**
     * @var integer
     */
    protected $total;
    /**
     * @var array
     */
    protected $items = [];

    protected $paginationRecords;

    /**
     * @return mixed
     */
    public function getPaginationRecords()
    {
        return $this->paginationRecords;
    }


    public function perform(
        LengthAwarePaginator $paginator,
        string $itemDTOMaker,
        $inputForDTOMaker = null
    ) {
        $this->currentPage = $paginator->currentPage();
        $this->firstPageUrl = $paginator->url(1);
        $this->from = $paginator->firstItem();
        $this->lastPage = $paginator->lastPage();
        $this->lastPageUrl = $paginator->url($paginator->lastPage());
        $this->nextPageUrl = $paginator->nextPageUrl();
        $this->path = $paginator->path();
        $this->perPage = $paginator->perPage();
        $this->prevPageUrl = $paginator->previousPageUrl();
        $this->to = $paginator->lastItem();
        $this->total = $paginator->total();
        $this->items = $this->convertItemsToDTO($paginator->items(), $itemDTOMaker, $inputForDTOMaker);
        $paginator->setCollection(collect($this->convertItemsToDTO($paginator->items(), $itemDTOMaker,
            $inputForDTOMaker)));
        $this->paginationRecords = $paginator;
        return $this;
    }

    private function convertItemsToDTO(array $items, string $itemDTOMaker, $inputForDTOMaker = null)
    {
        $itemDtoMaker = new $itemDTOMaker;
        return $itemDtoMaker->convertMany(collect($items), $inputForDTOMaker);
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return string
     */
    public function getFirstPageUrl(): string
    {
        return $this->firstPageUrl;
    }

    /**
     * @return null|int
     */
    public function getFrom(): ?int
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * @return string
     */
    public function getLastPageUrl(): string
    {
        return $this->lastPageUrl;
    }

    /**
     * @return null|string
     */
    public function getNextPageUrl(): ?string
    {
        return $this->nextPageUrl;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return string|null
     */
    public function getPrevPageUrl(): ?string
    {
        return $this->prevPageUrl;
    }

    /**
     * @return null|int
     */
    public function getTo(): ?int
    {
        return $this->to;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }


}
