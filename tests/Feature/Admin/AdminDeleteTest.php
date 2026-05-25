<?php

namespace Tests\Feature\Admin;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function お問い合わせを削除できる()
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)->delete('/admin/contacts/'.$contact->id);

        $response->assertRedirect('/admin');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);

    }
}
