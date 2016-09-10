<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
    'note',
    'status_id',
    'fk_lead_id',
    'fk_staff_id'
    ];
    protected $hidden = ['remember_token'];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'fk_lead_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(Staff::class, 'fk_staff_id', 'id');
    }
}
