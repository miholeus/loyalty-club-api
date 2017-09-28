<?php
/**
 * @package    Zenomania\ApiBundle\Request\Filter
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Request\Filter;

use FOS\RestBundle\Normalizer\CamelKeysNormalizer;

abstract class AbstractFilter
{
    const LIMIT_MAX = 200;
    const OFFSET_MAX = 1000000;

    protected $limit;
    protected $offset;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $normalizer = $this->getNormalizer();
            $arr = $normalizer->normalize($data);
            foreach ($arr as $key => $value) {
                if (array_key_exists($key, get_object_vars($this))) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * @return CamelKeysNormalizer
     */
    protected function getNormalizer()
    {
        return new CamelKeysNormalizer();
    }

    /**
     * Возвращает максимальное количество строк в запросе
     *
     * @return int
     */
    public function getLimit()
    {
        if ($this->limit >= self::LIMIT_MAX) {
            return self::LIMIT_MAX;
        }
        return $this->limit;
    }

    /**
     * Возвращает смещение
     *
     * @return int
     */
    public function getOffset()
    {
        if ($this->offset >= self::OFFSET_MAX) {
            return self::OFFSET_MAX;
        }
        return $this->offset;
    }
}
