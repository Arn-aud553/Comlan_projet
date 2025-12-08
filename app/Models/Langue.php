<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;

    protected $table = 'langues';
    protected $primaryKey = 'id_langue';

    protected $fillable = [
        'nom_langue',
        'code_langue',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    // Relations
    public function contenus()
    {
        return $this->hasMany(Contenu::class, 'id_langue');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'id_langue');
    }

    public function parlers()
    {
        return $this->hasMany(Parler::class, 'id_langue');
    }

    // Relation avec User (maintenant valide puisque id_langue existe dans users)
    public function users()
    {
        return $this->hasMany(User::class, 'id_langue');
    }

    // Méthode pour charger tous les counts sans subquery
    public function loadAllCounts()
    {
        $this->contenus_count = $this->contenus()->count();
        $this->media_count = $this->media()->count();
        $this->users_count = $this->users()->count();
        $this->parlers_count = $this->parlers()->count();
        
        return $this;
    }

    // Accessor pour l'affichage
    public function getNomLangueFormattedAttribute()
    {
        return ucfirst($this->nom_langue);
    }

    // Scope pour recherche
    public function scopeSearch($query, $search)
    {
        return $query->where('nom_langue', 'like', '%' . $search . '%')
                     ->orWhere('code_langue', 'like', '%' . $search . '%')
                     ->orWhere('description', 'like', '%' . $search . '%');
    }
}