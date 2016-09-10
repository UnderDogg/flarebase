<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
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
