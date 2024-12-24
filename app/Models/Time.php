<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
class Time extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'times';

    // Define the fillable properties for mass assignment
    protected $fillable = [
        'medicine_id',
        'time',
    ];

    // Define the relationship to the Medicine model
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    
}
