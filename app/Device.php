<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table = 'devices';

    protected $fillable = [
        'device_serial_number',
        'device_make',
        'device_friendly_name',
        'device_id',
        'status',
        'cardknox_api_key',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
