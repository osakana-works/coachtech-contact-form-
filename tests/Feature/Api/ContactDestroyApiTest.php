<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactDestroyApiTest extends TestCase
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
    public function 正しい_i_dで204が返される()
    {
        $response = $this->deleteJson("/api/v1/contacts/{$this->contact->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('contacts', ['id' => $this->contact->id]);
    }

    /** @test */
    public function 存在しない_i_dで404が返される()
    {
        $response = $this->deleteJson('/api/v1/contacts/999999');

        $response->assertStatus(404);
    }
}
