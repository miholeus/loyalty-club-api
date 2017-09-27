<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 27.09.17
 * Time: 18:05
 */

namespace Zenomania\ApiBundle\Service;

use Zenomania\CoreBundle\Repository\BadgeRepository;
use Zenomania\CoreBundle\Entity\Badge as BadgeEntity;

class Badge
{
    /**
     * @var BadgeRepository
     */
    private $badgeRepository;

    public function __construct(BadgeRepository $badgeRepository)
    {
        $this->badgeRepository = $badgeRepository;
    }

    public function save(BadgeEntity $data)
    {
        return $this->getBadgeRepository()->save($data);
    }

    /**
     * @return BadgeRepository
     */
    public function getBadgeRepository(): BadgeRepository
    {
        return $this->badgeRepository;
    }

}