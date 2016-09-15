<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notification';
    protected $fillable = [

            'notification_id', 'user_id', 'is_read',
                            ];
}
