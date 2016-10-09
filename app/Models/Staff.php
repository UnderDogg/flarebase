<?php

namespace App\Models;

use App\Notifications\StaffResetPassword;
use Fenos\Notifynder\Notifable;
use Illuminate\Notifications\Notifiable;
use Cache;
use Modules\Core\Models\RoleStaff;
use Modules\Core\Models\Department;
use Modules\Tickets\Models\Ticket;
use Modules\Relations\Models\Relation;
use Modules\Leads\Models\Lead;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;


/*
 *  This class is needed for staff users to log in.
 *  Why is it not in another namespace? Don't know yet. That's todo
 *  I'll pull all the other models from the correct namespace
 *
 **/
class Staff extends Authenticatable
{

    use Notifiable, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "staff";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_me_token',
    ];

    protected $primaryKey = 'id';


    public function role()
    {
        return $this->hasOne(RoleStaff::class, 'staff_id', 'id');
    }

    public function ticketsAssign()
    {
        return $this->hasMany(Ticket::class, 'fk_staff_id_assign', 'id')
            ->where('status_id', 1)
            ->orderBy('deadline', 'asc');
    }

    public function ticketsCreated()
    {
        return $this->hasMany(Ticket::class, 'fk_staff_id_created', 'id')->limit(10);
    }

    public function ticketsCompleted()
    {
        return $this->hasMany(Ticket::class, 'fk_user_id_assign', 'id')->where('status', 2);
    }

    public function ticketsAll()
    {
        return $this->hasMany(Ticket::class, 'fk_staff_id_assign', 'id')->whereIn('status_id', [1, 2]);
    }

    public function leadsAll()
    {
        return $this->hasMany(Lead::class, 'fk_staff_id', 'id');
    }

    public function settings()
    {
        return $this->belongsTo(Settings::class);
    }

    public function relationsAssign()
    {
        return $this->hasMany(Relation::class, 'fk_staff_id', 'id');
    }

    public function userRole()
    {
        return $this->hasOne(RoleStaff::class, 'staff_id', 'id');
    }

    public function department()
    {
        return $this->belongsToMany(Department::class, 'department_staff');
    }

    public function departmentOne()
    {
        return $this->belongsToMany(Department::class, 'department_staff')->withPivot('department_id');
    }

    public function isOnline()
    {
        return Cache::has('staff-is-online-' . $this->id);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StaffResetPassword($token));
    }
}
