<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'client';
    protected $fillable = ['user_id', 'company_name', 'contact_person_name', 'contact_person_phone_number', 'invoice_email_address', 'invoice_address_id'];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function address() {
        return $this->belongsTo(Address::class, 'invoice_address_id');
    }
    // public function tasks() {
    //     return $this->hasMany(Task::class, 'client_id', 'user_id');
    // }
    
}