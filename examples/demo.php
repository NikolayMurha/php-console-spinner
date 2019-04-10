<?php

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

const ITER = 30;
const MESSAGE = 'Processing';

$theme = new Themes();
echo Cursor::hide();
//echo $theme->comment('Spinners samples(with message"' . MESSAGE . '"):') . PHP_EOL;
showSpinners(
    [
        new CircleSpinner(MESSAGE),
        new ClockSpinner(MESSAGE),
        new MoonSpinner(MESSAGE),
        new SimpleSpinner(MESSAGE),
        new SnakeSpinner(MESSAGE),
    ]
);
//echo $theme->comment('Spinners samples(without message):') . PHP_EOL;
showSpinners(
    [
        new CircleSpinner(),
        new ClockSpinner(),
        new MoonSpinner(),
        new SimpleSpinner(),
        new SnakeSpinner(),
    ]
);

showSpinners(
    [
        new CircleSpinner(),
        new ClockSpinner(),
        new MoonSpinner(),
        new SimpleSpinner(),
        new SnakeSpinner(),
    ],
    true
);
echo Cursor::show();

// ************************ Functions ************************

/**
 * @param array $spinners
 * @param bool $withPercent
 */
function showSpinners(array $spinners, bool $withPercent = false): void
{
    /** @var AbstractSpinner $s */
    foreach ($spinners as $s) {
        $microseconds = $s->interval() * 1000000;
        echo PHP_EOL;
        echo Cursor::up();
        echo $s->begin(); // Optional
        for ($i = 1; $i <= ITER; $i++) {
            echo $s->spin($withPercent ? $i / ITER : null);
            usleep($microseconds);
        }
        // Note: we're not erasing spinner here
        // if you want to uncomment next line
        //echo $s->end();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}
