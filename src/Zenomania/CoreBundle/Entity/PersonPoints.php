<?php

namespace Zenomania\CoreBundle\Entity;

/**
 * PersonPoints
 */
class PersonPoints
{
    const TYPE_TICKET_REGISTER = 'ticket_register';
    const TYPE_SUBSCRIPTION_REGISTER = 'sub_register';
    const TYPE_SUBSCRIPTION_ATTENDANCE = 'sub_attendance';
    const TYPE_INVITE = 'reference';
    const TYPE_LINKED_VK = 'vk_linked';
    const TYPE_PURCHASE = 'purchase';
    const TYPE_FORECAST_WINNER = 'forecast_winner';
    const TYPE_REPOST = 'repost';
    const TYPE_PROMO_COUPON = 'promo_coupon';
    const TYPE_FORECAST_WINNER_MATCH_RESULT = 'forecast_winner_match_result';
    const TYPE_FORECAST_WINNER_MATCH_ROUNDS = 'forecast_winner_match_rounds';
    const TYPE_FORECAST_WINNER_MATCH_ROUND_SCORE = 'forecast_winner_match_round_score';
    const TYPE_FORECAST_WINNER_ONE_PLAYER = 'forecast_winner_one_player';
    const TYPE_FORECAST_WINNER_MVP = 'forecast_winner_mvp';
    const TYPE_CANCELLED_ORDER = 'cancelled_order';
    const TYPE_CREATE_ORDER = 'create_order';
    const TYPE_CREATE_ORDER_ON_INTERNET_SHOP = 'create_order_on_internet_shop';

    const OPERATION_TYPE_DEBIT = 'debit';
    const OPERATION_TYPE_CREDIT = 'credit';
    const OPERATION_TYPE_RETURN = 'return';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $points = '0';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $state = 'none';

    /**
     * @var \DateTime
     */
    private $dt;

    /**
     * @var \Zenomania\CoreBundle\Entity\Season
     */
    private $season;

    /**
     * @var \Zenomania\CoreBundle\Entity\Person
     */
    private $person;

    /**
     * @var \Zenomania\CoreBundle\Entity\User
     */
    private $user;

    /**
     * @param array $data
     * @return PersonPoints
     */
    public static function fromArray(array $data): PersonPoints
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $items = explode('_', $key);
            $key = '';
            foreach ($items as $item){
                $key.= ucfirst($item);
            }
            $self->{"set" . $key}($value);
        }
        return $self;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return PersonPoints
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return PersonPoints
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return PersonPoints
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set dt
     *
     * @param \DateTime $dt
     *
     * @return PersonPoints
     */
    public function setDt($dt)
    {
        $this->dt = $dt;

        return $this;
    }

    /**
     * Get dt
     *
     * @return \DateTime
     */
    public function getDt()
    {
        return $this->dt;
    }

    /**
     * Set season
     *
     * @param \Zenomania\CoreBundle\Entity\Season $season
     *
     * @return PersonPoints
     */
    public function setSeason(\Zenomania\CoreBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \Zenomania\CoreBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set person
     *
     * @param \Zenomania\CoreBundle\Entity\Person $person
     *
     * @return PersonPoints
     */
    public function setPerson(\Zenomania\CoreBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Zenomania\CoreBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set user
     *
     * @param \Zenomania\CoreBundle\Entity\User $user
     *
     * @return PersonPoints
     */
    public function setUser(\Zenomania\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Zenomania\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var string
     */
    private $operation_type;


    /**
     * Set operationType.
     *
     * @param string $operationType
     *
     * @return PersonPoints
     */
    public function setOperationType($operationType)
    {
        $this->operation_type = $operationType;

        return $this;
    }

    /**
     * Get operationType.
     *
     * @return string
     */
    public function getOperationType()
    {
        return $this->operation_type;
    }
}
