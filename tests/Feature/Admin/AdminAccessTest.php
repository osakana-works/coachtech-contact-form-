<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 認証ユーザーは管理画面にアクセスできる()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    /** @test */
    public function 未ログインユーザーはログイン画面にリダイレクトされる()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }
}
