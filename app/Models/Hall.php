<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hall extends Model
{
    use HasFactory;

    protected $table = 'hall';
    protected $dates = [
        'start_party',
        'end_party',
        'created_at',
        'updated_at',

    ];


    protected $fillable=['name','address','rooms','chairs','price','hours','tables','type','capacity','available','start_party',
    'end_party','person_id'];





protected function serializeDate(DateTimeInterface $date)
{
    return $date->format('Y-m-d H:i:s');
}

public function getStartPartyAttribute($value)
{
    return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
}

public function setStartPartyAttribute($value)
{
    $this->attributes['start_party'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
}

public function getEndPartyAttribute($value)
{
    return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
}

public function setEndPartyAttribute($value)
{
    $this->attributes['end_party'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
}

public function confirmedBookings()
{
    return $this->hasMany(Booking::class)->where('status', 'confirmed');
}

public function rejectedBookings()
{
    return $this->hasMany(Booking::class)->where('status', 'rejected');
}

public function processingBookings()
{
    return $this->hasMany(Booking::class)->where('status', 'processing');
}

}
