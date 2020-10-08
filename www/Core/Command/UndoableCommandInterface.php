<?php
namespace PA\Core\Command;

interface UndoableCommandInterface extends CommandInterface
{
    public function undo();
}
