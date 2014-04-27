<?php

namespace reClick\tests\whitebox\Players;

use reClick\Controllers\Players\Player;
use reClick\Controllers\Players\Players;
use reClick\Traits\TestsTrait;

class PlayersTest extends \PHPUnit_Framework_TestCase {

    use TestsTrait;

    public function testCreatePlayer() {
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

        $this->assertEquals($username, $player->username());
        $this->assertEquals($password, $player->password());
        $this->assertEquals($nickname, $player->nickname());
        $this->assertEquals($gcmRegId, $player->gcmRegId());
    }

    /**
     * @expectedException \PDOException
     * @expectedExceptionCode 23000
     */
    public function testCreateDuplicateUsername() {
        $username = $this->randUserame();

        (new Players())->create(
            $username,
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );

        (new Players())->create(
            $username,
            $this->randPassword(),
            $this->randNickname(),
            $this->randGcmRegId()
        );
    }

    public function testCreatePlayerHashPassword() {
        $password = $this->randPassword();

        $player = (new Players())->create(
            $this->randUserame(),
            $password,
            $this->randNickname(),
            $this->randGcmRegId(),
            Player::HASH_PASSWORD
        );

        $this->assertEquals($this->hashPassword($password), $player->password());
    }
} 