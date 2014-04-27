<?php

namespace reClick\tests\whitebox\Players;

use reClick\Controllers\Players\Player;
use reClick\Controllers\Players\Players;
use reClick\Traits\TestsTrait;

class PlayerTest extends \PHPUnit_Framework_TestCase {

    use TestsTrait;

    /**
     * @expectedException \PDOException
     * @expectedExceptionCode 23000
     */
    public function testUpdateDuplicateUsername() {
        $username = $this->randUserame();

        (new Players())->create(
            $username,
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );

        $player = (new Players())->create(
            $this->randUserame(),
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );

        $player->username($username);
    }

    public function testInstantiatePlayer() {
        $username = $this->randUserame();
        $password = $this->randPassword();
        $nickname = $this->randNickname();
        $gcmRegId = $this->randGcmRegId();

        $player = (new Players())->create(
            $username,
            $password,
            $nickname,
            $gcmRegId
        );

        $id = $player->id();

        $player = new Player($id);
        $this->assertEquals($username, $player->username());
        $this->assertEquals($password, $player->password());
        $this->assertEquals($nickname, $player->nickname());
        $this->assertEquals($gcmRegId, $player->gcmRegId());

        $player = new Player($username);
        $this->assertEquals($username, $player->username());
        $this->assertEquals($password, $player->password());
        $this->assertEquals($nickname, $player->nickname());
        $this->assertEquals($gcmRegId, $player->gcmRegId());
    }

    public function testUpdatePlayerHashPassword() {
        $player = (new Players())->create(
            $this->randUserame(),
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );

        $password = $this->randPassword();
        $player->password($password, Player::HASH_PASSWORD);
    }

    public function testPlayerExistence() {
        $username = $this->randUserame();
        (new Players())->create(
            $username,
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );
        $realPlayer = new Player($username);
        $emptyPlayer = new Player($this->randUserame());

        $this->assertTrue($realPlayer->exists());
        $this->assertFalse($emptyPlayer->exists());
    }

    public function testPlayerUpdateInfo() {
        $player = (new Players())->create(
            $this->randUserame(),
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );

        $newUsername = $this->randUserame();
        $newPassword = $this->randPassword();
        $newNickname = $this->randNickname();
        $newGcmRegId = $this->randGcmRegId();

        $player->username($newUsername);
        $player->password($newPassword);
        $player->nickname($newNickname);
        $player->gcmRegId($newGcmRegId);

        $this->assertEquals($newUsername, $player->username());
        $this->assertEquals($newPassword, $player->password());
        $this->assertEquals($newNickname, $player->nickname());
        $this->assertEquals($newGcmRegId, $player->gcmRegId());
    }
} 