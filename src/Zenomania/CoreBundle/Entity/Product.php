<?php

namespace Zenomania\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zenomania\CoreBundle\Service\Upload\IdentifiableInterface;

/**
 * Product
 */
class Product implements IdentifiableInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $photo;

    /**
     * @var string
     */
    private $price;

    /**
     * @var int
     */
    private $quantity = 0;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var bool
     */
    private $published = true;

    /**
     * @var \Zenomania\CoreBundle\Entity\ProductCategory
     */
    private $categoryId;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Product
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo.
     *
     * @param string|null $photo
     *
     * @return Product
     */
    public function setPhoto($photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return Product
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set published.
     *
     * @param bool $published
     *
     * @return Product
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set categoryId.
     *
     * @param \Zenomania\CoreBundle\Entity\ProductCategory $categoryId
     *
     * @return Product
     */
    public function setCategoryId(\Zenomania\CoreBundle\Entity\ProductCategory $categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId.
     *
     * @return \Zenomania\CoreBundle\Entity\ProductCategory
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @ORM\PreFlush
     */
    public function validatePublished()
    {
        if($this->getQuantity() == 0){
            $this->setPublished(false);
        }
    }
}
