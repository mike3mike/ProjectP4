<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';
    protected $fillable = ['task_name', 'begin_time', 'end_time', 'date', 'description', 'instructor_name', 'task_number', 'play_address_id', 'play_address_name','makeup_address_id', 'status', 'task_type', 'client_id'];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function makeupAddress() {
        return $this->belongsTo(Address::class, 'makeup_address_id');
    }

    public function playAddress() {
        return $this->belongsTo(Address::class, 'play_address_id');
    }
}
