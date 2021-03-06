<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Core\Jugglers\MessageJuggler;
use AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Tests\Spinner\ExtendedSpinner;
use AlecRabbit\Tests\Spinner\Helper;
use PHPUnit\Framework\TestCase;

use function AlecRabbit\Helpers\getValue;

use const AlecRabbit\NO_COLOR_TERMINAL;

class AdditionalSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $s = new ExtendedSpinner(null, false, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $s);
        $this->assertSame(0.1, $s->interval());
        $frameJuggler = getValue($s, 'frameJuggler');
        $messageJuggler = getValue($s, 'messageJuggler');
        $progressJuggler = getValue($s, 'progressJuggler');
        $this->assertInstanceOf(FrameJuggler::class, $frameJuggler);
        $this->assertNull($messageJuggler);
        $this->assertNull($progressJuggler);

        $begin = $s->begin(0.0);
        $this->assertIsString($begin);
        $this->assertEquals(
            '\033[?25l1 0% \033[5D',
            Helper::replaceEscape($begin)
        );
        $this->assertEquals('2 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 0% \033[5D', Helper::replaceEscape($s->spin()));
        $s->progress(0.022);
        $this->assertEquals('3 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 2% \033[5D', Helper::replaceEscape($s->spin()));
        $s->progress(0.556);
        $this->assertEquals('4 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 55% \033[6D', Helper::replaceEscape($s->spin()));
        $s->progress(1.0);
        $this->assertEquals('1 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 100% \033[7D', Helper::replaceEscape($s->spin()));

        $this->assertEquals('\033[7X', Helper::replaceEscape($s->erase()));
        $this->assertEquals('\033[7X\033[?25h', Helper::replaceEscape($s->end()));
        $this->assertEquals('\033[7X\033[?25h', Helper::replaceEscape($s->end()));

        $this->assertEquals('\033[?25l2 0% \033[2X\033[5D', Helper::replaceEscape($s->begin(0.0)));
        $this->assertEquals('3 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 0% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 0% \033[5D', Helper::replaceEscape($s->spin()));
        $s->progress(0.022);
        $this->assertEquals('3 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 2% \033[5D', Helper::replaceEscape($s->spin()));
        $s->progress(0.556);
        $this->assertEquals('4 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 55% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 55% \033[6D', Helper::replaceEscape($s->spin()));
        $s->progress(1.0);
        $this->assertEquals('1 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 100% \033[7D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 100% \033[7D', Helper::replaceEscape($s->spin()));

        $this->assertEquals('\033[?25l2 \033[5X\033[2D', Helper::replaceEscape($s->begin()));
        $this->assertEquals('3 \033[2D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 \033[2D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 \033[2D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 \033[2D', Helper::replaceEscape($s->spin()));
        $s->progress(0.022);
        $this->assertEquals('3 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('4 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('1 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('2 2% \033[5D', Helper::replaceEscape($s->spin()));
        $this->assertEquals('3 2% \033[5D', Helper::replaceEscape($s->spin()));
        $s->progress(0.556);
        $s->message(self::PROCESSING);
        $this->assertEquals(
            '4 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 55% \033[20D',
            Helper::replaceEscape($s->spin())
        );
        $this->assertEquals(
            '1 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 55% \033[20D',
            Helper::replaceEscape($s->spin())
        );
        $this->assertEquals(
            '2 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 55% \033[20D',
            Helper::replaceEscape($s->spin())
        );
        $this->assertEquals(
            '3 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 55% \033[20D',
            Helper::replaceEscape($s->spin())
        );
        $this->assertEquals(
            '4 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 55% \033[20D',
            Helper::replaceEscape($s->spin())
        );
        $s->progress(1.0);
        $this->assertEquals(
            '1 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 100% \033[21D',
            Helper::replaceEscape($s->spin())
        );
        $this->assertEquals(
            '2 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 100% \033[21D',
            Helper::replaceEscape($s->spin())
        );
        $s->message(null, 0);
        $this->assertEquals('3 100% \033[14X\033[7D', Helper::replaceEscape($s->spin()));
    }

    /** @test */
    public function progressOutOfBounds(): void
    {
        $s = new ExtendedSpinner(null, false, NO_COLOR_TERMINAL);
        $s->inline(true);
        $begin = $s->begin((float) - 0.1); // inspection bug fix
        $this->assertIsString($begin);
        $this->assertEquals(
            '\033[?25l 1 0% \033[6D',
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(' 2 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 3 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 4 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 1 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 2 0% \033[6D', Helper::replaceEscape($s->spin()));
        $s->progress(-2.0);
        $this->assertEquals(' 3 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 4 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 1 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 2 0% \033[6D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 3 0% \033[6D', Helper::replaceEscape($s->spin()));
        $s->progress(100.0);
        $this->assertEquals(' 4 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 1 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 2 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 3 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 4 100% \033[8D', Helper::replaceEscape($s->spin()));
        $s->progress(2.0);
        $this->assertEquals(' 1 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 2 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 3 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 4 100% \033[8D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 1 100% \033[8D', Helper::replaceEscape($s->spin()));
        $s->progress(null);
        $this->assertEquals(' 2 \033[5X\033[3D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 3 \033[3D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 4 \033[3D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 1 \033[3D', Helper::replaceEscape($s->spin()));
        $this->assertEquals(' 2 \033[3D', Helper::replaceEscape($s->spin()));
    }

    /** @test */
    public function withMessage(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);

        $this->assertInstanceOf(Spinner::class, $spinner);
        $frameJuggler = getValue($spinner, 'frameJuggler');
        $messageJuggler = getValue($spinner, 'messageJuggler');
        $progressJuggler = getValue($spinner, 'progressJuggler');
        $this->assertInstanceOf(FrameJuggler::class, $frameJuggler);
        $this->assertInstanceOf(MessageJuggler::class, $messageJuggler);
        $this->assertNull($progressJuggler);
        $begin = $spinner->begin(0.0);
        $progressJuggler = getValue($spinner, 'progressJuggler');
        $this->assertInstanceOf(ProgressJuggler::class, $progressJuggler);
        $this->assertIsString($begin);
        $this->assertEquals(
            '\033[?25l1 Processing... 0% \033[19D',
            Helper::replaceEscape($begin)
        );
        $spin = $spinner->spin();
        $this->assertEquals(
            '2 Processing... 0% \033[19D',
            Helper::replaceEscape($spin)
        );
    }
}
