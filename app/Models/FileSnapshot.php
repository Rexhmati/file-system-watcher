<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * FileSnapshot Model
 * @property int $id
 * @property string $path
 * @property int $last_modified
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FileSnapshot extends Model
{
    protected $fillable = [
        'path',
        'last_modified'
    ];
}
