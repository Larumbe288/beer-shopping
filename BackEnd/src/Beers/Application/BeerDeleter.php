<?php

namespace BeerApi\Shopping\Beers\Application;

use BeerApi\Shopping\Beers\Domain\Repositories\BeerRepository;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerId;

/**
 * Class BeerDeleter
 * @package BeerApi\Shopping\Beers\Application
 */
class BeerDeleter
{
    private BeerRepository $repository;

    public function __construct(BeerRepository $repository)
    {

        $this->repository = $repository;
    }

    public function __invoke(BeerId $id)
    {
        $beer = $this->repository->find($id);
        $beer->delete();
        $this->repository->delete($beer);
    }
}