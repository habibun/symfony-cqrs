<?php

namespace App\Controller;

use App\Message\Command\CreateOrder;
use App\Message\Command\SignUpSms;
use App\Message\Query\SearchQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * DefaultController constructor.
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(): Response
    {
        $search = "laptops";
        $this->messageBus->dispatch(new SearchQuery($search));

        return new Response('Your search results for '.$search);
    }


    /**
     * @Route("/signup-sms", name="signup_sms")
     */
    public function signUpSms(): Response
    {
        $phoneNumber = "000 111 2222";
        $this->messageBus->dispatch(new SignUpSms($phoneNumber));

        return new Response(sprintf('Your phone number %s successfully signed up to sms newsletter!', $phoneNumber));
    }

    /**
     * @Route("/order", name="order")
     */
    public function order(): Response
    {
        $productId = 243;
        $productName = "product name";
        $productAmount = 2;
        //save the order in the database
        $this->messageBus->dispatch(new CreateOrder($productId, $productAmount));

        return new Response('Your successfully ordered your product!:'.$productName);
    }

}
