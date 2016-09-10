<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    protected $table = 'ticket_statusses';
    protected $fillable = [
        'id', 'name', 'state', 'message', 'mode', 'flag', 'sort', 'properties',
    ];
}
