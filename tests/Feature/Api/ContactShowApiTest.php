<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactShowApiTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function JSON形式で詳細が返される()
    {
        $contact = Contact::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->getJson("/api/v1/contacts/{$contact->id}");

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
                'category' => ['id', 'content'],
                'tags',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /** @test */
    public function タグがネストされて返される()
    {
        $tags = Tag::factory()->count(2)->create();
        $contact = Contact::factory()->create([
            'category_id' => $this->category->id,
        ]);
        $contact->tags()->attach($tags->pluck('id'));

        $response = $this->getJson("/api/v1/contacts/{$contact->id}");

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data.tags'));
    }

    /** @test */
    public function 存在しないIDで404が返される()
    {
        $response = $this->getJson('/api/v1/contacts/999999');

        $response->assertStatus(404);
    }
}