<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use Notifiable;

    /**
     * Declare table
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'song_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the users of favorites.
     */
    public function users()
    {
        return $this->hasMany(User::Class);
    }

    /**
     * Get the songs of favorites.
     */
    public function songs()
    {
        return $this->hasMany(Song::Class);
    }
}
