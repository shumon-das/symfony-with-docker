<?php

namespace App\Controller;

use App\Message\QueueMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class QueueController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("queuetest", name="queuetest")
     */
    public function SendToQueue()
    {
        $data = ['a' => 'hello', 'b'=>'World', 'c' => 'swdmp'];
        if($this->messageBus->dispatch(new QueueMessage($data))) {
            return new Response("Data go to beanstalkd queue");
        }

    }
}