<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;
    protected $table = 'ADMINISTRATEUR';
    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public $timestamps = false;
    protected $primaryKey = 'Num_Adm';
}
