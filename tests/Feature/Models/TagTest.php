<?php

namespace Tests\Feature\Models;

use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function タグに紐づく複数のお問い合わせを取得できる()
    {
        $tag = Tag::factory()->create();

        $contacts = Contact::factory()->count(3)->create();

        $tag->contacts()->sync($contacts->pluck('id'));

        $result = $tag->contacts;

        $this->assertCount(3, $result);
        $this->assertTrue($result->contains($contacts[0]));
        $this->assertTrue($result->contains($contacts[1]));
        $this->assertTrue($result->contains($contacts[2]));
    }
}
