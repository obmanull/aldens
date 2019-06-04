<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Entities\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entities\Category[] $children
 * @property-read \App\Entities\Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entities\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entities\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entities\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Category whereSlug($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use NodeTrait;

    public $timestamps = false;
    public $fillable = ['name', 'parent_id', 'slug'];

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }

    public function parentAttributes(): array
    {
        return $this->parent ? $this->parent->allAttributes() : [];
    }

    public function allAttributes(): array
    {
        return array_merge($this->parentAttributes(), $this->attributes()->orderBy('sort')->getModels());
    }
}
