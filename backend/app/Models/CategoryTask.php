<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $task_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTask whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CategoryTask extends Model
{
    use HasFactory;
}
