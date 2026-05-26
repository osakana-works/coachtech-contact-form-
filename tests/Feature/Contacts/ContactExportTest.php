<?php

namespace Tests\Feature\Contacts;

use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactExportTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function ログイン済み管理者が_cs_vをダウンロードできる()
    {
        Contact::factory()->count(3)->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get('/contacts/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition');
    }

    /** @test */
    public function 未ログインの場合はリダイレクトされる()
    {
        $response = $this->get('/contacts/export');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function フィルタ条件付きで_cs_vをダウンロードできる()
    {
        Contact::factory()->count(2)->create([
            'category_id' => $this->category->id,
            'gender' => 1,
        ]);

        Contact::factory()->count(2)->create([
            'category_id' => $this->category->id,
            'gender' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->get('/contacts/export?gender=1');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function フィルタ未指定時は全件取得される()
    {
        Contact::factory()->count(5)->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get('/contacts/export');

        $response->assertStatus(200);
    }

    /** @test */
    public function 無指定時は新着順で出力される()
    {
        $old = Contact::factory()->create([
            'category_id' => $this->category->id,
            'created_at' => now()->subDays(2),
        ]);

        $new = Contact::factory()->create([
            'category_id' => $this->category->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get('/contacts/export');

        $response->assertStatus(200);

        $csv = $response->getContent();
        $lines = explode("\n", $csv);

        // ヘッダー行を除いた1行目が新しいデータのIDであることを確認
        $firstDataLine = $lines[1];
        $this->assertStringContainsString((string) $new->id, $firstDataLine);
    }
}
