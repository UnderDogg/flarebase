<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'model_id', 'userid_created', 'type_id',
    ];
}
