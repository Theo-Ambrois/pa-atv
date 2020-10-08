<?php

use Pa\Core\Command\Receiver;
use Pa\Core\Command\Invoker;
use Pa\Core\ConstantLoader;

include 'autoloader.php';

new ConstantLoader();

$firstArg = array_shift($argv);

if('console' !== $firstArg)
{
    $out = fopen('php://output', 'w'); //output handler
	fputs($out, "Not a command.\n"); //writing output operation
	fclose($out); //closing handler
}

$commandArg = array_shift($argv);

$commandName = "Pa\Commands\\".$commandArg."Command";

$receiver = new Receiver();
$invoker = new Invoker();
$command = new $commandName($receiver);
$command->setArgs($argv);
$invoker->setCommand($command);

$invoker->run();