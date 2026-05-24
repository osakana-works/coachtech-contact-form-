<?php

namespace Tests\Feature\Requests;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreTagRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しい入力ならバリデーションが通る()
    {
        $data = ['name' => '新しいタグ'];

        $validator = Validator::make($data, (new StoreTagRequest)->rules());

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function nameが空ならエラーになる()
    {
        $data = ['name' => ''];

        $validator = Validator::make($data, (new StoreTagRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function nameが50文字を超えるとエラーになる()
    {
        $data = ['name' => str_repeat('あ', 51)];

        $validator = Validator::make($data, (new StoreTagRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function nameが重複していたらエラーになる()
    {
        Tag::factory()->create(['name' => '重複タグ']);

        $data = ['name' => '重複タグ'];

        $validator = Validator::make($data, (new StoreTagRequest)->rules());

        $this->assertTrue($validator->fails());
    }
}
