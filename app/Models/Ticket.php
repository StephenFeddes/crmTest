<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $table = 'ticket';
    
    public $timestamps = true;

    protected $fillable = [
        'ticket_id',
        'title_title',
        'assigned_to_id',
        'ticket_status',
        'ticket_priority',
        'ticket_description'
    ];
}