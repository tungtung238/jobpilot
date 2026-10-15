<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'companies_id',
        'date_debut',
        'salaire',
        'address',
    ];

    public function compagnie()
    {
        return $this->belongsTo(Compagnie::class, 'companies_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}