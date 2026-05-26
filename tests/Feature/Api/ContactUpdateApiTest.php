<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactUpdateApiTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;
    private Contact $contact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->contact = Contact::factory()->create([
            'category_id' => $this->category->id,
        ]);
    }

    /** @test */
    public function 正しいデータで200が返される()
    {
        $response = $this->putJson("/api/v1/contacts/{$this->contact->id}", [
            'first_name'  => '更新',
            'last_name'   => 'テスト',
            'gender'      => 2,
            'email'       => 'update@example.com',
            'tel'         => '08012345678',
            'address'     => '大阪府大阪市1-1-1',
            'category_id' => $this->category->id,
            'detail'      => '更新テストです',
        ]);

        $response->assertStatus(200);
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
    public function タグを更新できる()
    {
        $tags = Tag::factory()->count(2)->create();

        $response = $this->putJson("/api/v1/contacts/{$this->contact->id}", [
            'first_name'  => '更新',
            'last_name'   => 'テスト',
            'gender'      => 1,
            'email'       => 'update@example.com',
            'tel'         => '09012345678',
            'address'     => '東京都江東区',
            'category_id' => $this->category->id,
            'detail'      => '更新テストです',
            'tag_ids'     => $tags->pluck('id')->toArray(),
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data.tags'));
    }

    /** @test */
    public function 存在しないIDで404が返される()
    {
        $response = $this->putJson('/api/v1/contacts/999999', [
            'first_name' => '更新',
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function 電話番号が不正な場合は422が返される()
    {
        $response = $this->putJson("/api/v1/contacts/{$this->contact->id}", [
            'tel' => '123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['tel' => ['電話番号はハイフンなしの10〜11桁で入力してください']]);
    }

    /** @test */
    public function 性別が不正な場合は422が返される()
    {
        $response = $this->putJson("/api/v1/contacts/{$this->contact->id}", [
            'gender' => 5,
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['gender' => ['性別の値が不正です']]);
    }

    /** @test */
    public function 存在しないカテゴリの場合は422が返される()
    {
        $response = $this->putJson("/api/v1/contacts/{$this->contact->id}", [
            'category_id' => 999999,
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['category_id' => ['選択されたカテゴリーが存在しません']]);
    }

    /** @test */
    public function 存在しないタグの場合は422が返される()
    {
        $response = $this->putJson("/api/v1/contacts/{$this->contact->id}", [
            'tag_ids' => [999999],
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['tag_ids.0' => ['選択されたタグが存在しません']]);
    }
}