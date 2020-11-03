<?php

require '../index.php';

use PHPUnit\Framework\TestCase;

class test extends TestCase
{
    public function testDeal() {
        $expected = [["Ace of Spades"]=> array(2) { ["value"]=> int(1) ["image"]=> string(13) "AceSpades.svg" } ["2 of Spades"]=> array(2) { ["value"]=> int(2) ["image"]=> string(11) "2Spades.svg" } ["3 of Spades"]=> array(2) { ["value"]=> int(3) ["image"]=> string(11) "3Spades.svg" } ["4 of Spades"]=> array(2) { ["value"]=> int(4) ["image"]=> string(11) "4Spades.svg" } ["5 of Spades"]=> array(2) { ["value"]=> int(5) ["image"]=> string(11) "5Spades.svg" } ["6 of Spades"]=> array(2) { ["value"]=> int(6) ["image"]=> string(11) "6Spades.svg" } ["7 of Spades"]=> array(2) { ["value"]=> int(7) ["image"]=> string(11) "7Spades.svg" } ["8 of Spades"]=> array(2) { ["value"]=> int(8) ["image"]=> string(11) "8Spades.svg" } ["9 of Spades"]=> array(2) { ["value"]=> int(9) ["image"]=> string(11) "9Spades.svg" } ["10 of Spades"]=> array(2) { ["value"]=> int(10) ["image"]=> string(12) "10Spades.svg" } ["Jack of Spades"]=> array(2) { ["value"]=> int(10) ["image"]=> string(14) "JackSpades.svg" } ["Queen of Spades"]=> array(2) { ["value"]=> int(10) ["image"]=> string(15) "QueenSpades.svg" } ["King of Spades"]=> array(2) { ["value"]=> int(10) ["image"]=> string(14) "KingSpades.svg" } ["Ace of Clubs"]=> array(2) { ["value"]=> int(1) ["image"]=> string(12) "AceClubs.svg" } ["2 of Clubs"]=> array(2) { ["value"]=> int(2) ["image"]=> string(10) "2Clubs.svg" } ["3 of Clubs"]=> array(2) { ["value"]=> int(3) ["image"]=> string(10) "3Clubs.svg" } ["4 of Clubs"]=> array(2) { ["value"]=> int(4) ["image"]=> string(10) "4Clubs.svg" } ["5 of Clubs"]=> array(2) { ["value"]=> int(5) ["image"]=> string(10) "5Clubs.svg" } ["6 of Clubs"]=> array(2) { ["value"]=> int(6) ["image"]=> string(10) "6Clubs.svg" } ["7 of Clubs"]=> array(2) { ["value"]=> int(7) ["image"]=> string(10) "7Clubs.svg" } ["8 of Clubs"]=> array(2) { ["value"]=> int(8) ["image"]=> string(10) "8Clubs.svg" } ["9 of Clubs"]=> array(2) { ["value"]=> int(9) ["image"]=> string(10) "9Clubs.svg" } ["10 of Clubs"]=> array(2) { ["value"]=> int(10) ["image"]=> string(11) "10Clubs.svg" } ["Jack of Clubs"]=> array(2) { ["value"]=> int(10) ["image"]=> string(13) "JackClubs.svg" } ["Queen of Clubs"]=> array(2) { ["value"]=> int(10) ["image"]=> string(14) "QueenClubs.svg" } ["King of Clubs"]=> array(2) { ["value"]=> int(10) ["image"]=> string(13) "KingClubs.svg" } ["Ace of Hearts"]=> array(2) { ["value"]=> int(1) ["image"]=> string(13) "AceHearts.svg" } ["2 of Hearts"]=> array(2) { ["value"]=> int(2) ["image"]=> string(11) "2Hearts.svg" } ["3 of Hearts"]=> array(2) { ["value"]=> int(3) ["image"]=> string(11) "3Hearts.svg" } ["4 of Hearts"]=> array(2) { ["value"]=> int(4) ["image"]=> string(11) "4Hearts.svg" } ["5 of Hearts"]=> array(2) { ["value"]=> int(5) ["image"]=> string(11) "5Hearts.svg" } ["6 of Hearts"]=> array(2) { ["value"]=> int(6) ["image"]=> string(11) "6Hearts.svg" } ["7 of Hearts"]=> array(2) { ["value"]=> int(7) ["image"]=> string(11) "7Hearts.svg" } ["8 of Hearts"]=> array(2) { ["value"]=> int(8) ["image"]=> string(11) "8Hearts.svg" } ["9 of Hearts"]=> array(2) { ["value"]=> int(9) ["image"]=> string(11) "9Hearts.svg" } ["10 of Hearts"]=> array(2) { ["value"]=> int(10) ["image"]=> string(12) "10Hearts.svg" } ["Jack of Hearts"]=> array(2) { ["value"]=> int(10) ["image"]=> string(14) "JackHearts.svg" } ["Queen of Hearts"]=> array(2) { ["value"]=> int(10) ["image"]=> string(15) "QueenHearts.svg" } ["King of Hearts"]=> array(2) { ["value"]=> int(10) ["image"]=> string(14) "KingHearts.svg" } ["Ace of Diamonds"]=> array(2) { ["value"]=> int(1) ["image"]=> string(15) "AceDiamonds.svg" } ["2 of Diamonds"]=> array(2) { ["value"]=> int(2) ["image"]=> string(13) "2Diamonds.svg" } ["3 of Diamonds"]=> array(2) { ["value"]=> int(3) ["image"]=> string(13) "3Diamonds.svg" } ["4 of Diamonds"]=> array(2) { ["value"]=> int(4) ["image"]=> string(13) "4Diamonds.svg" } ["5 of Diamonds"]=> array(2) { ["value"]=> int(5) ["image"]=> string(13) "5Diamonds.svg" } ["6 of Diamonds"]=> array(2) { ["value"]=> int(6) ["image"]=> string(13) "6Diamonds.svg" } ["7 of Diamonds"]=> array(2) { ["value"]=> int(7) ["image"]=> string(13) "7Diamonds.svg" } ["8 of Diamonds"]=> array(2) { ["value"]=> int(8) ["image"]=> string(13) "8Diamonds.svg" } ["9 of Diamonds"]=> array(2) { ["value"]=> int(9) ["image"]=> string(13) "9Diamonds.svg" } ["10 of Diamonds"]=> array(2) { ["value"]=> int(10) ["image"]=> string(14) "10Diamonds.svg" } ["Jack of Diamonds"]=> array(2) { ["value"]=> int(10) ["image"]=> string(16) "JackDiamonds.svg" } ["Queen of Diamonds"]=> array(2) { ["value"]=> int(10) ["image"]=> string(17) "QueenDiamonds.svg" } ["King of Diamonds"]=> array(2) { ["value"]=> int(10) ["image"]=> string(16) "KingDiamonds.svg" } };
        $case = build_deck(['Spades', 'Clubs', 'Hearts', 'Diamonds'], [
            'Ace' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10' => 10,
            'Jack' => 10,
            'Queen' => 10,
            'King' => 10
        ]);
        $this->assertEquals($expected, $case);
    }
}