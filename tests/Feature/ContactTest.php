<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function コンタクトとタグが多対多で関連付くこと()
    {
        $contact = Contact::factory()->create();
        $tag = Tag::factory()->create();

        $contact->tags()->attach($tag->id);

        $this->assertTrue($contact->tags->contains($tag));
    }
}
