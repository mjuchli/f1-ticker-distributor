<?php
/*
 * This file is part of the [name] package.
 *
 * (c) Marc Juchli <mail@marcjuch.li>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use \ZMQ;
use \ZMQContext;

require dirname(__DIR__) . '/vendor/autoload.php';

$context = new ZMQContext();

// Haskell Parsing Queue
$subscriber = new ZMQSocket($context, ZMQ::SOCKET_SUB);
$subscriber->connect("tcp://localhost:5556");
$subscriber->setSockOpt(ZMQ::SOCKOPT_SUBSCRIBE, "");

// Pusher Queue (Push Server)
$socket = $context->getSocket(ZMQ::SOCKET_PUSH, "my pusher");
$socket->connect("tcp://localhost:5555");


$parser = new \cs176b\RatchetBundle\Parser\Parser();

while (true) {
    $input_lines = $subscriber->recv();
    $arr = array();
    $returnValue = $parser->parseStream($input_lines);

    if($parser->hasNew()){
        foreach($parser->getNewElements() as $element){
            $socket->send(json_encode($element));
        }
    }
}
