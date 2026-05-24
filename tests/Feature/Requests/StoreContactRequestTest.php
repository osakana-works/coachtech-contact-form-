<?php

namespace Tests\Feature\Requests;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreContactRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しい入力ならバリデーションが通る()
    {
        $category = Category::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tag_ids' => $tags->pluck('id')->toArray(),
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function 必須項目が欠けていたらエラーになる()
    {
        $validator = Validator::make([], (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function メール形式が不正ならエラーになる()
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'invalid-email', // ← ここだけ不正
            'tel' => '09012345678',
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tag_ids' => [],
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function 電話番号形式が不正ならエラーになる()
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => 'abcde', // ← ここだけ不正
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tag_ids' => [],
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function 電話番号が10桁未満ならエラーになる()
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '123456789', // ← 9桁
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tag_ids' => [],
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function 電話番号が11桁を超えるとエラーになる()
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '123456789012', // ← 12桁
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tag_ids' => [],
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function detailが120文字を超えるとエラーになる()
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => str_repeat('あ', 121), // ← ここだけ不正
            'tag_ids' => [],
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function 存在しないタグ_i_dならエラーになる()
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都江東区',
            'building' => 'ビル101',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容です。',
            'tag_ids' => [999999], // ← ここだけ不正
        ];

        $validator = Validator::make($data, (new StoreContactRequest)->rules());

        $this->assertTrue($validator->fails());
    }
}
