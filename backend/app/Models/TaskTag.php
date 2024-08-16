<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $task_id
 * @property int $tag_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskTag extends Model
{
    use HasFactory;
}
