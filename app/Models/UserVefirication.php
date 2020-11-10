<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserVefirication
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $hash
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserVefirication extends Model
{
    use HasFactory;

    protected $table = 'user_verifications';
}
