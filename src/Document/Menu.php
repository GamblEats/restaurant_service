<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="menus")
 */
class Menu
{
    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * @MongoDB\ReferenceOne(targetDocument=Restaurant::class, inversedBy="menus", storeAs="id")
     */
    protected Restaurant $restaurant;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected array $items = [];

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $pic = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $description = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected ?float $price = null;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPic(): ?string
    {
        return $this->pic;
    }

    /**
     * @param string|null $pic
     */
    public function setPic(?string $pic): void
    {
        $this->pic = $pic;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Restaurant
     */
    public function getRestaurant(): Restaurant
    {
        return $this->restaurant;
    }

    /**
     * @param Restaurant $restaurant
     */
    public function setRestaurant(Restaurant $restaurant): void
    {
        $this->restaurant = $restaurant;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'restaurant' => $this->getRestaurant()->getName(),
            'name' => $this->getName(),
            'pic' => $this->getPic(),
            'price' => $this->getPrice(),
            'description' => $this->getDescription(),
        ];
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}