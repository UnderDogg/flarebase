<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'size', 'path', 'file_display', 'fk_relation_id'];

  public function relations()
    {
    $this->belongsTo(Relation::class, 'fk_relation_id');
    }
}
