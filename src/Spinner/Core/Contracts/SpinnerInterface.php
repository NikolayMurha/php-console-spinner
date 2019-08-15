<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

interface SpinnerInterface
{
    /**
     * @param null|float $percent
     * @return string
     */
    public function begin(?float $percent = null): string;

    /**
     * @return string
     */
    public function erase(): string;

    /**
     * @return string
     */
    public function end(): string;

    /**
     * @return null|SpinnerOutputInterface
     */
    public function getOutput(): ?SpinnerOutputInterface;

    /**
     * @return SettingsInterface
     */
    public function getSettings(): SettingsInterface;

    /**
     * @param bool $inline
     * @return SpinnerInterface
     */
    public function inline(bool $inline): SpinnerInterface;

    /**
     * @return float
     */
    public function interval(): float;

    /**
     * @param null|float $percent
     * @param null|string $message
     * @return string
     */
    public function spin(?float $percent = null, ?string $message = null): string;
}
