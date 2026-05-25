<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFunctionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 検索とページネーションが正しく機能する()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'content' => 'テストカテゴリ',
        ]);

        // 10件のデータを作成（ページネーション確認用）
        Contact::factory()->count(10)->create([
            'category_id' => $category->id,
            'gender' => '1',
            'created_at' => '2024-01-01',
            'first_name' => '山田',
            'last_name' => '太郎',
        ]);

        $response = $this->actingAs($user)->get('/admin?keyword=山田&gender=1&category_id='.$category->id.'&date=2024-01-01');

        $response->assertStatus(200);

        $response->assertSee('山田 太郎');

        $response->assertSee('テストカテゴリ');

        $response->assertSee('<nav', false);
        $this->assertEquals(7, substr_count($response->getContent(), '山田 太郎'));
    }
}
