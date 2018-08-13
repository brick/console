<?php

require __DIR__ . '/vendor/autoload.php';

use Brick\Console\Console;

$console = new Console();

/* Erase screen */

$console->eraseScreen();

/* Test colors */

$console->setBackgroundColor(Console::COLOR_BLACK);

$console->setTextColor(Console::COLOR_RED);
$console->println('Red on black');

$console->setTextColor(Console::COLOR_GREEN);
$console->println('Green on black');

$console->setTextColor(Console::COLOR_YELLOW);
$console->println('Yellow on black');

$console->setTextColor(Console::COLOR_BLUE);
$console->println('Blue on black');

$console->setTextColor(Console::COLOR_MAGENTA);
$console->println('Magenta on black');

$console->setTextColor(Console::COLOR_CYAN);
$console->println('Cyan on black');

$console->setTextColor(Console::COLOR_WHITE);
$console->println('Green on black');

$console->setTextColor(Console::COLOR_WHITE);
$console->setBackgroundColor(Console::COLOR_RED);
$console->println('White on red');

$console->setBackgroundColor(Console::COLOR_GREEN);
$console->println('White on green');

$console->setBackgroundColor(Console::COLOR_YELLOW);
$console->println('White on yellow');

$console->setBackgroundColor(Console::COLOR_BLUE);
$console->println('White on blue');

$console->setBackgroundColor(Console::COLOR_MAGENTA);
$console->println('White on magenta');

$console->setBackgroundColor(Console::COLOR_CYAN);
$console->println('White on cyan');

$console->setTextColor(Console::COLOR_BLACK);
$console->setBackgroundColor(Console::COLOR_WHITE);
$console->println('Black on white');

$console->setTextMode(Console::MODE_DEFAULT);
$console->println('Back to default');

$console->setTextMode(Console::MODE_BRIGHT);
$console->println('Bright');
$console->setTextMode(Console::MODE_DEFAULT);

$console->setTextMode(Console::MODE_DIM);
$console->println('Dim');
$console->setTextMode(Console::MODE_DEFAULT);

$console->setTextMode(Console::MODE_UNDERSCORE);
$console->println('Underscore');
$console->setTextMode(Console::MODE_DEFAULT);

$console->setTextMode(Console::MODE_BLINK);
$console->println('Blink');
$console->setTextMode(Console::MODE_DEFAULT);

$console->setTextMode(Console::MODE_REVERSE);
$console->println('Reverse');
$console->setTextMode(Console::MODE_DEFAULT);

$console->setTextMode(Console::MODE_HIDDEN);
$console->println('Hidden');
$console->setTextMode(Console::MODE_DEFAULT);

/* Test cursor positioning : draw a red cross */

$draw = function () use ($console) {
    $console->setTextColor(Console::COLOR_RED);
    $console->setBackgroundColor(Console::COLOR_RED);
    echo "X";
    $console->setTextMode(Console::MODE_DEFAULT);
    $console->moveCursorBackward();
};

$console->saveCursorPosition();

$console->moveCursorUp(3);
$console->moveCursorForward(20);
$draw();

$console->moveCursorDown(2);
$draw();

$console->moveCursorBackward(1);
$console->moveCursorUp(1);
$draw();

$console->moveCursorForward(2);
$draw();

$console->moveCursorBackward();
$draw();

$console->setTextMode(Console::MODE_DEFAULT);
$console->restoreCursorPosition();

/* Test cursor absolute positioning */

$console->saveCursorPosition();

$console->setCursorHome();
$console->setBackgroundColor(Console::COLOR_RED);
$console->setTextColor(Console::COLOR_WHITE);
echo "HOME";
$console->setTextMode(Console::MODE_DEFAULT);

$console->setCursorPosition(3, 5);
$console->setBackgroundColor(Console::COLOR_RED);
$console->setTextColor(Console::COLOR_WHITE);
echo "WRITING AT POSITION 3,5";
$console->setTextMode(Console::MODE_DEFAULT);

$console->restoreCursorPosition();

/* Test erase to end of line */

echo "No 'X' should appear here -> XXXXXXXXXX";
$console->moveCursorBackward(10);
$console->eraseToEndOfLine();
echo "\n";

echo 'XXXXXXXXXX';
$console->eraseToStartOfLine();
echo " <- No 'X' should appear here\n";

echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget volutpat nunc.";
$console->moveCursorBackward(51);
$console->eraseLine();
echo "<-- No text should appear on either side -->\n";

echo 'Press ENTER to test erase screen up';
$line = readline('');

$console->saveCursorPosition();
$console->moveCursorUp(15);
$console->eraseUp();
$console->restoreCursorPosition();

echo 'Press ENTER to test erase screen down';
$line = readline('');

$console->saveCursorPosition();
$console->moveCursorUp(10);
$console->eraseDown();
$console->restoreCursorPosition();

echo "End of tests.\n";
