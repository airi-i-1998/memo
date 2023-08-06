<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'memo_id',
        'name',
        'path',
        'deleted_at',
    ];

    // public function memo()
    // {
    //     return $this->belomgsTo('App\Models\Memo');
    // }
    
}
