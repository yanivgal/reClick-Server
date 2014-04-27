<?php

namespace reClick\tests\whitebox;

use reClick\Controllers\Games\Games;
use reClick\Traits\TestsTrait;

class GamesTest extends \PHPUnit_Framework_TestCase {

    use TestsTrait;

    public function testCreateGameDefaultArgs() {
        $games = new Games();
        $game = $games->create();

        $this->assertEquals('Best game ever', $game->description());
        $this->assertEquals(0, $game->numOfPlayers());
        $this->assertEquals(0, $game->numOfPlayers());
        $this->assertNull($game->sequence());
        $this->assertNull($game->turn());
        $this->assertEquals(0, $game->started());
    }

    public function testCreateGameWithArgs() {
        $games = new Games();
        $gameName = $this->randGameName();
        $gameDescription = $this->randGameDescription();
        $game = $games->create($gameName, $gameDescription);

        $this->assertEquals($gameName, $game->name());
        $this->assertEquals($gameDescription, $game->description());
        $this->assertEquals(0, $game->numOfPlayers());
        $this->assertEquals(0, $game->numOfPlayers());
        $this->assertNull($game->sequence());
        $this->assertNull($game->turn());
        $this->assertEquals(0, $game->started());
    }

    public function testDeleteAllGames() {
        $games = new Games();
        $games->create();
        $games->deleteAllGames();
        $allGames = $games->getAllGames();

        $this->assertEmpty($allGames);
    }


    public function testGetAllGames() {
        $games = new Games();
        $games->deleteAllGames();

        $numOfOpenGames = 5;
        $numOfStartedGames = 5;

        for ($i = 0; $i < $numOfOpenGames; $i++) {
            $games->create();
        }
        for ($i = 0; $i < $numOfStartedGames; $i++) {
            $game = $games->create();
            $game->start();
        }

        $allGames = $games->getAllGames();

        $this->assertCount($numOfOpenGames + $numOfStartedGames, $allGames);

        foreach ($allGames as $openGame) {
            $this->assertArrayHasKey('id', $openGame);
            $this->assertArrayHasKey('name', $openGame);
            $this->assertArrayHasKey('description', $openGame);
            $this->assertArrayHasKey('numOfPlayers', $openGame);
        }
    }

    public function testGetOpenGames() {
        $games = new Games();
        $games->deleteAllGames();

        $numOfGames = 10;
        for ($i = 0; $i < $numOfGames; $i++) {
            $games->create();
        }

        $openGames = $games->getOpenGames();
        $this->assertCount($numOfGames, $openGames);

        foreach ($openGames as $openGame) {
            $this->assertArrayHasKey('id', $openGame);
            $this->assertArrayHasKey('name', $openGame);
            $this->assertArrayHasKey('description', $openGame);
            $this->assertArrayHasKey('numOfPlayers', $openGame);
        }
    }
} 