<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class Help_topic extends Model
{
    protected $table = 'helptopics';
    protected $fillable = [
        'id', 'topic', 'parent_topic', 'custom_form', 'department', 'ticket_status', 'priority',
        'sla_plan', 'thank_page', 'ticket_num_format', 'internal_notes', 'status', 'type', 'auto_assign',
        'auto_response',
    ];
}
