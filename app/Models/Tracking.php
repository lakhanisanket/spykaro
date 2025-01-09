<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tracking extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    public $table = 'tracking';

    protected $appends = [
        'file',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'device_id',
    ];

    public $orderable = [
        'id',
        'user.name',
        'type',
        'data',
        'device.name',
    ];

    public $filterable = [
        'id',
        'user.name',
        'type',
        'data',
        'device.name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'voice'    => 'Voice',
        'camera'   => 'Camera',
        'location' => 'Location',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function getTypeLabelAttribute($value)
    {
        return static::TYPE_SELECT[$this->type] ?? null;
    }

    public function getFileAttribute()
    {
        return $this->getMedia('tracking_file')->map(function ($item) {
            $media        = $item->toArray();
            $media['url'] = $item->getUrl();

            return $media;
        });
    }

    public static $withoutAppends = false;

    public function scopeWithoutAppends($query)
    {
        self::$withoutAppends = true;

        return $query;
    }

    protected function getArrayableAppends()
    {
        if (self::$withoutAppends){
            return [];
        }

        return parent::getArrayableAppends();
    }

    public function file()
    {
        return $this->hasMany(\App\Models\Media::class, 'model_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.datetime_format')) : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.datetime_format')) : null;
    }

    public function getDeletedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.datetime_format')) : null;
    }
}
