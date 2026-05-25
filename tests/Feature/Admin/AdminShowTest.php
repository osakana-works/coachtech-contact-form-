<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function お問い合わせ詳細ページが正しく表示される()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'content' => 'テストカテゴリ',
        ]);

        $tag = Tag::factory()->create([
            'name' => '重要',
        ]);

        $contact = Contact::factory()->create([
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'category_id' => $category->id,
            'detail' => 'テストお問い合わせ内容',
        ]);

        $contact->tags()->attach($tag->id);

        $response = $this->actingAs($user)->get('/admin/contacts/'.$contact->id);

        $response->assertStatus(200);

        $response->assertSee('山田 太郎');

        $response->assertSee('test@example.com');

        $response->assertSee('テストカテゴリ');

        $response->assertSee('重要');

        $response->assertSee('テストお問い合わせ内容');
    }
}
