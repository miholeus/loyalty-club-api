<?php
/**
 * @package    Zenomania\CoreBundle\Document
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Document;

class ProviderTicket
{
    const STATUS_NEW = 'new';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';
    /**
     * @var \MongoId $id
     */
    protected $id;

    /**
     * @var string $barcode
     */
    protected $barcode;

    /**
     * @var array $client
     */
    protected $client;

    /**
     * @var int $event_id
     */
    protected $event_id;

    /**
     * @var int $ticket_id
     */
    protected $ticket_id;
    /**
     * @var \DateTime $date
     */
    protected $date;

    /**
     * @var array $discount
     */
    protected $discount;

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
            'ticket_id' => $this->ticket_id,
            'barcode' => $this->barcode,
            'date' => $this->date,
            'client' => $this->client,
            'price' => $this->price,
            'row' => $this->row,
            'seat' => $this->seat,
            'sector' => $this->sector
        ];
    }

    public static function fromArray(array $data): ProviderTicket
    {
        $self = new self();
        $self->ticket_id = $data['id'];
        $self->barcode = $data['barcode'];
        $self->client = $data['client'];
        $self->date = $data['date'];
        $self->discount = !empty($data['discount']['value']) ? $data['discount'] : null;
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
     * Set barcode
     *
     * @param string $barcode
     * @return $this
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * Get barcode
     *
     * @return string $barcode
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set client
     *
     * @param array $client
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get client
     *
     * @return array $client
     */
    public function getClient()
    {
        return $this->client;
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
     * Set date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set discount
     *
     * @param raw $discount
     * @return $this
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * Get discount
     *
     * @return array $discount
     */
    public function getDiscount()
    {
        return $this->discount;
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
     * Set ticketId
     *
     * @param int $ticketId
     * @return $this
     */
    public function setTicketId($ticketId)
    {
        $this->ticket_id = $ticketId;
        return $this;
    }

    /**
     * Get ticketId
     *
     * @return int $ticketId
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }
}
