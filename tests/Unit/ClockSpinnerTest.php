<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Tests\Spinner\ExtendAbstractSpinner;
use AlecRabbit\Tests\Spinner\Helper;
use PHPUnit\Framework\TestCase;

/**
 * @group time-sensitive
 */
class ClockSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test

     */
    public function instance(): void
    {
        $spinner = new ClockSpinner(self::PROCESSING);
        $this->assertInstanceOf(ClockSpinner::class, $spinner);
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_PREFIX, $spinner->begin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_PREFIX, $spinner->spin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function interface(): void
    {
        $spinner = new ClockSpinner(self::PROCESSING);
        $this->assertInstanceOf(ClockSpinner::class, $spinner->inline(true));
        $this->assertInstanceOf(ClockSpinner::class, $spinner->inline(false));
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("🕐 Processing...\033[16D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals("🕑 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕒 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕓 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕔 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕕 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕖 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕗 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕘 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕙 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕚 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕛 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕐 Processing...\033[16D", $spinner->spin());
        $this->assertEquals("🕑 Processing...\033[16D", $spinner->spin());


        $this->assertEquals(Helper::stripEscape("                \033[16D"), Helper::stripEscape($spinner->erase()));
        $this->assertEquals(Helper::stripEscape("                \033[16D"), Helper::stripEscape($spinner->end()));
        $this->assertEquals("                \033[16D", $spinner->erase());
        $this->assertEquals("                \033[16D", $spinner->end());
    }
}