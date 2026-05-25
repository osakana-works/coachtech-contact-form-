<?php

namespace Tests\Feature\Contacts;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function バリデーション通過時にお問い合わせが保存されタグも紐づく()
    {
        // Arrange: カテゴリとタグを作成
        $category = Category::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        // 入力データ
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

        $response = $this->post('/contacts', $data);

        $response->assertRedirect('/thanks');

        $this->assertDatabaseHas('contacts', [
            'last_name' => '山田',
            'first_name' => '太郎',
            'email' => 'test@example.com',
            'category_id' => $category->id,
        ]);

        $contact = Contact::first();

        foreach ($tags as $tag) {
            $this->assertDatabaseHas('contact_tag', [
                'contact_id' => $contact->id,
                'tag_id' => $tag->id,
            ]);
        }
    }

    /** @test */
    public function バリデーションエラー時は保存されずエラーが返る()
    {
        // 必須項目を空で送信
        $response = $this->post('/contacts', []);

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

        $this->assertDatabaseCount('contacts', 0);
    }
}
