<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactStoreApiTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    private function validData(array $override = []): array
    {
        return array_merge([
            'first_name'  => '山田',
            'last_name'   => '太郎',
            'gender'      => 1,
            'email'       => 'test@example.com',
            'tel'         => '09012345678',
            'address'     => '東京都江東区',
            'category_id' => $this->category->id,
            'detail'      => 'お問い合わせ内容です。',
        ], $override);
    }

    /** @test */
    public function 正しいデータで201が返される()
    {
        $response = $this->postJson('/api/v1/contacts', $this->validData());

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
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
        ]);
    }

    /** @test */
    public function タグ付きで作成できる()
    {
        $tags = Tag::factory()->count(2)->create();

        $response = $this->postJson('/api/v1/contacts', $this->validData([
            'tag_ids' => $tags->pluck('id')->toArray(),
        ]));

        $response->assertStatus(201);
        $this->assertCount(2, $response->json('data.tags'));
    }

    /** @test */
    public function 必須項目が空の場合は422が返される()
    {
        $response = $this->postJson('/api/v1/contacts', []);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
                'last_name',
                'gender',
                'email',
                'tel',
                'address',
                'category_id',
                'detail',
            ],
        ]);
    }

    /** @test */
    public function 電話番号が不正な場合は422が返される()
    {
        $response = $this->postJson('/api/v1/contacts', $this->validData([
            'tel' => '123',
        ]));

        $response->assertStatus(422);
        $response->assertJsonFragment(['tel' => ['電話番号はハイフンなしの10〜11桁の数字で入力してください']]);
    }

    /** @test */
    public function 性別が不正な場合は422が返される()
    {
        $response = $this->postJson('/api/v1/contacts', $this->validData([
            'gender' => 5,
        ]));

        $response->assertStatus(422);
        $response->assertJsonFragment(['gender' => ['性別の値が不正です']]);
    }

    /** @test */
    public function 存在しないカテゴリの場合は422が返される()
    {
        $response = $this->postJson('/api/v1/contacts', $this->validData([
            'category_id' => 999999,
        ]));

        $response->assertStatus(422);
        $response->assertJsonFragment(['category_id' => ['選択されたカテゴリーが存在しません']]);
    }

    /** @test */
    public function 存在しないタグの場合は422が返される()
    {
        $response = $this->postJson('/api/v1/contacts', $this->validData([
            'tag_ids' => [999999],
        ]));

        $response->assertStatus(422);
        $response->assertJsonFragment(['tag_ids.0' => ['選択されたタグが存在しません']]);
    }
}