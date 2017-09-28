<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 28.09.2017
 * Time: 11:00
 */

namespace Zenomania\CoreBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Zenomania\CoreBundle\Entity\PromoCoupon;
use Zenomania\CoreBundle\Entity\PromoCouponAction;
use Zenomania\CoreBundle\Form\Model\FileUpload;

class PromoCouponService
{
    /** @var EntityManager */
    private $em;

    /** @var \Zenomania\CoreBundle\Repository\PromoCouponRepository */
    private $promoCouponRepository;

    /** @var \Zenomania\CoreBundle\Repository\PromoCouponActionRepository */
    private $pcactionRepository;

    /**
     * PromoCouponService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->promoCouponRepository = $em->getRepository('ZenomaniaCoreBundle:PromoCoupon');
        $this->pcactionRepository = $em->getRepository('ZenomaniaCoreBundle:PromoCouponAction');
    }

    /**
     * Загружаем данные в таблицу promo_coupon
     *
     * @param $dataFile
     * @param $user
     * @return array
     */
    public function upload($dataFile, $user)
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder(';', '"', '\\', '~')]);
        $data = $serializer->decode($dataFile, 'csv');

        $promoCouponRepository = $this->getPromoCouponRepository();
        $pcactionRepository = $this->getPcactionRepository();

        // Результирующий массив с итогом загрузки данных
        $result = ['new' => 0, 'duplicate' => 0, 'error' => 0];
        foreach ($data as $row) {

            // Проверяем, что в обрабатываемой строке нужное количество полей
            if (count($row) != 3) {
                $result['error']++;
                continue;
            }

            // Пытаемся найти промо акцию по названию
            $pcaction = $pcactionRepository->findOneBy(['caption' => $row[FileUpload::FIELD_ACTION]]);

            // Если такой акции нет, то создаём её
            if (empty($pcaction)) {
                $params = [
                    'club_owner' => 9,
                    'caption' => $row[FileUpload::FIELD_ACTION]
                ];

                $pcaction = PromoCouponAction::fromArray($params);
                $pcactionRepository->save($pcaction);
            }

            // Проверяем на наличие записи с таким промо-купоном
            $duplicate = $promoCouponRepository->findCouponByCode($row[FileUpload::FIELD_CODE]);
            if (!empty($duplicate)) {
                $result['duplicate']++;
                continue;
            }

            $params = [
                'action' => $pcaction,
                'code' => $row[FileUpload::FIELD_CODE],
                'points' => $row[FileUpload::FIELD_COUNT_ZEN],
                'activated' => false,
            ];

            // Загружаем промо-купон в базу
            $promoCoupon = PromoCoupon::fromArray($params);
            $promoCouponRepository->save($promoCoupon, $user);
            $result['new']++;
        }

        return $result;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
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
    public function getPcactionRepository()
    {
        return $this->pcactionRepository;
    }
}