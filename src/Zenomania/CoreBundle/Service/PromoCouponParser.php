<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\CoreBundle\Service;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PromoCouponParser
{
    /**
     * Gets data from file
     *
     * @param $filePath
     * @return bool|mixed|string
     */
    public function getData($filePath)
    {
        $data = file_get_contents($filePath);

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder(';', '"', '\\', '~')]);
        $data = $serializer->decode($data, 'csv');

        return $data;
    }
}