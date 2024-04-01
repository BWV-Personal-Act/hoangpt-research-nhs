<?php

namespace Database\Factories;

use App\Libs\EncryptUtil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'email' => 'group_leader@gmail.com',
            'password' => EncryptUtil::encryptSha256('test1234'),
            'name' => 'Group Leader',
            'group_id' => '1',
            'started_date' => now(),
            'position_id' => '1',
            'created_at' => now(),
        ];
    }
}
