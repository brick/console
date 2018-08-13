<?php

declare(strict_types=1);

namespace Brick\Console;

class Pen
{
    /**
     * The display attributes.
     *
     * @var int[]
     */
    private $attributes = [];

    /**
     * @return Pen
     */
    public function bold() : Pen
    {
        $this->attributes[] = Console::MODE_BRIGHT;

        return $this;
    }

    /**
     * @return Pen
     */
    public function halfBright() : Pen
    {
        $this->attributes[] = Console::MODE_DIM;

        return $this;
    }

    /**
     * @return Pen
     */
    public function italic() : Pen
    {
        $this->attributes[] = Console::MODE_ITALIC;

        return $this;
    }

    /**
     * @return Pen
     */
    public function underscore() : Pen
    {
        $this->attributes[] = Console::MODE_UNDERSCORE;

        return $this;
    }

    /**
     * @return Pen
     */
    public function blink() : Pen
    {
        $this->attributes[] = Console::MODE_BLINK;

        return $this;
    }

    /**
     * @return Pen
     */
    public function reverse() : Pen
    {
        $this->attributes[] = Console::MODE_REVERSE;

        return $this;
    }

    /**
     * @return Pen
     */
    public function hidden() : Pen
    {
        $this->attributes[] = Console::MODE_HIDDEN;

        return $this;
    }

    /**
     * Sets the pen color.
     *
     * @param int $color A Color constant.
     *
     * @return Pen
     */
    public function color(int $color) : Pen
    {
        $this->attributes[] = 30 + $color;

        return $this;
    }

    /**
     * Sets the background color.
     *
     * @param int $color A Color constant.
     *
     * @return Pen
     */
    public function background(int $color) : Pen
    {
        $this->attributes[] = 40 + $color;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function write(string $text) : string
    {
        if (! $this->attributes) {
            return $text;
        }

        $start = "\e[" . implode(';', $this->attributes) . 'm';
        $end = "\e[0m";

        $lines = explode("\n", $text);

        foreach ($lines as $key => $line) {
            if ($line === '') {
                continue;
            }

            $lines[$key] = $start . $line . $end;
        }

        return implode("\n", $lines);
    }
}
