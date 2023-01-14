<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログインテスト
     *
     * @dataProvider provide_login
     * @param string $email
     * @param string $password
     * @param int $status
     * @return void
     */
    public function test_login(string $email, string $password, int $status)
    {
        $this->seed(UserSeeder::class);

        $response = $this->post(route('users.login'), [
            'user' =>  [
                'email'    => $email,
                'password' => $password,
            ],
        ]);

        $response->assertStatus($status);
    }

    public function provide_login()
    {
        return [
            '通常' => [
                'email'    => 'test@example.com',
                'password' => 'password',
                'status'   => 200,
            ],
            '認証失敗(email)' => [
                'email'    => 'test@example.hoge',
                'password' => 'password',
                'status'   => 422,
            ],
            '認証失敗(password)' => [
                'email'    => 'test@example.com',
                'password' => 'passwordd',
                'status'   => 422,
            ],
        ];
    }
}
