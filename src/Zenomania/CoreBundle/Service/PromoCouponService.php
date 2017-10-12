<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.09.2017
 * Time: 11:00
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Zenomania\CoreBundle\Entity\PromoCoupon;
use Zenomania\CoreBundle\Entity\PromoCouponAction;
use Zenomania\CoreBundle\Event\NotificationInterface;
use Zenomania\CoreBundle\Form\Model\FileUpload;

class PromoCouponService extends UserAwareService
{
    /** @var \Zenomania\CoreBundle\Repository\PromoCouponRepository */
    private $promoCouponRepository;

    /** @var \Zenomania\CoreBundle\Repository\PromoCouponActionRepository */
    private $promoCouponActionRepository;

    /**
     * PromoCouponService constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     * @param NotificationInterface $notificationManager
     */
    public function __construct(EntityManager $em, TokenStorage $tokenStorage, NotificationInterface $notificationManager)
    {
        parent::__construct($em, $tokenStorage, $notificationManager);

        $this->promoCouponRepository = $em->getRepository('ZenomaniaCoreBundle:PromoCoupon');
        $this->promoCouponActionRepository = $em->getRepository('ZenomaniaCoreBundle:PromoCouponAction');
    }

    /**
     * Tries to find promo coupon action
     * Adds new if it was not found
     *
     * @param array $row
     * @return null|object|PromoCouponAction
     */
    protected function getPromoCouponAction(array $row)
    {
        $repository = $this->getPromoCouponActionRepository();

        $couponAction = $repository->findOneBy(['name' => $row[FileUpload::FIELD_ACTION]]);

        // Если такой акции нет, то создаём её
        if (empty($couponAction)) {
            $params = [
                'name' => $row[FileUpload::FIELD_ACTION]
            ];

            $couponAction = PromoCouponAction::fromArray($params);
            $repository->save($couponAction);
        }

        return $couponAction;
    }
    /**
     * Загружаем данные в таблицу promo_coupon
     *
     * @param $data
     * @return array
     */
    public function addFromFile(array $data)
    {
        $promoCouponRepository = $this->getPromoCouponRepository();

        // Результирующий массив с итогом загрузки данных
        $result = ['new' => 0, 'duplicate' => 0, 'error' => 0];
        foreach ($data as $row) {

            // Проверяем, что в обрабатываемой строке нужное количество полей
            if (count($row) != 3) {
                $result['error']++;
                continue;
            }

            // Пытаемся найти промо акцию по названию
            $couponAction = $this->getPromoCouponAction($row);

            // Проверяем на наличие записи с таким промо-купоном
            $duplicate = $promoCouponRepository->findCouponByCode($row[FileUpload::FIELD_CODE]);
            if (!empty($duplicate)) {
                $result['duplicate']++;
                continue;
            }

            $params = [
                'action' => $couponAction,
                'code' => $row[FileUpload::FIELD_CODE],
                'points' => $row[FileUpload::FIELD_COUNT_ZEN],
                'activated' => false,
            ];

            // Загружаем промо-купон в базу
            $promoCoupon = PromoCoupon::fromArray($params);
            $promoCoupon->setCreatedBy($this->getUser());
            $promoCouponRepository->save($promoCoupon);
            $result['new']++;
        }

        return $result;
    }

    /**
     * Saves coupon
     *
     * @param PromoCoupon $coupon
     */
    public function save(PromoCoupon $coupon)
    {
        if (null === $coupon->getId()) {
            $coupon->setCreatedBy($this->getUser());
        }
        $this->getPromoCouponRepository()->save($coupon);
    }
    /**
     * @return \Zenomania\CoreBundle\Repository\PromoCouponRepository
     */
    public function getPromoCouponRepository()
    {
        return $this->promoCouponRepository;
    }

    /**
     * @return \Zenomania\CoreBundle\Repository\PromoCouponActionRepository
     */
    public function getPromoCouponActionRepository()
    {
        return $this->promoCouponActionRepository;
    }
}