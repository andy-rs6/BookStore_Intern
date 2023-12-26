<?php

namespace App\Utils;

use ArrayIterator;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Paginator
 * @package App\Utils
 */
class Paginator
{
    private ArrayIterator $result;
    private int $numResult;
    private int $currentPage;
    private int $pageSize;

    /**
     * Paginator constructor.
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(
        private QueryBuilder $queryBuilder,
    ) {
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return $this
     */
    final public function pagination(int $page = 1, int $pageSize): self
    {
        $this->currentPage = (int) max(1, $page);
        $firstResult = ($this->currentPage - 1) * $pageSize;

        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($pageSize)
            ->getQuery();

        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query, true);

        $this->result = $paginator->getIterator();
        $this->numResult = $paginator->count();

        $this->setPageSize($pageSize);

        return $this;
    }

    /**
     * @return ArrayIterator
     */
    final public function getResult(): ArrayIterator
    {
        return $this->result;
    }

    /**
     * @return int
     */
    final  public function getNumResult(): int
    {
        return $this->numResult;
    }

    /**
     * @return int
     */
    final  public function setPageSize($pageSize): int
    {
        return $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    final public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    final public function getLastPage(): int
    {
        return (int) ceil($this->numResult / $this->pageSize);
    }

    /**
     * @return int
     */
    final public function getPageSize(): int
    {
        return $this->pageSize;
    }


    /**
     * @return int
     */
    final public function getPreviousPage(): int
    {
        return max(1, $this->currentPage - 1);
    }


    /**
     * @return int
     */
    final public function getNextPage(): int
    {
        return min($this->getLastPage(), $this->currentPage + 1);
    }

    /**
     * @return int
     */
    final public function getTotalPages(): int
    {
        return (int) ceil($this->numResult / $this->pageSize);
    }
}
