<?php
namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class Lead extends Model
{
    use Sluggable, Taggable;

    protected $table = 'leads';

    protected $fillable = [
        'title',
        'slug',
        'note',
        'status_id',
        'assigned_to_staff_id',
        'fk_staff_id_created',
        'fk_relation_id',
        'contact_date',
    ];
    protected $dates = ['contact_date'];

    protected $hidden = ['remember_token'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function assignee()
    {
        return $this->belongsTo(Staff::class, 'assigned_to_staff_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Staff::class, 'fk_staff_id_created');
    }

    public function relationAssignee()
    {
        return $this->belongsTo(Relation::class, 'fk_relation_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'fk_lead_id', 'id');
    }

    // create a virtual attribute to return the days until deadline
    public function getDaysUntilContactAttribute()
    {
        return Carbon\Carbon::now()->startOfDay()->diffInDays($this->contact_date, false);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class, 'type_id', 'id')->where('type', 'lead');
    }
}
