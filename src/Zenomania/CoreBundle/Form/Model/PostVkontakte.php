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

    public function __construct(\stdClass $post)
    {
        $this->setText($post->text);
        $this->setId($post->id);
        $this->setDate($this->parseDate($post->date));
        $this->setTags($this->parseTags($post));
        $this->setPhoto($this->parsePhoto($post));
        $this->setVideo($this->parseVideo($post));
    }


    /**
     * @param $text
     * @return null|integer
     */
    private function parsePoints($text)
    {
        preg_match('/#\d+ZEN/', $text, $pointsTag);
        if ($pointsTag) {
            $pointsTag = array_shift($pointsTag);
            preg_match('/\d/', $pointsTag, $points);
            return array_shift($points);
        }

        return null;
    }

    /**
     * @param object $post
     * @return array
     */
    private function parseTags($post)
    {
        preg_match_all('/#[^\s]+/', $post->text, $matches);

        return array_shift($matches);
    }

    /**
     * @param object $post
     * @return null|string
     */
    private function parsePhoto($post)
    {
        if (!empty($post->attachments)  && is_array($post->attachments)) {
            $attachments = current($post->attachments);
            switch ($attachments->type) {
                case 'photo':
                    $photos = $attachments->photo;
                    break;
                case 'album':
                    $photos = $attachments->album->thumb;
                    break;
                default:
                    return null;
            }

            $sizes = [807, 604, 130, 75];

            foreach ($sizes as $size) {
                $size = 'photo_' . $size;
                if (!empty($photos->$size)) {
                    return $photos->$size;
                }
            }
        }
        return null;
    }

    /**
     * @param object $post
     * @return null|string
     */
    private function parseVideo($post)
    {
        if (!empty($post->attachments) && is_array($post->attachments)) {
            $attachments = current($post->attachments);
            if(!empty($attachments->video))
            {
                return 'https://vk.com/video' . $attachments->video->owner_id . '_' . $attachments->video->id;
            }
        }
        return null;
    }

    private function parseDate(int $dt){
        $date = new \DateTime();
        return $date->setTimestamp($dt);
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}