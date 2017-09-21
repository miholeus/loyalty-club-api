<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.08.2017
 * Time: 15:13
 */

namespace Zenomania\CoreBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SubscriptionNumber
{
    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $cardcode;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $sector;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $row;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $seat;

    /**
     * @return string
     */
    public function getCardcode()
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
    public function getSector()
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
    public function getRow()
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
    public function getSeat()
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