<?php

namespace BeerApi\Shopping\Beers\Infrastructure;

use BeerApi\Shopping\Beers\Application\DTOs\BeerDTO;
use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Beers\Domain\Exceptions\BeerNotFound;
use BeerApi\Shopping\Beers\Domain\Repositories\BeerRepository;
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
use Doctrine\DBAL\Exception;

/**
 * Class MySqlBeerRepository
 * @package BeerApi\Shopping\Beers\Infrastructure
 */
class MySqlBeerRepository implements BeerRepository
{

    /**
     * @throws Exception
     */
    public function insert(Beer $beer): void
    {
        $id = $beer->getId()->getValue();
        $name = $beer->getName()->getValue();
        $description = $beer->getDescription()->getValue();
        $country = $beer->getCountry()->getValue();
        $city = $beer->getCity()->getValue();
        $likes = $beer->getLikes()->getValue();
        $idCat = $beer->getCategoryId()->getValue();
        $price = $beer->getPrice()->getValue();
        $volume = $beer->getVolume()->getValue();
        $date = $beer->getDate()->getValue();
        $db = Doctrine::access();
        $db->insert('products')->values(array(
                'UUID' => ':id',
                'name' => ':name',
                'description' => ':desc',
                'country' => ':country',
                'city' => ':city',
                'likes' => ':likes',
                'idCat' => ':idCat',
                'price' => ':price',
                'volume' => ':volume',
                'manufacturing_date' => ':date'
            )
        )->setParameter(':id', $id)->setParameter(':name', $name)->setParameter(':desc', $description)
            ->setParameter(':country', $country)->setParameter(':city', $city)->setParameter(':likes', $likes)
            ->setParameter(':idCat', $idCat)->setParameter(':price', $price)->setParameter(':volume', $volume)
            ->setParameter(':date', $date)->execute();
        $db = null;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws BeerNotFound
     */
    public function find(BeerId $id): BeerDTO
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')->where('p.UUID=:id')
            ->setParameter(':id', $id->getValue())
            ->execute()->fetchAllAssociative();
        $db = null;
        return $this->mapToBeerDto($result)[0];
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws BeerNotFound
     */
    public function findAll(string $field, int $prev_offset, int $next_offset): array
    {
        $db = Doctrine::access();
        $result = $db->select('p.*,c.UUID as "idCat",c.name as "catName",c.description as "catDesc",c.idCat as "subCat",i.source')
            ->from('products', 'p')->join('p', 'categories', 'c', 'c.UUID=p.idCat')
            ->leftJoin('p', 'images', 'i', 'p.UUID=i.idProd')
            ->orderBy(':field', 'DESC')
            ->setParameter(':field', 'p.' . $field)->setFirstResult($prev_offset)->setMaxResults($next_offset)
            ->execute()->fetchAllAssociative();
        $db = null;
        return $this->mapToBeerDto($result);
    }

    /**
     * @throws Exception
     */
    public function update(Beer $beer): void
    {
        $db = Doctrine::access();
        $db->update('products')->where('UUID = :id')->setParameter(':id', $beer->getId()->getValue())
            ->set('name', ':name')->setParameter(':name', $beer->getName()->getValue())->set('description', ':desc')->setParameter(':desc',
                $beer->getDescription()->getValue())
            ->set('price', ':price')->setParameter(':price', $beer->getPrice()->getValue())->set('volume', ':volume')
            ->setParameter(':volume', $beer->getVolume()->getValue())->execute();
        $db = null;
    }

    /**
     * @throws Exception
     */
    public function delete(BeerId $beer): void
    {

        $db = Doctrine::access();
        $db->delete('products')->where('UUID = :id')->setParameter(':id', $beer->getValue())
            ->execute();
        $db = null;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws BeerNotFound
     */
    public function findTenMostPopularBeers(): array
    {
        $db = Doctrine::access();
        $result = $db->select('*')->from('products')
            ->orderBy('likes', 'DESC')->setMaxResults(10)->execute()->fetchAllAssociative();
        return $this->mapToBeer($result);
    }

    private function mapToBeer(array $result): array
    {
        $beers = [];
        for ($i = 0; $i < count($result); $i++) {
            $id = new BeerId($result[$i]['UUID']);
            $name = new BeerName($result[$i]['name']);
            $description = new BeerDescription($result[$i]['description']);
            $country = new BeerCountry($result[$i]['country']);
            $city = new BeerCity($result[$i]['city']);
            $likes = new BeerLikes((int)$result[$i]['likes']);
            $idCat = new BeerCategoryId($result[$i]['idCat']);
            $price = new BeerPrice((float)$result[$i]['price']);
            $volume = new BeerVolume((int)$result[$i]['volume']);
            $date = new BeerManufacturingDate($result[$i]['manufacturing_date']);
            $beers[] = new Beer($id, $name, $description, $country, $city, $likes, $idCat, $price, $volume, $date);
        }
        if (empty($beers)) {
            throw new BeerNotFound();
        }
        return $beers;
    }

    /**
     * @param array $result
     * @return BeerDto[]
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
}