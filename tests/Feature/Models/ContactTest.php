<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function お問い合わせはカテゴリに属している()
    {
        $category = Category::factory()->create();
        $contact = Contact::factory()->create([
            'category_id' => $category->id,
        ]);

        $result = $contact->category;

        $this->assertNotNull($result);
        $this->assertEquals($category->id, $result->id);
    }

    /** @test */
    public function お問い合わせは複数のタグと同期できる()
    {
        $contact = Contact::factory()->create();
        $tags = Tag::factory()->count(3)->create();

        $contact->tags()->sync($tags->pluck('id'));

        $this->assertCount(3, $contact->tags);
        $this->assertTrue($contact->tags->contains($tags[0]));
        $this->assertTrue($contact->tags->contains($tags[1]));
        $this->assertTrue($contact->tags->contains($tags[2]));
    }
}
