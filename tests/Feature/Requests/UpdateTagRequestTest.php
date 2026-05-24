<?php

namespace Tests\Feature\Requests;

use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateTagRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しい入力ならバリデーションが通る()
    {
        $tag = Tag::factory()->create(['name' => '元のタグ名']);

        $data = ['name' => '新しいタグ名'];

        $validator = Validator::make(
            $data,
            (new UpdateTagRequest)->rules($tag->id)
        );

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function nameが空ならエラーになる()
    {
        $tag = Tag::factory()->create();

        $data = ['name' => ''];

        $validator = Validator::make(
            $data,
            (new UpdateTagRequest)->rules($tag->id)
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function nameが50文字を超えるとエラーになる()
    {
        $tag = Tag::factory()->create();

        $data = ['name' => str_repeat('あ', 51)];

        $validator = Validator::make(
            $data,
            (new UpdateTagRequest)->rules($tag->id)
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function 自分以外のタグ名と重複したらエラーになる()
    {
        $tag1 = Tag::factory()->create(['name' => 'タグA']);
        $tag2 = Tag::factory()->create(['name' => 'タグB']);

        $data = ['name' => 'タグA'];

        $validator = Validator::make(
            $data,
            (new UpdateTagRequest)->rules($tag2->id)
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function 自分自身の名前ならエラーにならない()
    {
        $tag = Tag::factory()->create(['name' => 'タグA']);

        $data = ['name' => 'タグA'];

        $request = new UpdateTagRequest;
        $request->merge(['tag' => $tag->id]);

        $validator = Validator::make(
            $data,
            $request->rules()
        );

        $this->assertTrue($validator->passes());
    }
}
