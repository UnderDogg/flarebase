<?php
namespace Modules\Knowledgebase\Models;


use Baum\Node;

/**
 * KbCategory
 */
class KbCategory extends Node
{

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'kbcategories';


    /**
     * Column name which stores reference to parent's node.
     *
     * @var string
     */
    protected $parentColumn = 'parent_id';

    /**
     * Column name for the left index.
     *
     * @var string
     */
    protected $leftColumn = '_lft';

    /**
     * Column name for the right index.
     *
     * @var string
     */
    protected $rightColumn = '_rgt';

    /**
     * Column name for the depth field.
     *
     * @var string
     */
    protected $depthColumn = 'depth';

    /**
     * Column to perform the default sorting
     *
     * @var string
     */
    protected $orderColumn = null;

    /**
     * With Baum, all NestedSet-related fields are guarded from mass-assignment
     * by default.
     *
     * @var array
     */
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');



    public function parent()
    {
        return $this->hasOne(KbCategory::class, 'parent_id', 'id')->select(array('name'));
    }







}
