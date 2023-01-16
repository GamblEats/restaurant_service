<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document(collection="items")
 */
class Item
{
    /**
     * @MongoDB\Id
     */
    protected mixed $_id = null;

    /**
     * @MongoDB\ReferenceOne(targetDocument=Restaurant::class, inversedBy="items", storeAs="id")
     */
    protected ?Restaurant $restaurant = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected ?float $price = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $name = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $pic = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $category = null;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->_id = $id;
    }

    /**
     * @return ?float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param ?string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ?string
     */
    public function getPic(): ?string
    {
        return $this->pic;
    }

    /**
     * @param string $pic
     */
    public function setPic(string $pic): void
    {
        $this->pic = $pic;
    }

    /**
     * @return ?string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'category' => $this->getCategory(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'pic' => $this->getPic()
        ];
    }

    /**
     * @return ?Restaurant
     */
    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    /**
     * @param ?Restaurant $restaurant
     */
    public function setRestaurant(?Restaurant $restaurant): void
    {
        $this->restaurant = $restaurant;
    }

}