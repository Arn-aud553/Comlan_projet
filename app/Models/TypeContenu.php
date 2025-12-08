<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContenu extends Model
{
    use HasFactory;
    
    protected $table = 'type_contenus';
    protected $primaryKey = 'id_type_contenu';

    protected $fillable = [
        'nom'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function contenus()
    {
        return $this->hasMany(Contenu::class, 'id_type_contenu');
    }

    // Accessor pour l'affichage
    public function getNomFormattedAttribute()
    {
        return ucfirst($this->nom);
    }

    // Scope pour recherche
    public function scopeSearch($query, $search)
    {
        return $query->where('nom', 'like', '%' . $search . '%');
    }
}