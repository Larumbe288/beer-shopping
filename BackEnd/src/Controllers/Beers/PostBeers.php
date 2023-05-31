<?php

namespace BeerApi\Shopping\Controllers\Beers;

use BeerApi\Shopping\Beers\Application\BeerCreator;
use BeerApi\Shopping\Beers\Application\BeerFinder;
use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerCategoryId;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerCity;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerCountry;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerDescription;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerId;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerLikes;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerManufacturingDate;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerName;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerPrice;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerVolume;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Class PostBeers
 * @package BeerApi\Shopping\Controllers\Beers
 */
class PostBeers
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $beer = $this->getBeer($request);
        /** @var BeerFinder $finder */
        $finder = $this->container->get(BeerFinder::class);
        /** @var BeerCreator $creator */
        $creator = $this->container->get(BeerCreator::class);
        $creator->__invoke($beer->getName(), $beer->getDescription(), $beer->getCountry(), $beer->getCity(), $beer->getLikes(), $beer->getCategoryId()
            , $beer->getPrice(), $beer->getVolume(), $beer->getDate());
        return $finder->__invoke($beer->getId());
    }

    /**
     * @param Request $request
     * @return Beer
     */
    private function getBeer(Request $request): Beer
    {
        $beerId = new BeerId($request->getParsedBody()['id']);
        $beerName = new BeerName($request->getParsedBody()['name']);
        $beerDescription = new BeerDescription($request->getParsedBody()['description']);
        $beerCountry = new BeerCountry($request->getParsedBody()['country']);
        $beerCity = new BeerCity($request->getParsedBody()['city']);
        $beerLikes = new BeerLikes((int)$request->getParsedBody()['likes']);
        $beerIdCat = new BeerCategoryId($request->getParsedBody()['idCat']);
        $beerPrice = new BeerPrice((float)$request->getParsedBody()['price']);
        $beerVolume = new BeerVolume((int)$request->getParsedBody()['volume']);
        $beerDate = new BeerManufacturingDate($request->getParsedBody()['date']);
        return new Beer($beerId, $beerName, $beerDescription, $beerCountry, $beerCity, $beerLikes, $beerIdCat, $beerPrice, $beerVolume, $beerDate);
    }
}