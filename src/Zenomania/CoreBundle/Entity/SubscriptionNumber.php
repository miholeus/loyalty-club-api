<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.08.2017
 * Time: 15:13
 */

namespace Zenomania\CoreBundle\Entity;


class SubscriptionNumber
{

    /** @var string */
    private $cardcode;

    /** @var string */
    private $sector;

    /** @var string */
    private $row;

    /** @var string */
    private $seat;

    /**
     * @param array $data
     * @return SubscriptionNumber
     */
    public static function fromArray(array $data): SubscriptionNumber
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->{"set".ucfirst($key)}($value);
        }
        return $self;
    }

    /**
     * @return string
     */
    public function getCardcode(): string
    {
        return $this->cardcode;
    }

    /**
     * @param string $cardcode
     */
    public function setCardcode(string $cardcode)
    {
        $this->cardcode = $cardcode;
    }

    /**
     * @return string
     */
    public function getSector(): string
    {
        return $this->sector;
    }

    /**
     * @param string $sector
     */
    public function setSector(string $sector)
    {
        $this->sector = $sector;
    }

    /**
     * @return string
     */
    public function getRow(): string
    {
        return $this->row;
    }

    /**
     * @param string $row
     */
    public function setRow(string $row)
    {
        $this->row = $row;
    }

    /**
     * @return string
     */
    public function getSeat(): string
    {
        return $this->seat;
    }

    /**
     * @param string $seat
     */
    public function setSeat(string $seat)
    {
        $this->seat = $seat;
    }
}