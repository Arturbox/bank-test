<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';

    public $fillable = [
        'from_user_id',
        'to_user_id',
        'from_account_id',
        'to_account_id',
        'currency',
        'amount',
    ];





}