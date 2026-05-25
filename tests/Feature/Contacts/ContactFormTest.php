<?php

namespace Tests\Feature\Contacts;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function お問い合わせフォームが表示される()
    {
        $categories = Category::factory()->count(3)->create();
        $tags = Tag::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('contact.index');

        $response->assertViewHas('categories');
        $response->assertViewHas('tags');

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }
}
