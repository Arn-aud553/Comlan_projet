<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * Class User
 * 
 * @property int $id
 * @property string $nom_complet
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $sexe
 * @property int|null $age
 * @property string $role
 * @property string $langue
 * @property int|null $id_langue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Langue|null $langueRelation
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'id_langue' => 'int',
        'age' => 'int'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'nom_complet',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'sexe',
        'age',
        'role',
        'langue',
        'id_langue'
    ];

    // Valeurs par défaut
    protected $attributes = [
        'role' => 'visiteur',
        //'langue' => 'fr'
    ];

    // Constantes pour les rôles
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITEUR = 'editeur';
    const ROLE_VISITEUR = 'visiteur';
    
    // Constantes pour le sexe
    const SEXE_MASCULIN = 'M';
    const SEXE_FEMININ = 'F';
    const SEXE_AUTRE = 'Autre';
    
    // Constantes pour les langues
    const LANGUE_FR = 'fr';
    const LANGUE_EN = 'en';
    const LANGUE_FON = 'fon';
    const LANGUE_YOR = 'yor';

    // ========== RELATIONS ==========
    
    // Relation avec Langue (via id_langue)
    public function langueRelation()
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }

    // ========== ACCESSORS ==========
    
    /**
     * Accessor pour nom_complet
     * Retourne nom_complet s'il existe, sinon name
     */
    public function getNomCompletAttribute($value)
    {
        return $value ?? $this->name;
    }

    /**
     * Accessor pour obtenir le libellé du rôle
     */
    public function getRoleLibelleAttribute()
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'Administrateur',
            self::ROLE_EDITEUR => 'Éditeur',
            self::ROLE_VISITEUR => 'Visiteur',
            default => 'Visiteur'
        };
    }

    /**
     * Accessor pour obtenir le libellé du sexe
     */
    public function getSexeLibelleAttribute()
    {
        return match($this->sexe) {
            self::SEXE_MASCULIN => 'Masculin',
            self::SEXE_FEMININ => 'Féminin',
            self::SEXE_AUTRE => 'Autre',
            default => null
        };
    }

    /**
     * Accessor pour obtenir le libellé de la langue
     */
    public function getLangueLibelleAttribute()
    {
        return match($this->langue) {
            self::LANGUE_FR => 'Français',
            self::LANGUE_EN => 'Anglais',
            self::LANGUE_FON => 'Fon',
            self::LANGUE_YOR => 'Yoruba',
            default => 'Français'
        };
    }

    // ========== MUTATORS ==========
    
    /**
     * Mutator pour nom_complet
     * Met aussi à jour name pour la compatibilité
     */
    public function setNomCompletAttribute($value)
    {
        $this->attributes['nom_complet'] = $value;
        // Garder aussi name pour la compatibilité
        if (empty($this->attributes['name'])) {
            $this->attributes['name'] = $value;
        }
    }

    /**
     * Mutator pour le mot de passe (hash automatique)
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // ========== SCOPES ==========
    
    /**
     * Scope pour les administrateurs
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    /**
     * Scope pour les éditeurs
     */
    public function scopeEditeurs($query)
    {
        return $query->where('role', self::ROLE_EDITEUR);
    }

    /**
     * Scope pour les visiteurs
     */
    public function scopeVisiteurs($query)
    {
        return $query->where('role', self::ROLE_VISITEUR);
    }

    /**
     * Scope pour un sexe spécifique
     */
    public function scopeParSexe($query, $sexe)
    {
        return $query->where('sexe', $sexe);
    }

    /**
     * Scope pour une langue spécifique
     */
    public function scopeParLangue($query, $langue)
    {
        return $query->where('langue', $langue);
    }

    // ========== MÉTHODES UTILES ==========
    
    /**
     * Vérifie si l'utilisateur est administrateur
     */
    public function estAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Vérifie si l'utilisateur est éditeur
     */
    public function estEditeur()
    {
        return $this->role === self::ROLE_EDITEUR;
    }

    /**
     * Vérifie si l'utilisateur est visiteur
     */
    public function estVisiteur()
    {
        return $this->role === self::ROLE_VISITEUR;
    }

    /**
     * Obtenir la liste des rôles disponibles
     */
    public static function getRolesDisponibles()
    {
        return [
            self::ROLE_ADMIN => 'Administrateur',
            self::ROLE_EDITEUR => 'Éditeur',
            self::ROLE_VISITEUR => 'Visiteur',
        ];
    }

    /**
     * Obtenir la liste des sexes disponibles
     */
    public static function getSexesDisponibles()
    {
        return [
            self::SEXE_MASCULIN => 'Masculin',
            self::SEXE_FEMININ => 'Féminin',
            self::SEXE_AUTRE => 'Autre',
        ];
    }

    /**
     * Obtenir la liste des langues disponibles
     */
    public static function getLanguesDisponibles()
    {
        return [
            self::LANGUE_FR => 'Français',
            self::LANGUE_EN => 'Anglais',
            self::LANGUE_FON => 'Fon',
            self::LANGUE_YOR => 'Yoruba',
        ];
    }

    /**
     * Générer un mot de passe par défaut basé sur l'email
     */
    public static function genererMotDePasseParDefaut($email)
    {
        return $email . '123'; // ou une autre logique
    }

    /**
     * Créer un utilisateur avec les attributs de base
     */
    public static function creerAvecAttributs(array $attributes)
    {
        // Générer un mot de passe par défaut si non fourni
        if (empty($attributes['password']) && !empty($attributes['email'])) {
            $attributes['password'] = self::genererMotDePasseParDefaut($attributes['email']);
        }
        
        // S'assurer que name est défini si nom_complet est fourni
        if (!empty($attributes['nom_complet']) && empty($attributes['name'])) {
            $attributes['name'] = $attributes['nom_complet'];
        }
        
        // Valeurs par défaut
        if (empty($attributes['role'])) {
            $attributes['role'] = self::ROLE_VISITEUR;
        }
        
        if (empty($attributes['langue'])) {
            $attributes['langue'] = self::LANGUE_FR;
        }
        
        return self::create($attributes);
    }
}