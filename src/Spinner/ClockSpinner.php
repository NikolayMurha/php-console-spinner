<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class ClockSpinner extends AbstractSpinner
{
    protected const ERASING_SHIFT = 2;

    /**
     * @return Circular
     */
    protected function getSymbols(): Circular
    {
        return new Circular([
            // If you can't see clock symbols doesn't mean they're not there!
            // They ARE!
            '🕐',
            '🕑',
            '🕒',
            '🕓',
            '🕔',
            '🕕',
            '🕖',
            '🕗',
            '🕘',
            '🕙',
            '🕚',
            '🕛',
            // If you can't see clock symbols doesn't mean they're not there!
            // They ARE!
            // '🕜',
            // '🕝',
            // '🕞',
            // '🕟',
            // '🕠',
            // '🕡',
            // '🕢',
            // '🕣',
            // '🕤',
            // '🕥',
            // '🕦',
        ]);
    }

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_STYLES => null,
            Styling::COLOR_STYLES => null,
        ];
    }
}
