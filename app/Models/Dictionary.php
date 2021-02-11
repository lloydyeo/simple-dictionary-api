<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'timestamp',
    ];

    public function getValueAttribute($value) {
        return json_decode($value);
    }

    /**
     * Set the inserted value into JSON
     *
     * @param  string  $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode($value);
    }
}
