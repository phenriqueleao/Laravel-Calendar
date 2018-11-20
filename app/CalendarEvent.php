<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $table = 'calendar_events';
    protected $fillable = ['startData', 'endData', 'allDay', 'color', 'title', 'description'];
    protected $hidden = ['id'];
}
