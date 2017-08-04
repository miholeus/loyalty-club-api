<?php
/**
 * @package    Zenomania\CoreBundle\Form\Model
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Form\Model;

class BaseModel
{
    public function __construct(array $data = array())
    {
        if (!empty($data)) {
            $this->setFromArray($data);
        }
    }

    /**
     * Set data from array
     *
     * @param array $data
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{"set" . ucfirst($key)}($value);
        }
    }
}