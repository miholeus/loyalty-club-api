<?php
/**
 * @package    Zenomania\CoreBundle\Document
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */


namespace Zenomania\CoreBundle\Document;


class ProviderSubscription
{
    const STATUS_NEW = 'new';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';

    /**
     * @var \MongoId $id
     */
    protected $id;

    /**
     * @var string $cardcode
     */
    protected $cardcode;

    /**
     * @var int $event_id
     */
    protected $event_id;

    /**
     * @var int $sub_id
     */
    protected $sub_id;

    /**
     * @var date $dt_enter
     */
    protected $dt_enter;

    /**
     * @var float $price
     */
    protected $price;

    /**
     * @var string $row
     */
    protected $row;

    /**
     * @var string $seat
     */
    protected $seat;

    /**
     * @var string $sector
     */
    protected $sector;
    /**
     * @var string
     */
    protected $number;
    /**
     * @var string
     */
    protected $serial;
    /**
     * @var int
     */
    protected $season_id;

    /**
     * @var \DateTime $created_on
     */
    protected $created_on;

    /**
     * @var \DateTime $updated_on
     */
    protected $updated_on;

    /**
     * @var string $status
     */
    protected $status;

    public function __construct()
    {
        $this->created_on = new \DateTime();
        $this->updated_on = new \DateTime();
        $this->status = self::STATUS_NEW;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sub_id' => $this->sub_id,
            'cardcode' => $this->cardcode,
            'dt_enter' => $this->dt_enter,
            'season_id' => $this->season_id,
            'number' => $this->number,
            'serial' => $this->serial,
            'price' => $this->price,
            'row' => $this->row,
            'seat' => $this->seat,
            'sector' => $this->sector
        ];
    }

    public static function fromArray(array $data): ProviderSubscription
    {
        $self = new self();
        $self->sub_id = $data['id'];
        $self->cardcode = $data['cardcode'];
        $self->dt_enter = $data['dt_enter'];
        $self->number = $data['number'];
        $self->serial = $data['serial'];
        $self->price = $data['price'];
        $self->row = $data['row'];
        $self->seat = $data['seat'];
        $self->sector = $data['sector'];

        return $self;
    }
    /**
     * Get id
     *
     * @return \MongoId $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardcode
     *
     * @param string $cardcode
     * @return $this
     */
    public function setCardcode($cardcode)
    {
        $this->cardcode = $cardcode;
        return $this;
    }

    /**
     * Get cardcode
     *
     * @return string $cardcode
     */
    public function getCardcode()
    {
        return $this->cardcode;
    }

    /**
     * Set eventId
     *
     * @param int $eventId
     * @return $this
     */
    public function setEventId($eventId)
    {
        $this->event_id = $eventId;
        return $this;
    }

    /**
     * Get eventId
     *
     * @return int $eventId
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Set subId
     *
     * @param int $subId
     * @return $this
     */
    public function setSubId($subId)
    {
        $this->sub_id = $subId;
        return $this;
    }

    /**
     * Get subId
     *
     * @return int $subId
     */
    public function getSubId()
    {
        return $this->sub_id;
    }

    /**
     * Set dtEnter
     *
     * @param date $dtEnter
     * @return $this
     */
    public function setDtEnter($dtEnter)
    {
        $this->dt_enter = $dtEnter;
        return $this;
    }

    /**
     * Get dtEnter
     *
     * @return date $dtEnter
     */
    public function getDtEnter()
    {
        return $this->dt_enter;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set row
     *
     * @param string $row
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;
        return $this;
    }

    /**
     * Get row
     *
     * @return string $row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Set seat
     *
     * @param string $seat
     * @return $this
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;
        return $this;
    }

    /**
     * Get seat
     *
     * @return string $seat
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Set sector
     *
     * @param string $sector
     * @return $this
     */
    public function setSector($sector)
    {
        $this->sector = $sector;
        return $this;
    }

    /**
     * Get sector
     *
     * @return string $sector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return $this
     */
    public function setCreatedOn($createdOn)
    {
        $this->created_on = $createdOn;
        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime $createdOn
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     * @return $this
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updated_on = $updatedOn;
        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updated_on;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return $this
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
        return $this;
    }

    /**
     * Get serial
     *
     * @return string $serial
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set seasonId
     *
     * @param int $seasonId
     * @return $this
     */
    public function setSeasonId($seasonId)
    {
        $this->season_id = $seasonId;
        return $this;
    }

    /**
     * Get seasonId
     *
     * @return int $seasonId
     */
    public function getSeasonId()
    {
        return $this->season_id;
    }
}
