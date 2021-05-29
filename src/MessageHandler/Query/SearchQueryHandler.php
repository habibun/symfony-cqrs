<?php


namespace App\MessageHandler\Query;


use App\Message\Query\SearchQuery;
use Symfony\Component\HttpFoundation\Response;

class SearchQueryHandler
{
    public function __invoke(SearchQuery $searchQuery)
    {
        // call database
        sleep(1);

//        return ' result from database';
    }

}