<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'activity_log';
  protected $fillable = [
    'user_id',
    'text',
    'type',
    'type_id'
  ];
  protected $guarded = ['id'];

  /**
   * Get the user that the activity belongs to.
   *
   * @return object
   */
  public function ticket()
  {
    return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo(Staff::class, 'staff_id', 'id');
  }
}
