<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    static $status = ["CREATED", "DOING", "FINISHED"];

    protected $fillable = ['title', 'description', 'status', 'execution_date'];

    protected $appends = ['delay'];

    public function employe(): BelongsTo{
        return $this->belongsTo(Employe::class);
    }

    public function getDelayAttribute(){
        $executionDate = new DateTime($this->execution_date);
        $delayDays = $executionDate->diff(now());
        return $executionDate > now() ? 0 : ($delayDays->days);
    }
}
