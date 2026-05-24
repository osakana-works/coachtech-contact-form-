<?php

namespace Tests\Feature\Requests;

use App\Http\Requests\IndexContactRequest;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class IndexContactRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しい検索条件ならバリデーションが通る()
    {
        $category = Category::factory()->create();

        $data = [
            'keyword' => '山田',
            'gender' => 1,
            'category_id' => $category->id,
            'date' => '2024-05-01',
        ];

        $validator = Validator::make($data, (new IndexContactRequest)->rules());

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function genderが不正ならエラーになる()
    {
        $data = ['gender' => 4];

        $validator = Validator::make($data, (new IndexContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function category_idが存在しないならエラーになる()
    {
        $data = ['category_id' => 999999];

        $validator = Validator::make($data, (new IndexContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function dateが不正ならエラーになる()
    {
        $data = ['date' => '2024-13-99'];

        $validator = Validator::make($data, (new IndexContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }
}
