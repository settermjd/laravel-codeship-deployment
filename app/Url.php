<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = 'urls';
    public $timestamps = true;

    /**
     * Get a more readable created date
     */
    public function formatDate($value)
    {
        if ($value !== '') {
            return Carbon::parse($value)->format('d/m/Y');
        }

        return $value;
    }
}
