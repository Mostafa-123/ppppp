<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'bookings';

    protected $appends = [
        'status_label',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'halls.name',
        'name',
        'status',
    ];

    protected $filterable = [
        'id',
        'halls.name',
        'name',
        'status',
    ];



    protected $fillable = [
        'name',
        'status',

        'created_at',
        'updated_at',

        'halls_id',
    ];

    public const STATUS_SELECT = [
        [
            'label' => 'Processing',
            'value' => 'Processing',
        ],
        [
            'label' => 'Accepted',
            'value' => 'Accepted',
        ],
        [
            'label' => 'Rejected',
            'value' => 'Rejected',
        ],
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function halls()
    {
        return $this->belongsTo(Hall::class);
    }

    public function getStatusLabelAttribute()
    {
        return collect(static::STATUS_SELECT)->firstWhere('value', $this->status)['label'] ?? '';
    }
}
