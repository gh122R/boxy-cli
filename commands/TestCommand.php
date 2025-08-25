<?php

namespace Command;

use League\CLImate\CLImate;

class TestCommand
{
    public function test(...$args)
    {
        $climate = new Climate();

        $climate->info('Hay! This is a test command epta');

        foreach ($args as $arg) {
            $climate->info("Argument: " . $arg);
        }
    }
}