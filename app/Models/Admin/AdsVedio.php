<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsVedio extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_ads',
    ];

    protected $appends = ['video_url'];


    public function getVideoUrlAttribute()
    {
        return asset('assets/img/video_ads/'.$this->video_ads);
    }
}
