<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.11.2017
 * Time: 16:27
 */

namespace Zenomania\CoreBundle\Entity;


use Zenomania\CoreBundle\Service\Upload\IdentifiableInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TicketForZen implements IdentifiableInterface
{
    const TYPE_USED = 'ticket_used';
    const TYPE_NOT_USED = 'ticket_not_used';
    const TYPE_PURCHASED = 'ticket_purchased';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Zenomania\CoreBundle\Entity\Event
     */
    private $event;

    /**
     * @var string
     */
    private $name;

    /**
     * @Assert\File(mimeTypes={ "image/jpg", "image/jpeg", "image/png", "application/pdf" }, groups={"upload"})
     * @Assert\Image(
     *    mimeTypesMessage = "Неверный формат документа",
     *    maxSize = "5M",
     *    maxSizeMessage = "Документ слишком большого размера",
     *    groups={"upload"}
     * )
     * @var string
     */
    private $barcode;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var \Zenomania\CoreBundle\Entity\Order
     */
    private $order;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Zenomania\CoreBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param \Zenomania\CoreBundle\Entity\Event $event
     *
     * @return TicketForZen
     */
    public function setEvent(\Zenomania\CoreBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TicketForZen
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return TicketForZen
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return TicketForZen
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return TicketForZen
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set user.
     *
     * @param \Zenomania\CoreBundle\Entity\User|null $user
     *
     * @return TicketForZen
     */
    public function setUser(\Zenomania\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Zenomania\CoreBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set order.
     *
     * @param \Zenomania\CoreBundle\Entity\Order|null $order
     *
     * @return TicketForZen
     */
    public function setOrder(\Zenomania\CoreBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return \Zenomania\CoreBundle\Entity\Order|null
     */
    public function getOrder()
    {
        return $this->order;
    }
}
