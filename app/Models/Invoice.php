<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = ['signature', 'specifics', 'address_id', 'task_id'];
    public function task() {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function address() {
        return $this->belongsTo(Address::class, 'address_id');
    }
}