<?php

namespace reClick\Traits;

trait TestsTrait {
    public function randUserame() {
        return $this->rand('username');
    }

    public function randPassword() {
        return $this->rand('password');
    }

    public function randNickname() {
        return $this->rand('nickname');
    }

    public function randGcmRegId() {
        return sha1($this->rand('gcm')) . sha1($this->rand('gcm'));
    }

    public function randGameName() {
        return $this->rand('game');
    }

    public function randGameDescription() {
        return $this->rand('description');
    }

    public function rand($prefix) {
        return $prefix . rand(1, 1000000);
    }

    public function hashPassword($password) {
        return md5($password);
    }
} 