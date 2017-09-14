<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 18.08.2017
 * Time: 13:06
 */

namespace Zenomania\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Zenomania\CoreBundle\Entity\PersonPoints;
use Zenomania\CoreBundle\Entity\User;
use Zenomania\CoreBundle\Entity\UserReferralCode;

class PersonPointsRepository extends EntityRepository
{
    public function save(PersonPoints $personPoints)
    {
        $this->_em->persist($personPoints);
        $this->_em->flush();
    }

    /**
     * Add points for invitation
     *
     * @param UserReferralCode $referralCode
     * @param User $user
     * @param $points
     */
    public function givePointsForInvite(UserReferralCode $referralCode, User $user, $points)
    {
        $person = $this->_em->getRepository('ZenomaniaCoreBundle:Person')->findPersonByUser($referralCode->getUser());
        $promoAction = $this->_em->getRepository('ZenomaniaCoreBundle:PromoAction')->findCurrentSeason();

        $params = [
            'season' => $promoAction,
            'person' => $person,
            'points' => $points,
            'type' => 'reference',
            'state' => 'none',
            'dt' => new \DateTime()
        ];

        $personPoints = PersonPoints::fromArray($params);

        $this->_em->persist($personPoints);

        $this->_em->getRepository('ZenomaniaCoreBundle:UserReferralCode')->addActivation($referralCode, $user, false);

        $this->_em->flush();
    }
}