<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class ZodiacSpinner extends Spinner
{
    protected const ERASING_SHIFT = 2;
    protected const INTERVAL = 0.25;
    protected const SYMBOLS = SpinnerSymbols::ZODIAC;
    protected const
        STYLES =
        [
            StylesInterface::COLOR256_SPINNER_STYLES => SpinnerStyles::DISABLED,
            StylesInterface::COLOR_SPINNER_STYLES => SpinnerStyles::DISABLED,
            StylesInterface::COLOR_MESSAGE_STYLES => SpinnerStyles::C_DARK,
            StylesInterface::COLOR_PERCENT_STYLES => SpinnerStyles::C_DARK,
        ];
}