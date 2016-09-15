<?php

namespace Modules\Knowledgebase\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'kb_pages';
    protected $fillable = ['name', 'slug', 'status', 'visibility', 'description'];
}
