<?php

namespace App\Actions;

trait Executable
{
    /**
     * Run the action.
     *
     * @param  mixed ...$arguments
     * @return mixed
     */
    public static function execute(...$arguments)
    {
        return (new static(...$arguments))->run();
    }
}
