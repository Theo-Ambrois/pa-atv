<?php
namespace PA\Core\Command;

class Receiver
{
    private $enableDate = false;

    /**
     * @var string[]
     */
    private $output = [];

    public function printOutPut(): void
    {
        $out = fopen('php://output', 'w'); //output handler
        fputs($out, $this->getOutput()); //writing output operation
        fclose($out); //closing handler
    }
}