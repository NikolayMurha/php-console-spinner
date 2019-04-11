<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class ExtendedSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = ['1', '2', '3', '4',];
    protected const
        STYLES =
        [
            StylesInterface::COLOR256_SPINNER_STYLES => null,
            StylesInterface::COLOR_SPINNER_STYLES => [1, 2, 3, 4],
        ];
}