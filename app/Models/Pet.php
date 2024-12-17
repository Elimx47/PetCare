<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'type',
        'breed',
        'age',
        'gender',
        'description',
        'image',
        'health',
        'status',
        'approved',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withDefault([
            'name' => 'Deleted User'
        ]);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }
}
