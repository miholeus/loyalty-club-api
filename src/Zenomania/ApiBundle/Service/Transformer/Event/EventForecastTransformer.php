<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 25.10.2017
 * Time: 12:09
 */

namespace Zenomania\ApiBundle\Service\Transformer\Event;


use Zenomania\ApiBundle\Service\Transformer\TransformerAbstract;
use Zenomania\CoreBundle\Entity\EventForecast;
use Zenomania\CoreBundle\Service\Utils\HostBasedUrl;

class EventForecastTransformer extends TransformerAbstract
{
    /**
     * @var HostBasedUrl
     */
    private $url;

    public function __construct(HostBasedUrl $url)
    {
        $this->url = $url;
    }

    public function transform(EventForecast $forecast)
    {
        return [
            'id' => $forecast->getId(),
            'date' => $forecast->getCreatedOn()->getTimestamp(),
            'score' => [
                'home' => $forecast->getScoreHome(),
                'guest' => $forecast->getScoreGuest()
            ],
            'roundScore' => $this->getRoundScore($forecast->getScoreInRounds())
        ];
    }

    /**
     * Преобразует строку с данными о результате партий в массив
     *
     * @param string $str
     * @return array
     */
    private function getRoundScore(string $str)
    {
        $rounds = explode(';', $str);
        $i = 1;
        $roundScore = [];
        foreach ($rounds as $round) {
            $score = explode(':', $round);
            $roundScore[] = [
                'round' => $i,
                'home' => (int) $score[0],
                'guest' => (int) $score[1]
            ];
            $i++;
        }

        return $roundScore;
    }
}