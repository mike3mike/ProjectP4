<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;
    protected $table = 'user_task';
    protected $fillable = ['user_id', 'status', 'admit', 'task_id','assigned_by'];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function task() {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function coordinator() {
        return $this->belongsTo(User::class, 'assigned_by');
    }
    
}