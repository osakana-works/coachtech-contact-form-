<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->last_name.' '.$this->first_name,
            'gender' => $this->gender,
            'gender_label' => $this->gender === 1 ? '男性'
                : ($this->gender === 2 ? '女性' : 'その他'),
            'email' => $this->email,
            'tel' => $this->tel,
            'address' => $this->address,
            'building' => $this->building,
            'detail' => $this->detail,

            'category' => [
                'id' => $this->category->id,
                'content' => $this->category->content,
            ],

            'tags' => $this->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ];
            }),

            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
