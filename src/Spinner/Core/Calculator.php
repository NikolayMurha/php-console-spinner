<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class Calculator
{
    public static function computeErasingLength(array $strings): int
    {
        if (empty($strings)) {
            return 0;
        }
        $lengths = [];
        foreach ($strings as $string) {
            $lengths[] = self::erasingLen($string);
        }
        if (1 !== count(array_unique($lengths))) {
            throw new \InvalidArgumentException('Strings have different erasing lengths');
        }
        return $lengths[0];
    }


    /**
     * @param null|string $in
     * @return int
     */
    protected static function erasingLen(?string $in): int
    {
        if (null === $in || Defaults::EMPTY_STRING === $in) {
            return 0;
        }
        $in = Strip::escCodes($in);
        $mbSymbolLen = mb_strlen($in);
        $oneCharLen = strlen($in) / $mbSymbolLen;
        if (4 === $oneCharLen) {
            return 2 * $mbSymbolLen;
        }
        return 1 * $mbSymbolLen;
    }
}
