<?php

namespace BeerApi\Shopping\Beers\Application\DTOs;

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
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Class BeerDTO
 * @package BeerApi\Shopping\Beers\Application\DTOs
 */
class BeerDTO implements JsonSerializable
{
    private BeerId $id;
    private BeerName $name;
    private BeerDescription $description;
    private BeerCountry $country;
    private BeerCity $city;
    private BeerLikes $likes;
    private Category $category;
    private BeerPrice $price;
    private BeerVolume $volume;
    private BeerManufacturingDate $date;
    private string|null $image;

    public function __construct(
        BeerId                $id,
        BeerName              $name,
        BeerDescription       $description,
        BeerCountry           $country,
        BeerCity              $city,
        BeerLikes             $likes,
        BeerPrice             $price,
        BeerVolume            $volume,
        BeerManufacturingDate $date,
        string|null           $image,
        Category              $category
    )
    {

        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->country = $country;
        $this->city = $city;
        $this->likes = $likes;
        $this->price = $price;
        $this->volume = $volume;
        $this->date = $date;
        $this->image = $image;
        $this->category = $category;
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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
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

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
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
                "manufacturing_date" => $this->date->getValue(),
                "image" => $this->image,
                "category" => array(
                    "id" => $this->category->getCategoryId()->getValue(),
                    "properties" => array(
                        "name" => $this->category->getCategoryName()->getValue(),
                        "description" => $this->category->getCategoryDescription()->getValue()
                    )
                )
            )
        );
    }
}