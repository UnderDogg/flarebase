<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_source extends Model
{
    public $timestamps = false;
    protected $table = 'ticket_sources';
    protected $fillable = [
        'name', 'value',
    ];
}
