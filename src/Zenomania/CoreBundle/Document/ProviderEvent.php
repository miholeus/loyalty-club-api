<?php
/**
 * @package    Zenomania\CoreBundle\Document
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Document;

class ProviderEvent
{
    const STATUS_NEW = 'new';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';
    /**
     * @var \MongoId $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var array $club_owner
     */
    protected $club_owner;

    /**
     * @var \DateTime $date
     */
    protected $date_start;

    /**
     * @var \DateTime $date_end
     */
    protected $date_end;

    /**
     * @var \DateTime $created_on
     */
    protected $created_on;

    /**
     * @var \DateTime $updated_on
     */
    protected $updated_on;

    /**
     * @var int $status
     */
    protected $status;
    /**
     * @var int
     */
    protected $event_id;

    public function __construct()
    {
        $this->created_on = new \DateTime();
        $this->updated_on = new \DateTime();
    }

    public static function fromArray(array $data): ProviderEvent
    {
        $self = new self();
        $self->event_id = $data['id'];
        $self->club_owner = $data['club_owner'];
        $self->date_start = $data['date_start'];
        $self->date_end = $data['date_end'];
        $self->name = $data['title'];

        return $self;
    }
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set clubOwner
     *
     * @param array $clubOwner
     * @return $this
     */
    public function setClubOwner($clubOwner)
    {
        $this->club_owner = $clubOwner;
        return $this;
    }

    /**
     * Get clubOwner
     *
     * @return array $clubOwner
     */
    public function getClubOwner()
    {
        return $this->club_owner;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setDateStart($date)
    {
        $this->date_start = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date_start;
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
     * @param int $status
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
     * @return int $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime $dateStart
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return $this
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;
        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime $dateEnd
     */
    public function getDateEnd()
    {
        return $this->date_end;
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
}
