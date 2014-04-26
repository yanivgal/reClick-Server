<?php

namespace reClick\tests\whitebox\Players;

use reClick\Controllers\Players\Player;
use reClick\Controllers\Players\Players;

class PlayersTest extends \PHPUnit_Framework_TestCase {

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
    public function testDuplicateUsername() {
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

    public function testHashPassword() {
        $password = $this->randPassword();

        $player = (new Players())->create(
            $this->randUserame(),
            $password,
            $this->randNickname(),
            $this->randGcmRegId(),
            Player::HASH_PASSWORD
        );

        $this->assertEquals($this->hashPassword($password), $player->password());

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

    private function randUserame() {
        return $this->rand('username');
    }

    private function randPassword() {
        return $this->rand('passwors');
    }

    private function randNickname() {
        return $this->rand('nickname');
    }

    private function randGcmRegId() {
        return sha1($this->rand('gcm')) . sha1($this->rand('gcm'));
    }

    private function rand($prefix) {
        return $prefix . rand(1, 1000000);
    }

    private function hashPassword($password) {
        return md5($password);
    }
} 