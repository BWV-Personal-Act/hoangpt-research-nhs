<?php

namespace App\Repositories;

use App\Libs\{EncryptUtil, ValueUtil};
use App\Models\User;

class AuthRepository extends BaseRepository
{
    public function getModel() {
        return User::class;
    }

    public function getLoginUser($params) {
        return User::query()->select(['id'])->where([
            ['email', '=', $params['email']],
            ['password', '=', EncryptUtil::encryptSha256($params['password'])],
            ['deleted_at', '=', null],
        ])->first();
    }
}
