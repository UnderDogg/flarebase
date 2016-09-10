<?php
namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class Invoice extends Model
{
    use Taggable;

    protected $table = 'invoices';

    protected $fillable = [
        'received',
        'sent',
        'payment_date'
    ];

    public function relations()
    {
        return $this->belongsToMany(Relation::class);
    }

    public function tickettime()
    {
        return $this->belongsToMany(TicketTime::class);
    }
}
