<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        };
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'contact_tag');
    }

    public function scopeFilter($query, array $filters)
    {
        // keyword
        if (! empty($filters['keyword'])) {
            $keyword = preg_replace('/[\s　]+/', '', $filters['keyword']);

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhereRaw('CONCAT(last_name, first_name) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('CONCAT(first_name, last_name) LIKE ?', ["%{$keyword}%"]);
            });
        }

        // gender
        if (! empty($filters['gender']) && $filters['gender'] != '0') {
            $query->where('gender', $filters['gender']);
        }

        // category_id
        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // date
        if (! empty($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }

        return $query;
    }
}
