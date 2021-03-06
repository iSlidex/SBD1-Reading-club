<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sjl_subgeneros';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id_gen', 'id_lib'];
}
