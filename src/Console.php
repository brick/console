<?php

declare(strict_types=1);

namespace Brick\Console;

/**
 * Console tools.
 */
class Console
{
    /**
     * The available text modes.
     */
    public const MODE_DEFAULT     = 0;
    public const MODE_BOLD        = 1;
    public const MODE_HALF_BRIGHT = 2;
    public const MODE_ITALIC      = 3;
    public const MODE_UNDERSCORE  = 4;
    public const MODE_BLINK       = 5;
    public const MODE_REVERSE     = 7;
    public const MODE_HIDDEN      = 8;

    /**
     * The available text/background colors.
     */
    public const COLOR_BLACK   = 0;
    public const COLOR_RED     = 1;
    public const COLOR_GREEN   = 2;
    public const COLOR_YELLOW  = 3;
    public const COLOR_BLUE    = 4;
    public const COLOR_MAGENTA = 5;
    public const COLOR_CYAN    = 6;
    public const COLOR_WHITE   = 7;

    /**
     * @var bool
     */
    private $isTerminal = false;

    /**
     * Console constructor.
     */
    public function __construct()
    {
        if (PHP_SAPI !== 'cli') {
            throw new \RuntimeException('Console can only run in CLI environment.');
        }

        if (extension_loaded('posix')) {
            $this->isTerminal = posix_isatty(STDOUT);
        }
    }

    /**
     * Returns whether the program is running in a terminal.
     *
     * @return bool
     */
    public function isTerminal() : bool
    {
        return $this->isTerminal;
    }

    /**
     * @param string   $text
     * @param resource $channel
     *
     * @return void
     */
    public function println(string $text, $channel = STDOUT) : void
    {
        fwrite($channel, $text);
        fwrite($channel, PHP_EOL);
    }

    /**
     * Resets all terminal settings to default.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function reset() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('c');
    }

    /**
     * Enables line wrapping.
     *
     * Text wraps to next line if longer than the length of the display area.
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function enableLineWrap() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[7h');
    }

    /**
     * Disables line wrapping.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function disableLineWrap() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[7l');
    }

    /**
     * Sets the cursor to the home position, at the upper left of the screen.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function setCursorHome() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[H');
    }

    /**
     * Sets the cursor position.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @param int $row
     * @param int $column
     *
     * @return void
     */
    public function setCursorPosition(int $row, int $column) : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[' . $row . ';' . $column . 'H');
    }

    /**
     * Moves the cursor up by a number of rows.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @param int $rows
     *
     * @return void
     */
    public function moveCursorUp(int $rows = 1) : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[' . $rows . 'A');
    }

    /**
     * Moves the cursor down by a number of rows.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @param int $rows
     *
     * @return void
     */
    public function moveCursorDown(int $rows = 1) : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[' . $rows . 'B');
    }

    /**
     * Moves the cursor forward by a number of columns.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @param int $columns
     *
     * @return void
     */
    public function moveCursorForward(int $columns = 1) : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[' . $columns . 'C');
    }

    /**
     * Moves the cursor backward by a number of columns.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @param int $columns
     *
     * @return void
     */
    public function moveCursorBackward(int $columns = 1) : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[' . $columns . 'D');
    }

    /**
     * Saves the current cursor position.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function saveCursorPosition() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[s');
    }

    /**
     * Restores the current cursor position after saveCursorPosition().
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function restoreCursorPosition() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[u');
    }

    /**
     * Shows the cursor.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function showCursor() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[?25h');
    }

    /**
     * Hides the cursor.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function hideCursor() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[?25l');
    }

    /**
     * Erases from the current cursor position to the end of the current line.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function eraseToEndOfLine() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[K');
    }

    /**
     * Erases from the current cursor position to the start of the current line.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function eraseToStartOfLine() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[1K');
    }

    /**
     * Erases the entire current line.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function eraseLine() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[2K');
    }

    /**
     * Erases the screen from the current line down to the bottom of the screen.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function eraseDown() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[J');
    }

    /**
     * Erases the screen from the current line up to the top of the screen.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function eraseUp() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[1J');
    }

    /**
     * Erases the screen with the background colour and moves the cursor to home.
     *
     * If run outside a terminal, this method throws an exception.
     *
     * @return void
     */
    public function eraseScreen() : void
    {
        $this->checkTerminal(__FUNCTION__);
        $this->writeSequence('[2J');
    }

    /**
     * Sets the text mode.
     *
     * If run outside a terminal, this method does nothing.
     *
     * @param int $mode A MODE_* constant.
     *
     * @return void
     */
    public function setTextMode(int $mode) : void
    {
        if ($this->isTerminal) {
            $this->writeSequence('[' . $mode . 'm');
        }
    }

    /**
     * Sets the text color.
     *
     * If run outside a terminal, this method does nothing.
     *
     * @param int $color A COLOR_* constant.
     *
     * @return void
     */
    public function setTextColor(int $color) : void
    {
        $this->setTextMode(30 + $color);
    }

    /**
     * Sets the background color.
     *
     * If run outside a terminal, this method does nothing.
     *
     * @param int $color A COLOR_* constant.
     *
     * @return void
     */
    public function setBackgroundColor(int $color) : void
    {
        $this->setTextMode(40 + $color);
    }

    /**
     * @param string $sequence
     *
     * @return void
     */
    private function writeSequence(string $sequence) : void
    {
        fwrite(STDOUT, "\e" . $sequence);
    }

    /**
     * @param string $function
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    private function checkTerminal(string $function) : void
    {
        if (! $this->isTerminal) {
            throw new \RuntimeException($function . '() can only be run in a terminal.');
        }
    }
}
