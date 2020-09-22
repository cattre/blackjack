<?php

require '../blackjack.php';

use PHPUnit\Framework\TestCase;

class test extends TestCase
{
    public function deal() {
        $expected = count();
        $input = (true);
        $case = loginOut($input);
        $this->assertEquals($expected, $case);
    }

}