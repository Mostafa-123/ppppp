<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class halls extends Model
{
    use HasFactory;

    protected $table = 'halls';
    protected $fillable=['name','address','rooms','chairs','price','hours','tables','type','capacity','available','person_id'];

}
