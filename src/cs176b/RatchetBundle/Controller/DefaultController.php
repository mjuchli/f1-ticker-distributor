<?php

namespace cs176b\RatchetBundle\Controller;

use cs176b\RatchetBundle\Form\Type\ChatType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use cs176b\RatchetBundle\Chat\RatchetChat as Chat;
use \ZMQContext;
use \ZMQ;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="pit")
     * @Template()
     */
    public function pitAction(Request $request)
    {
        return array();
    }

}
