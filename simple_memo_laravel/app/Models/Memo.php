<?php

namespace App\Models;
use App\Enums\MemoType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// トレイト使用
use Illuminate\Database\Eloquent\SoftDeletes;


class Memo extends Model
{
    use HasFactory;
    // SoftDeletesをuse
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'pick_memo',
        'deleted_at',
    ];

    // public function memo()
    // {
    //     return $this->hasOne('App\Models\Image');

    // }

}
