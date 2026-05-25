<?php

namespace Tests\Feature\Admin;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 認証済みユーザーはタグ編集画面を表示できる()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create([
            'name' => '編集前タグ',
        ]);

        $response = $this->actingAs($user)->get('/admin/tags/'.$tag->id.'/edit');

        $response->assertStatus(200);

        $response->assertSee('編集前タグ');
    }

    /** @test */
    public function 認証済みユーザーはタグを作成できる()
    {
        $user = User::factory()->create();

        $data = ['name' => '新しいタグ'];

        $response = $this->actingAs($user)->post('/admin/tags', $data);

        $response->assertRedirect('/admin');

        $this->assertDatabaseHas('tags', [
            'name' => '新しいタグ',
        ]);
    }

    /** @test */
    public function 認証済みユーザーはタグを更新できる()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create([
            'name' => '旧タグ名',
        ]);

        $data = ['name' => '新タグ名'];

        $response = $this->actingAs($user)->put('/admin/tags/'.$tag->id, $data);

        $response->assertRedirect('/admin');

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => '新タグ名',
        ]);
    }

    /** @test */
    public function 認証済みユーザーはタグを削除できる()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create([
            'name' => '削除対象タグ',
        ]);

        $response = $this->actingAs($user)->delete('/admin/tags/'.$tag->id);

        $response->assertRedirect('/admin');

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }

    /** @test */
    public function 未認証ユーザーはタグ操作ができず_loginにリダイレクトされる()
    {
        $tag = Tag::factory()->create();

        $this->get('/admin/tags/'.$tag->id.'/edit')
            ->assertRedirect('/login');

        $this->post('/admin/tags', ['name' => '不正作成'])
            ->assertRedirect('/login');

        $this->put('/admin/tags/'.$tag->id, ['name' => '不正更新'])
            ->assertRedirect('/login');

        $this->delete('/admin/tags/'.$tag->id)
            ->assertRedirect('/login');
    }
}
