<?php

namespace Drivezy\LaravelUtility\Models;

use Drivezy\LaravelUtility\LaravelUtility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BaseModel
 * @package Drivezy\LaravelUtility\Models
 */
class BaseModel extends Model
{
    use SoftDeletes;
    use ModelEvaluator;
    use Auditable;

    /**
     * @var array
     */
    public static $hide_columns = [];
    /**
     * @var array
     */
    public static $default_hidden_columns = ['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by'];
    public $class_hash = null;
    public $abort_business_rule = false;
    protected $abort = false;
    /**
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by'];

    /**
     * BaseModel constructor.
     * @param array $attributes
     */
    public function __construct (array $attributes = [])
    {
        $this->class_hash = md5($this->getActualClassNameForMorph($this->getMorphClass()));

        parent::__construct($attributes);
    }

    /**
     * @return BelongsTo
     */
    public function created_user ()
    {
        return $this->belongsTo(LaravelUtility::getUserModelFullQualifiedName(), 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updated_user ()
    {
        return $this->belongsTo(LaravelUtility::getUserModelFullQualifiedName(), 'updated_by');
    }
}
