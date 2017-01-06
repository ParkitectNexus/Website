<?php


namespace PN\Foundation;


use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    public $timestamps = false;

    protected $fillable = array(
        'value',
    );

    protected $visible = array(
        'key',
        'value',
    );
}