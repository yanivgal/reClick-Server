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