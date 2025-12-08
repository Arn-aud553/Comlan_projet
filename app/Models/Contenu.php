<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;

    protected $table = 'contenus';
    protected $primaryKey = 'id_contenu';

    protected $fillable = [
        'titre',
        'description',
        'id_langue',
        'id_region',
        'id_auteur',
        'is_active',
        'is_supprimer',
        'date_publication',
    ];

    /**
     * Relations obligatoires
     */

    // ✔ Relation avec Langue
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue', 'id_langue');
    }

    // ✔ Relation avec Région
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }

    // ✔ Relation avec l’auteur (table users)
    public function auteur()
    {
        return $this->belongsTo(User::class, 'id_auteur', 'id');
    }

    // ✔ Relation avec les médias liés au contenu
    public function media()
    {
        return $this->hasMany(Media::class, 'id_contenu', 'id_contenu');
    }
}
