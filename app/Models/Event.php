<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'kind',
      'user_id',
      'information',
      'max_people',
      'start_date',
      'end_date',
      'is_visible'
    ];

    public function users()
    {
      return $this->belongsToMany(User::class)
      ->withPivot('id', 'number_of_people', 'canceled_date');
    }

}
