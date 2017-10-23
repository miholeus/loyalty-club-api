<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 13.10.17
 * Time: 16:05
 */

namespace Zenomania\CoreBundle\Form\Model;


class PostVkontakte
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $video;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var integer
     */
    private $status;
}