<?php

namespace reClick\tests\whitebox;

use reClick\Controllers\Games\Game;
use reClick\Controllers\Games\Games;
use reClick\Traits\TestsTrait;

class GameTest extends \PHPUnit_Framework_TestCase {

    use TestsTrait;

    public function testInstantiateGame() {
        $games = new Games();
        $gameName = $this->randGameName();
        $gameDescription = $this->randGameDescription();
        $game = $games->create($gameName, $gameDescription);
        $gameId = $game->id();

        $game = new Game($gameId);

        $this->assertTrue($game->exists());
        $this->assertEquals($gameName, $game->name());
        $this->assertEquals($gameDescription, $game->description());
    }

    public function testGameExistence() {
        $games = new Games();
        $game = $games->create();
        $gameId = $game->id();

        $game = new Game($gameId);
        $this->assertTrue($game->exists());

        $game = new Game($this->rand(''));
        $this->assertFalse($game->exists());
    }
}