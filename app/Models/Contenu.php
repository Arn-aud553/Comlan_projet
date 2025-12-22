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
        'texte',
        'id_langue',
        'id_region',
        'id_auteur',
        'is_active',
        // 'is_supprimer', // Colonne non existante en base
        'date_publication',
        'prix',
        'id_type_contenu',
        'statut',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_supprimer' => 'boolean',
        'date_publication' => 'datetime',
        'prix' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relations
     */

    // Relation avec Langue
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue', 'id_langue');
    }

    // Relation avec Région
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }

    // Relation avec l'auteur (table users)
    public function auteur()
    {
        return $this->belongsTo(User::class, 'id_auteur', 'id');
    }

    // Relation avec TypeContenu
    public function typeContenu()
    {
        return $this->belongsTo(TypeContenu::class, 'id_type_contenu', 'id_type_contenu');
    }

    // Relation avec les médias
    public function media()
    {
        return $this->hasMany(Media::class, 'id_contenu', 'id_contenu');
    }

    // Relation avec les commentaires
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_contenu', 'id_contenu');
    }

    // Relation avec les paiements
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'contenu_id', 'id_contenu');
    }

    /**
     * Accesseurs et mutateurs
     */

    // Accesseur pour le statut (compatibilité avec l'ancien code)
    public function getStatutAttribute()
    {
        return $this->attributes['statut'] ?? 'en attente';
    }

    // Accesseur pour la date de création
    public function getDateCreationAttribute()
    {
        return $this->created_at ?? $this->date_publication;
    }

    // Accesseur pour description (alias de texte pour compatibilité)
    public function getDescriptionAttribute()
    {
        return $this->texte;
    }

    // Accesseur pour le texte (déjà existant)
    public function getTexteAttribute()
    {
        return $this->attributes['texte'] ?? '';
    }

    // Mutateur pour le texte (nettoyage HTML)
    public function setTexteAttribute($value)
    {
        $this->attributes['texte'] = strip_tags($value);
    }

    // Mutateur pour description (redirige vers texte)
    public function setDescriptionAttribute($value)
    {
        $this->attributes['texte'] = strip_tags($value);
    }

    /**
     * Scopes
     */

    // Scope pour les contenus actifs
    public function scopeActive($query)
    {
        return $query->where('statut', 'publie');
    }

    // Scope pour les contenus gratuits
    public function scopeGratuit($query)
    {
        return $query->where('prix', '<=', 0);
    }

    // Scope pour les contenus payants
    public function scopePayant($query)
    {
        return $query->where('prix', '>', 0);
    }

    // Scope pour les contenus par statut
    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Méthodes utilitaires
     */

    // Vérifier si le contenu est gratuit
    public function estGratuit()
    {
        return $this->prix <= 0;
    }

    // Vérifier si le contenu est publié
    public function estPublie()
    {
        return $this->statut === 'publie';
    }

    // Récupérer l'image principale
    public function imagePrincipale()
    {
        return $this->media()->whereIn('type_fichier', ['image', 'photo'])->first();
    }


    // Récupérer tous les fichiers multimédias
    public function fichiersMultimedia()
    {
        return $this->media()->where('type_fichier', '!=', 'image')->get();
    }

    // Vérifier si l'utilisateur a payé pour ce contenu
    public function estPayeParUtilisateur($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        if (!$userId) {
            return false;
        }

        // Si le contenu est gratuit, retourner true
        if ($this->estGratuit()) {
            return true;
        }

        // Vérifier si l'utilisateur a un paiement complété pour ce contenu
        return $this->paiements()
            ->where('user_id', $userId)
            ->where('statut', 'completed')
            ->exists();
    }

    /**
     * Récupérer les types de médias uniques pour ce contenu
     */
    public function getTypesMediaDisponibles()
    {
        return $this->media->pluck('type_fichier')->unique()->map(function($type) {
            return strtolower($type);
        })->toArray();
    }
}