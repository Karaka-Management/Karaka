<?php

namespace tests;

use PHPUnit\Runner\AfterTestHook;

class SlowTestsAlert implements AfterTestHook
{
    protected const MAX_SECONDS_ALLOWED = 60;

    public function executeAfterTest(string $test, float $time): void
    {
        if ($time > self::MAX_SECONDS_ALLOWED) {
            fwrite(STDERR, sprintf("\nThe %s test took %s seconds!\n", $test, $time));
        }
    }
}
