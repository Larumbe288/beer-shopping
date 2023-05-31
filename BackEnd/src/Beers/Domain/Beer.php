<?php

namespace BeerApi\Shopping\Beers\Domain;

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
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Class Beer
 * @package BeerApi\Shopping\Beers\Domain
 */
class Beer implements JsonSerializable
{
    private BeerId $id;
    private BeerName $name;
    private BeerDescription $description;
    private BeerCountry $country;
    private BeerCity $city;
    private BeerLikes $likes;
    private BeerCategoryId $categoryId;
    private BeerPrice $price;
    private BeerVolume $volume;
    private BeerManufacturingDate $date;

    public function __construct(
        BeerId                $id,
        BeerName              $name,
        BeerDescription       $description,
        BeerCountry           $country,
        BeerCity              $city,
        BeerLikes             $likes,
        BeerCategoryId        $categoryId,
        BeerPrice             $price,
        BeerVolume            $volume,
        BeerManufacturingDate $date
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->country = $country;
        $this->city = $city;
        $this->likes = $likes;
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->volume = $volume;
        $this->date = $date;
    }

    /**
     * @throws Exception
     */
    public static function create(
        BeerName              $name,
        BeerDescription       $description,
        BeerCountry           $country,
        BeerCity              $city,
        BeerLikes             $likes,
        BeerCategoryId        $categoryId,
        BeerPrice             $price,
        BeerVolume            $volume,
        BeerManufacturingDate $date
    )
    {
        return new Beer(BeerId::generate(), $name, $description, $country, $city, $likes, $categoryId, $price, $volume, $date);
    }

    /**
     * @return BeerId
     */
    public function getId(): BeerId
    {
        return $this->id;
    }

    /**
     * @return BeerName
     */
    public function getName(): BeerName
    {
        return $this->name;
    }

    /**
     * @return BeerDescription
     */
    public function getDescription(): BeerDescription
    {
        return $this->description;
    }

    /**
     * @return BeerCountry
     */
    public function getCountry(): BeerCountry
    {
        return $this->country;
    }

    /**
     * @return BeerCity
     */
    public function getCity(): BeerCity
    {
        return $this->city;
    }

    /**
     * @return BeerLikes
     */
    public function getLikes(): BeerLikes
    {
        return $this->likes;
    }

    /**
     * @return BeerCategoryId
     */
    public function getCategoryId(): BeerCategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return BeerPrice
     */
    public function getPrice(): BeerPrice
    {
        return $this->price;
    }

    /**
     * @return BeerVolume
     */
    public function getVolume(): BeerVolume
    {
        return $this->volume;
    }

    /**
     * @return BeerManufacturingDate
     */
    public function getDate(): BeerManufacturingDate
    {
        return $this->date;
    }

    #[Pure] #[ArrayShape(["id" => "string", "properties" => "array"])] public function jsonSerialize(): array
    {
        return array(
            "id" => $this->id->getValue(),
            "properties" => array(
                "name" => $this->name->getValue(),
                "description" => $this->description->getValue(),
                "country" => $this->country->getValue(),
                "city" => $this->city->getValue(),
                "likes" => $this->likes->getValue(),
                "price" => $this->price->getValue(),
                "volume" => $this->volume->getValue(),
                "manufacturing_date" => $this->date->getValue()
            )
        );
    }

    public function delete()
    {
        //nothing to check
    }

    private function update(
        BeerName              $name,
        BeerDescription       $description,
        BeerCountry           $country,
        BeerCity              $city,
        BeerLikes             $likes,
        BeerCategoryId        $categoryId,
        BeerPrice             $price,
        BeerVolume            $volume,
        BeerManufacturingDate $manufacturingDate): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->country = $country;
        $this->city = $city;
        $this->likes = $likes;
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->volume = $volume;
        $this->date = $manufacturingDate;
    }

    public static function randomBeer(): Beer
    {
        return new self(BeerId::generate(), BeerName::randomName(), BeerDescription::randomDescription(), BeerCountry::randomCountry(), BeerCity::randomCity(), BeerLikes::randomLikes(), new BeerCategoryId('d0720b1b-db49-41e2-93e3-81ed5da488e6'),
            BeerPrice::randomPrice(), BeerVolume::randomVolume(), BeerManufacturingDate::randomDate());
    }
}