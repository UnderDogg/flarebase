<?php
namespace Modules\Documents\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class Document extends Model
{
    use Sluggable, Taggable;

    protected $table = 'documents';

    protected $fillable = ['name', 'slug', 'size', 'path', 'file_display', 'fk_relation_id'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function relation()
    {
        $this->belongsTo(Relation::class, 'fk_relation_id');
    }
}
