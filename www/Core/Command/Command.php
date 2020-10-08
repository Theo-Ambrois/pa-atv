<?php
namespace PA\Core\Command;

class Command implements CommandInterface
{
    public function __construct(Receiver $console)
    {
        $this->output = $console;
    }

    public function execute()
    {

    }
}
