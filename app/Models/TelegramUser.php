<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TelegramUser
 * @package App\Models
 *
 * @property int $id
 * @property int $telegram_id
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property string $lang
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TelegramUser extends Model
{
    protected $table = 'telegram_users';
}
