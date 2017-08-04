<?php

namespace Zenomania\CoreBundle\Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Class MatchFunction
 * @package Doctrine\ORM\Query\AST\Functions
 */
class MatchFunction extends FunctionNode
{
    public $columns = [];

    public $needle;

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $criteria = [];
        $combinedColumns = $this->combineColumns($sqlWalker);
        $words = $this->getWords($this->needle->value);

        foreach($words as $word){
            $pattern = "%{$word}%";
            $criteria[] = sprintf("%s ILIKE %s", $combinedColumns, $sqlWalker->walkStringPrimary($pattern));
        }
        return '('.implode(' AND ', $criteria).')';
    }

    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        do {
            $this->columns[] = $parser->StateFieldPathExpression();
            $parser->match(Lexer::T_COMMA);
        }
        while ($parser->getLexer()->isNextToken(Lexer::T_IDENTIFIER));
        $this->needle = $parser->InParameter();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return string
     */
    protected function combineColumns(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $dispatchedColumns = array_map(function($column) use ($sqlWalker){
            return sprintf("COALESCE(%s, '')", $column->dispatch($sqlWalker));
        }, $this->columns);

        return implode(' || ', $dispatchedColumns);
    }

    /**
     * @param $text
     * @return array
     */
    protected function getWords($text)
    {
        return preg_split('#\s+#', $text);
    }
}
