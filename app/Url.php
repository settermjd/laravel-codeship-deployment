<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Url
 * @package App
 */
class Url extends Model
{
    /**
     * @var string
     */
    protected $table = 'urls';

    /**
     * @var bool
     */
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
