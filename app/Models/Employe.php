<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employe extends Model
{
    use HasFactory;

    static $status = ["ACTIVE", "INACTIVE"];

    protected $fillable = ['fullname', 'phone', 'email', 'status'];

    public function tasks(): HasMany{
        return $this->hasMany(Task::class);
    }
}
