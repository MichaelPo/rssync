<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public $timestamps  = false;
    protected $table = "ingredients";
    protected $fillable = ["i_name", "i_url", "i_id", "i_selected"];
}
