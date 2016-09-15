<?php

namespace Modules\Knowledgebase\Models;

use Illuminate\Database\Eloquent\Model;

class Side1 extends Model
{
    protected $table = 'side1';
    protected $fillable = ['title', 'content'];
}
