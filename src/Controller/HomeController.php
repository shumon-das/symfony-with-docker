<?php


namespace App\Controller;

use Pheanstalk\Pheanstalk;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends  AbstractController
{

    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function Hello()
    {
//        return new Response("Hello World!");
        return $this->render('welcome.html.twig');
    }

    /**
     * @Route("queuetest", name="queuetest")
     */
    public function TestPheanstalk(): Response
    {
        $pheanstalk = Pheanstalk::create('beanstalkd');

        $data = [
            'name' => 'mono',
            'designation' => 'fulstack web developer',
            'company' => 'abc private LTD'
        ];

        // Queue a Job
        $pheanstalk
            ->useTube('testtube')
            ->put(
                json_encode([
                            'headers'=>['type'=>'mail'],
                            'body' => serialize(['data'=>$data])
                            ],JSON_PRETTY_PRINT),  // encode data in payload
                Pheanstalk::DEFAULT_PRIORITY,     // default priority
                30, // delay by 30s
                60  // beanstalk will retry job after 60s
            );
        return new Response('tested');
    }

        // return $this->render('$0.html.twig', []);
}