<?php

namespace Zenomania\CoreBundle\Service\Utils;

class DatabaseHelper
{
    /**
     * @param $qb
     * @param string $matchText
     * @param array $matchFields
     * @return mixed
     */
    public static function matchCriteria($qb, $matchText, $matchFields = [])
    {
        if($qb instanceof \Doctrine\ORM\QueryBuilder){
            $criteria = sprintf("MATCH(%s, '%s') = true", implode(', ', $matchFields), $matchText);
            $qb->andWhere($criteria);
            return;
        }

        $criteria = [];
        $matchText = mb_strtolower($matchText, 'utf8');
        $matchFields = array_map(function($field){
            return sprintf("COALESCE(%s, '')", $field);
        }, $matchFields);

        $combinedFields = implode(' || ', $matchFields);
        $combinedFields = "LOWER({$combinedFields})";
        $words = preg_split('#\s+#', $matchText);

        foreach($words as $key => $word){
            $parameter = ':word'.$key;
                $criteria[] = sprintf("%s ILIKE %s", $combinedFields, $parameter);

            $qb->setParameter($parameter, "%{$word}%");
        }
        $qb->andWhere('('.implode(' AND ', $criteria).')');
    }
}