<?php


namespace App\Message\Query;


class SearchQuery
{
    private string $term;

    /**
     * SearchQuery constructor.
     * @param string $term
     */
    public function __construct(string $term)
    {
        $this->term = $term;
    }

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }
}