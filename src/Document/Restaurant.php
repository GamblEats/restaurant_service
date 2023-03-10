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
    protected mixed $_id = null;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Item::class, mappedBy="restaurant")
     */
    protected ArrayCollection $items;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Menu::class, mappedBy="restaurant")
     */
    protected ArrayCollection $menus;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $owner;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $pic = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $name = null;

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
    protected ?string $deliveryTime = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $rating = 0;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $description = null;

    /**
     * @MongoDB\Field(name="categories", type="raw")
     */
    private $categories;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected bool $isDeployed;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $city = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $postalCode = null;

    public function __construct()
    {
        $this->rating = rand(1, 5);
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
     * @return ?string
     */
    public function getPic(): ?string
    {
        return $this->pic;
    }

    /**
     * @param ?string $pic
     */
    public function setPic(?string $pic): void
    {
        $this->pic = $pic;
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
        if ($this->getItems()) {
            foreach ($this->getItems() as $item) {
                $toArrayItems[] = $item->toArray();
            }
        }


        $toArrayCategories = [];

        if ($this->getCategories()) {
            foreach ($this->getCategories() as $key => $category) {
                $toArrayCategories[] = $key;
            }
        }


        return [
            'name' => $this->getName(),
            'pic' => $this->getPic(),
            'id' => $this->getId(),
            'deliveryPrice' => $this->getDeliveryPrice(),
            'deliveryTime' => $this->getDeliveryTime(),
            'address' => $this->getAddress(),
            'rating' => $this->getRating(),
            'description' => $this->getDescription(),
            'items' => $toArrayItems,
            'categories' => $toArrayCategories,
            'city' => $this->getCity(),
            'postalCode' => $this->getPostalCode(),
            'owner' => $this->getOwner()
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
     * @return ?string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param ?string $address
     */
    public function setAddress(?string $address): void
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
     * @return ?string
     */
    public function getDeliveryTime(): ?string
    {
        return $this->deliveryTime;
    }

    /**
     * @param ?string $deliveryTime
     */
    public function setDeliveryTime(?string $deliveryTime): void
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
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param ?string $description
     */
    public function setDescription(?string $description): void
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

    /**
     * @return ArrayCollection
     */
    public function getMenus(): ArrayCollection
    {
        return $this->menus;
    }

    /**
     * @param ArrayCollection $menus
     */
    public function setMenus(ArrayCollection $menus): void
    {
        $this->menus = $menus;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }


    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }
}