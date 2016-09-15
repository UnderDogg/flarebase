<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    public $timestamps = false;
    protected $table = 'ticketpriorities';
    protected $fillable = [
        'priority_id', 'priority', 'priority_desc', 'priority_color', 'priority_urgency', 'ispublic',
    ];
}
