<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Pretty;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;

abstract class AbstractSpinner implements SpinnerInterface
{
    protected const ERASING_SHIFT = 1;
    protected const INTERVAL = 0.1;

    /** @var string */
    protected $messageStr;
    /** @var string */
    protected $percentStr = '';
    /** @var string */
    protected $moveBackSequenceStr;
    /** @var string */
    protected $paddingStr;
    /** @var string */
    protected $eraseBySpacesStr;
    /** @var Styling */
    protected $styled;

    public function __construct(
        ?string $message = null,
        ?string $prefix = null,
        ?string $suffix = null,
        ?string $paddingStr = null
    ) {
        $this->paddingStr = $paddingStr ?? SpinnerInterface::PADDING_EMPTY;
        $this->messageStr = $this->refineMessage($message, $prefix, $suffix);
        $this->setFields();
        $this->styled = new Styling($this->getSymbols(), $this->getStyles());
    }

    /**
     * @param null|string $message
     * @param null|string $prefix
     * @param null|string $suffix
     * @return string
     */
    protected function refineMessage(?string $message, ?string $prefix, ?string $suffix): string
    {
        $message = ucfirst($message ?? SpinnerInterface::DEFAULT_MESSAGE);
        $prefix = empty($message) ? '' : $prefix ?? SpinnerInterface::DEFAULT_PREFIX;
        $suffix = $suffix ?? (empty($message) ? '' : SpinnerInterface::DEFAULT_SUFFIX);
        return $prefix . $message . $suffix;
    }

    protected function setFields(): void
    {
        $strLen =
            strlen($this->message()) + strlen($this->percent()) + strlen($this->paddingStr) + static::ERASING_SHIFT;
        $this->moveBackSequenceStr = ConsoleColor::ESC_CHAR . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(' ', $strLen);
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->messageStr;
    }

    /**
     * @return string
     */
    protected function percent(): string
    {
        return $this->percentStr;
    }

    /**
     * @return array
     */
    abstract protected function getSymbols(): array;

    public function interval(): float
    {
        return static::INTERVAL;
    }

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => [
                '203',
                '209',
                '215',
                '221',
                '227',
                '191',
                '155',
                '119',
                '83',
                '84',
                '85',
                '86',
                '87',
                '81',
                '75',
                '69',
                '63',
                '99',
                '135',
                '171',
                '207',
                '206',
                '205',
                '204',
            ],
            Styling::COLOR_SPINNER_STYLES => ['96'],
        ];
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->paddingStr = $inline ? SpinnerInterface::PADDING_SPACE_SYMBOL : SpinnerInterface::PADDING_EMPTY;
        $this->setFields();
        return $this;
    }

    /** {@inheritDoc} */
    public function begin(): string
    {
        return $this->spin();
    }

    /** {@inheritDoc} */
    public function spin(?float $percent = null): string
    {
        if (null !== $percent) {
            $this->updatePercent($percent);
        }
        return
            $this->paddingStr .
            $this->styled->spinner() .
            $this->styled->message(
                $this->message()
            ) .
            $this->styled->percent(
                $this->percent()
            ) .
            $this->moveBackSequenceStr;
    }

    /**
     * @param float $percent
     */
    protected function updatePercent(float $percent): void
    {
        if (0 === (int)($percent * 1000) % 10) {
            $this->percentStr = Pretty::percent($percent, 0, ' ');
            $this->setFields();
        }
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        return $this->erase();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        return $this->eraseBySpacesStr . $this->moveBackSequenceStr;
    }
}
