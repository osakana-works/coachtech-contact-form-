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

    /** @test */
    public function per_pageが範囲外ならエラーになる()
    {
        $data = ['per_page' => 0];
        $validator = Validator::make($data, (new IndexContactRequest)->rules());
        $this->assertTrue($validator->fails());

        $data = ['per_page' => 101];
        $validator = Validator::make($data, (new IndexContactRequest)->rules());
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function per_pageが正しい値ならバリデーションが通る()
    {
        $data = ['per_page' => 10];
        $validator = Validator::make($data, (new IndexContactRequest)->rules());
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function genderが不正な場合APIは422を返す()
    {
        $response = $this->getJson('/api/v1/contacts?gender=4');

        $response->assertStatus(422);
        $response->assertJsonFragment(['gender' => ['性別の値が不正です']]);
    }

    /** @test */
    public function 存在しないcategory_idの場合APIは422を返す()
    {
        $response = $this->getJson('/api/v1/contacts?category_id=999999');

        $response->assertStatus(422);
        $response->assertJsonFragment(['category_id' => ['選択されたカテゴリーが存在しません']]);
    }

}
