<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Relations\Models\Relation;
use Modules\Core\Models\Staff;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class Ticket extends Model
{
    use Taggable;

    protected $table = 'tickets';


    /*
    `id` int(10) UNSIGNED NOT NULL,
    `ticket_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `dept_id` int(11) NOT NULL,
    `team_id` int(11) NOT NULL,
    `priority_id` int(11) NOT NULL,
    `status_id` int(11) NOT NULL,
    `source_id` int(11) NOT NULL,
    `reported_by_id` int(11) NOT NULL,
    `updated_by_id` int(11) NOT NULL,
    `assigned_to_staff_id` int(10) UNSIGNED NOT NULL,
    `sla_id` int(11) NOT NULL,
    `help_topic_id` int(11) NOT NULL,
    `hashtml` tinyint(1) NOT NULL,
    `isdeleted` tinyint(1) NOT NULL,
    `isclosed` tinyint(1) NOT NULL,
    `isreopened` tinyint(1) NOT NULL,
    `reopened_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `isanswered` tinyint(1) NOT NULL,
    `is_transferred` tinyint(1) NOT NULL,
    `transferred_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `closed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `last_message_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `last_response_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `user_id` int(10) UNSIGNED NOT NULL,
    `fk_relation_id` int(10) UNSIGNED NOT NULL,
     **/


    protected $fillable = [
        'ticket_number',
        'subject',
        'deadline'
    ];

    protected $dates = ['reopened_at', 'deadline', 'transferred_at', 'closed_at', 'last_message_at', 'last_response_at', 'created_at', 'updated_at'];

    public function assignee()
    {
        return $this->belongsTo(Staff::class, 'assigned_to_staff_id');
    }

    public function relationAssignee()
    {
        return $this->belongsTo(Relation::class, 'fk_relation_id');
    }

    public function ticketCreator()
    {
        return $this->belongsTo(Staff::class, 'fk_staff_id_created');
    }

    public function thread()
    {
        return $this->hasMany(TicketThread::class, 'ticket_id', 'id');
    }

    // create a virtual attribute to return the days until deadline
    public function getDaysUntilDeadlineAttribute()
    {
        return Carbon\Carbon::now()
            ->startOfDay()
            ->diffInDays($this->deadline, false); // if you are past your deadline, the value returned will be negative.
    }

    public function settings()
    {
        return $this->hasMany(Settings::class);
    }

    public function time()
    {
        return $this->hasOne(TicketTime::class, 'fk_ticket_id', 'id');
    }

    public function allTime()
    {
        return $this->hasMany(TicketTime::class, 'fk_ticket_id', 'id');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class, 'type_id', 'id')->where('type', 'ticket');
    }
}
