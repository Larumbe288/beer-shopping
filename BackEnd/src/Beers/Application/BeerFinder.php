<?php

namespace BeerApi\Shopping\Beers\Application;

use BeerApi\Shopping\Beers\Domain\Repositories\BeerRepository;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerId;

class BeerFinder
{
    private BeerRepository $repository;

    public function __construct(BeerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BeerId $id
     * @return mixed
     */
    public function __invoke(BeerId $id)
    {
        return $this->repository->find($id);
    }
}