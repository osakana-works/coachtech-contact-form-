<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactIndexApiTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function jso_n形式で一覧が返される()
    {
        Contact::factory()->count(3)->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->getJson('/api/v1/contacts');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'full_name',
                    'gender',
                    'gender_label',
                    'email',
                    'tel',
                    'address',
                    'building',
                    'detail',
                    'category',
                    'tags',
                    'created_at',
                    'updated_at',
                ],
            ],
            'meta' => [
                'current_page',
                'last_page',
                'per_page',
                'total',
            ],
        ]);
    }

    /** @test */
    public function ページネーションが機能する()
    {
        Contact::factory()->count(15)->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->getJson('/api/v1/contacts?per_page=10');

        $response->assertStatus(200);
        $response->assertJsonPath('meta.per_page', 10);
        $response->assertJsonPath('meta.total', 15);
        $this->assertCount(10, $response->json('data'));
    }

    /** @test */
    public function keywordで検索できる()
    {
        Contact::factory()->create([
            'category_id' => $this->category->id,
            'first_name' => '山田',
            'last_name' => '太郎',
        ]);

        Contact::factory()->create([
            'category_id' => $this->category->id,
            'first_name' => '鈴木',
            'last_name' => '花子',
        ]);

        $response = $this->getJson('/api/v1/contacts?keyword=山田');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function emailで検索できる()
    {
        Contact::factory()->create([
            'category_id' => $this->category->id,
            'email' => 'target@example.com',
        ]);

        Contact::factory()->create([
            'category_id' => $this->category->id,
            'email' => 'other@example.com',
        ]);

        $response = $this->getJson('/api/v1/contacts?keyword=target');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function dateで検索できる()
    {
        Contact::factory()->create([
            'category_id' => $this->category->id,
            'created_at' => '2024-05-01 10:00:00',
        ]);

        Contact::factory()->create([
            'category_id' => $this->category->id,
            'created_at' => '2024-06-01 10:00:00',
        ]);

        $response = $this->getJson('/api/v1/contacts?date=2024-05-01');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function genderで検索できる()
    {
        Contact::factory()->count(2)->create([
            'category_id' => $this->category->id,
            'gender' => 1,
        ]);

        Contact::factory()->count(3)->create([
            'category_id' => $this->category->id,
            'gender' => 2,
        ]);

        $response = $this->getJson('/api/v1/contacts?gender=1');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    /** @test */
    public function genderが不正な場合は422が返される()
    {
        $response = $this->getJson('/api/v1/contacts?gender=4');

        $response->assertStatus(422);
        $response->assertJsonFragment(['gender' => ['性別の値が不正です']]);
    }

    /** @test */
    public function 存在しないcategory_idの場合は422が返される()
    {
        $response = $this->getJson('/api/v1/contacts?category_id=999999');

        $response->assertStatus(422);
        $response->assertJsonFragment(['category_id' => ['選択されたカテゴリーが存在しません']]);
    }

    /** @test */
    public function keywordが256文字以上の場合は422が返される()
    {
        $response = $this->getJson('/api/v1/contacts?keyword='.str_repeat('あ', 256));

        $response->assertStatus(422);
    }

    /** @test */
    public function per_pageが101の場合は422が返される()
    {
        $response = $this->getJson('/api/v1/contacts?per_page=101');

        $response->assertStatus(422);
    }

    /** @test */
    public function per_pageが0の場合は422が返される()
    {
        $response = $this->getJson('/api/v1/contacts?per_page=0');

        $response->assertStatus(422);
    }

    /** @test */
    public function pageが0の場合は422が返される()
    {
        $response = $this->getJson('/api/v1/contacts?page=0');

        $response->assertStatus(422);
    }
}
