<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    static $status = ["CREATED", "DOING", "FINISHED", "DELETED"];

    protected $fillable = ['title', 'description', 'status', 'execution_date'];

    public function employe(): BelongsTo{
        return $this->belongsTo(Employe::class);
    }
}
