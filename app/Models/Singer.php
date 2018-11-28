<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Singer extends Model
{
    use Notifiable;

    /**
     * Declare table
     *
     * @var string
     */
    protected $table = 'singers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the song of singer.
     */
    public function songs()
    {
        return $this->hasMany(Song::Class);
    }
}
