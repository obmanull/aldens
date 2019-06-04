<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Attribute
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $type
 * @property int $required
 * @property mixed $variants
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Attribute whereVariants($value)
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';

    protected $table = 'category_attributes';

    public $timestamps = false;

    protected $fillable = ['name', 'type', 'required', 'variants', 'sort'];

    protected $casts = ['variants' => 'array'];

    public static function typesList(): array
    {
        return [
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_FLOAT => 'Float',
        ];
    }

    public function isString()
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger()
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat()
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function isSelect()
    {
        return \count($this->variants) > 0;
    }
}
