<?php

namespace Tests\Feature\Contacts;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactConfirmTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function バリデーション通過時に確認ページが表示される()
    {
        $category = Category::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $data = [
            'last_name' => '山田',
            'first_name' => '太郎',
            'gender' => '1',
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都',
            'building' => 'テストビル',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tags' => $tags->pluck('id')->toArray(),
        ];

        $response = $this->post('/contacts/confirm', $data);

        $response->assertStatus(200);

        $response->assertViewIs('contact.confirm');

        $response->assertSee('山田');
        $response->assertSee('太郎');
        $response->assertSee('test@example.com');
        $response->assertSee($category->name);

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }

    /** @test */
    public function バリデーションエラー時はリダイレクトされエラーが返る()
    {
        // 必須項目を空で送信
        $response = $this->post('/contacts/confirm', []);

        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'category_id',
            'detail',
        ]);
    }
}
