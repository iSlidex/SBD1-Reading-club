<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cast_reader extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'SJL_elenco_lectores';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id_fec_mem','id_club', 'id_lec', 'id_pers','id_obra','id_hist_pre','id_local','mej_act'];
}
