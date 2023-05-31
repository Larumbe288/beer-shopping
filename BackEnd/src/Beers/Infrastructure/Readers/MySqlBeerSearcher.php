<?php

namespace BeerApi\Shopping\Beers\Infrastructure\Readers;

use BeerApi\Shopping\Beers\Application\DTOs\BeerDTO;
use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Beers\Domain\Exceptions\BeerNotFound;
use BeerApi\Shopping\Beers\Domain\Readers\BeerSearcher;
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
use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use BeerApi\Shopping\Connection\Doctrine;
use Doctrine\DBAL\Driver\Exception;

/**
 * Class MySqlBeerSearcher
 * @package BeerApi\Shopping\Beers\Infrastructure\Readers
 */
class MySqlBeerSearcher implements BeerSearcher
{

    /**
     * @param string $value
     * @return Beer[]
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws BeerNotFound
     */
    public function findBeerBySearch(string $value): array
    {
        $qb = Doctrine::access();
        $result = $qb->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('p.name LIKE :value')->orWhere('p.description LIKE :value')
            ->orWhere('country LIKE :value')->orWhere('city LIKE :value')
            ->orderBy('likes', 'DESC')
            ->setParameter(':value', '%' . $value . '%')
            ->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }

    /**
     * @param array $result
     * @return array
     * @throws BeerNotFound
     */
    private function mapToBeerDto(array $result): array
    {
        $beers = [];
        for ($i = 0; $i < count($result); $i++) {
            $id = new BeerId($result[$i]['UUID']);
            $name = new BeerName($result[$i]['name']);
            $description = new BeerDescription($result[$i]['description']);
            $country = new BeerCountry($result[$i]['country']);
            $city = new BeerCity($result[$i]['city']);
            $likes = new BeerLikes((int)$result[$i]['likes']);
            $idCat = new CategoryId($result[$i]['idCat']);
            $price = new BeerPrice((float)$result[$i]['price']);
            $volume = new BeerVolume((int)$result[$i]['volume']);
            $date = new BeerManufacturingDate($result[$i]['manufacturing_date']);
            $image = $result[$i]['source'];
            $categoryName = new CategoryName($result[$i]['catName']);
            $categoryDescription = new CategoryDescription($result[$i]['catDesc']);
            $subCategory = $result[$i]['subCat'] !== null ? new CategoryId($result[$i]['subCat']) : null;
            $category = new Category($idCat, $categoryName, $categoryDescription, $subCategory);
            $beers[] = new BeerDTO($id, $name, $description, $country, $city, $likes, $price, $volume, $date, $image, $category);
        }
        if (empty($beers)) {
            throw new BeerNotFound();
        }
        return $beers;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     * @throws BeerNotFound
     */
    public function findBeerInAPriceRange(int $min_value, int $max_value): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('price >= :min')->andWhere('price <= :max')
            ->setParameter(':min', $min_value)->setParameter(':max', $max_value)
            ->orderBy('price', 'ASC')
            ->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }


    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     * @throws BeerNotFound
     */
    public function findBeerByLikesOrMore(int $likes): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('likes >= :likes')->setParameter(':likes', $likes)
            ->orderBy('likes', 'ASC')
            ->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     * @throws BeerNotFound
     */
    public function findBeerByCategory(string $idCat): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('idCat = :cat')->setParameter(':cat', $idCat)
            ->orderBy('id', 'DESC')
            ->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     * @throws BeerNotFound
     */
    public function findBeerByDateOrBefore(string $date): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('manufacturing_date <= :date')->setParameter(':date', $date)
            ->orderBy('manufacturing_date', 'DESC')
            ->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     * @throws BeerNotFound
     */
    public function findBeerInAVolumeRange(int $min_value, int $max_value): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('volume >= :min')->setParameter(':min', $min_value)
            ->andWhere('volume <= :max')->setParameter(':max', $max_value)
            ->orderBy('volume', 'ASC')->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws BeerNotFound
     */
    public function findBeersByCity(string $city): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('city = :city')->setParameter(':city', $city)
            ->orderBy('likes', 'DESC')->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     * @throws BeerNotFound
     */
    public function findBeersByCountry(string $country): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->where('country = :country')->setParameter(':city', $country)
            ->orderBy('likes', 'DESC')->execute()->fetchAllAssociative();
        return $this->mapToBeerDto($result);
    }
}