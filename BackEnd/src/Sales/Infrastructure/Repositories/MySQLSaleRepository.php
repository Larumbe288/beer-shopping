<?php

namespace BeerApi\Shopping\Sales\Infrastructure\Repositories;

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
use BeerApi\Shopping\Connection\Doctrine;
use BeerApi\Shopping\Sales\Domain\Exceptions\SalesNotFound;
use BeerApi\Shopping\Sales\Domain\Repositories\SaleRepository;
use BeerApi\Shopping\Sales\Domain\Sale;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleDate;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleId;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleQuantity;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleStatus;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;
use BeerApi\Shopping\Users\Domain\ValueObject\UserRole;
use DateTime;
use Doctrine\DBAL\Exception;

/**
 * Class MySQLSaleRepository
 * @package BeerApi\Shopping\Sales\Infrastructure\Repositories
 */
class MySQLSaleRepository implements SaleRepository
{

    /**
     * @throws Exception
     */
    public function insert(Sale $sale): void
    {
        $qb = Doctrine::access();
        $qb->insert('sales')->values(array(
            'UUID' => ':uuid',
            'idUsr' => ':user',
            'idProd' => ':beer',
            'quantity' => ':quant',
            'timestamp' => ':date',
            'status' => ':status'
        ))->setParameter(':uuid', $sale->getId()->getValue())->setParameter(':user', $sale->getUser()->getUserId()->getValue())
            ->setParameter(':beer', $sale->getBeer()->getId()->getValue())->setParameter(':quant', $sale->getQuantity()->getValue())
            ->setParameter(':date', $sale->getDate()->dateToString())->setParameter(':status', $sale->getStatus()->getValue())
            ->execute();
        $qb = null;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findById(SaleId $id): Sale
    {
        $qb = Doctrine::access();
        $result = $qb->select('s.UUID as saleId,quantity,timestamp,status,u.UUID as userId,u.name as userName,email,password,address,birth_date,phone,role
        ,p.UUID as beerId,p.name as BeerName,description,country,city,likes,idCat,price,volume,manufacturing_date')
            ->from('sales', 's')
            ->join('s', 'users', 'u', 's.idUsr=u.UUID')
            ->join('s', 'products', 'p', 's.idProd=p.UUID')
            ->where('s.UUID = :uuid')->setParameter(':uuid', $id->getValue())
            ->execute()->fetchAllAssociative();
        $qb = null;
        return $this->mapToSale($result)[0];
    }

    /**
     * @throws Exception
     */
    public function findByUser(UserId $id): array
    {
        $qb = Doctrine::access();
        $result = $qb->select('s.UUID as saleId,quantity,timestamp,status,u.UUID as userId,u.name as userName,email,password,address,birth_date,phone,role
        ,p.UUID as beerId,p.name as BeerName,description,country,city,likes,idCat,price,volume,manufacturing_date')->from('sales', 's')
            ->join('s', 'users', 'u', 's.idUsr=u.UUID')
            ->join('s', 'products', 'p', 's.idProd=p.UUID')
            ->where('u.UUID = :uuid')->setParameter(':uuid', $id->getValue())
            ->execute()->fetchAllAssociative();
        $qb = null;
        return $this->mapToSale($result);

    }

    /**
     * @throws SalesNotFound
     * @throws \Exception
     */
    private function mapToSale(array $result): array
    {
        $saleList = [];
        for ($i = 0; $i < count($result); $i++) {
            $saleId = new SaleId($result[$i]['saleId']);
            $quantity = new SaleQuantity($result[$i]['quantity']);
            $date = new SaleDate(new DateTime($result[$i]['timestamp']));
            $status = new SaleStatus($result[$i]['status']);
            $userId = new UserId($result[$i]['userId']);
            $userName = new UserName($result[$i]['userName']);
            $email = new UserEmail($result[$i]['email']);
            $password = new UserPassword($result[$i]['password']);
            $address = new UserAddress($result[$i]['address']);
            $birth_date = new UserBirthDate($result[$i]['birth_date']);
            $phone = new UserPhone($result[$i]['phone']);
            $role = new UserRole($result[$i]['role']);
            $user = new User($userId, $userName, $email, $password, $address, $birth_date, $phone, $role);
            $beerId = new BeerId($result[$i]['beerId']);
            $beerName = new BeerName($result[$i]['BeerName']);
            $description = new BeerDescription($result[$i]['description']);
            $country = new BeerCountry($result[$i]['country']);
            $city = new BeerCity($result[$i]['city']);
            $likes = new BeerLikes((int)$result[$i]['likes']);
            $idCat = new BeerCategoryId($result[$i]['idCat']);
            $price = new BeerPrice((float)$result[$i]['price']);
            $volume = new BeerVolume((int)$result[$i]['volume']);
            $manufacturing_date = new BeerManufacturingDate($result[$i]['manufacturing_date']);
            $beer = new Beer($beerId, $beerName, $description, $country, $city, $likes, $idCat, $price, $volume, $manufacturing_date);
            $sale = new Sale($user, $beer, $saleId, $quantity, $status, $date);
            $saleList[] = $sale;
        }
        if (empty($saleList)) {
            throw new SalesNotFound();
        }
        return $saleList;
    }
}