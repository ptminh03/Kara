<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use Notifiable;

    // CONST
    const PATH_SONG = '/test/public/song';

    /**
     * Declare table
     *
     * @var string
     */
    protected $table = 'songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'singer_id', 'play_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the singer of song.
     */
    public function singers()
    {
        return $this->hasOne(Singer::Class);
    }

    /**
     * Get the category of song.
     */
    public function categories()
    {
        return $this->hasOne(Category::Class);
    }
}
