<?php


namespace App\MessageHandler\Command;


use App\Message\Command\CreateOrder;

class CreateOrderHandler
{
    public function __invoke(CreateOrder $createOrder)
    {
        //send an email to the client confirming the order (product name, amount, price, etc.)
        //update warehouse database to keep stock up to date in physical stores
        sleep(4);
    }

}