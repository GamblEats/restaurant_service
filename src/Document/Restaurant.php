<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="restaurants")
 */
class Restaurant
{
    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Item::class, mappedBy="restaurant")
     */
    protected ArrayCollection $items;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $pic;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $address = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $deliveryPrice = 0;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $deliveryTime;

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $rating = 0;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $description = '';

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected bool $isDeployed;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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
    public function getPic(): string
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

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'pic' => $this->getPic(),
            'id' => $this->getId()
        ];
    }

    public function toArrayFull(): array
    {
        $toArrayItems = [];
        foreach ($this->getItems() as $item) {
            $toArrayItems[] = $item->toArray();
        }

        return [
            'name' => $this->getName(),
            'pic' => $this->getPic(),
            'id' => $this->getId(),
            'address' => $this->getAddress(),
            'deliveryPrice' => $this->getDeliveryPrice(),
            'deliveryTime' => $this->getDeliveryPrice(),
            'rating' => $this->getRating(),
            'description' => $this->getDescription(),
            'items' => $toArrayItems
        ];
    }

    /**
     * @return bool
     */
    public function isDeployed(): bool
    {
        return $this->isDeployed;
    }

    /**
     * @param bool $isDeployed
     */
    public function setIsDeployed(bool $isDeployed): void
    {
        $this->isDeployed = $isDeployed;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getDeliveryPrice(): float
    {
        return $this->deliveryPrice;
    }

    /**
     * @param float $deliveryPrice
     */
    public function setDeliveryPrice(float $deliveryPrice): void
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @return string
     */
    public function getDeliveryTime(): string
    {
        return $this->deliveryTime;
    }

    /**
     * @param string $deliveryTime
     */
    public function setDeliveryTime(string $deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     */
    public function setItems(ArrayCollection $items): void
    {
        $this->items = $items;
    }
}