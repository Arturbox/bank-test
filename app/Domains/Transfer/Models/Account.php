<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $balance
 */
class Account extends Model
{
    protected $table = 'accounts';

    public $fillable = [
        'currency',
        'balance',
    ];

}