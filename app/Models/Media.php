<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $primaryKey = 'id_media';
    public $timestamps = true;

    protected $casts = [
        'id_contenu'      => 'int',
        'id_utilisateur'  => 'int',
        'taille_fichier'  => 'int',
        'prix'            => 'decimal:2',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    protected $fillable = [
        'nom_fichier',
        'titre',
        'description',
        'chemin_fichier',
        'type_fichier',
        'extension',
        'taille_fichier',
        'mime_type',
        'prix',
        'id_contenu',
        'id_utilisateur',
    ];

    protected $appends = [
        'url',
        'taille_formattee',
        'prix_formate',
        'est_payant',
        'id',
        'type_formate',
        'est_accessible',
    ];

    /**
     * Pour route model binding (Laravel)
     */
    public function getRouteKeyName()
    {
        return 'id_media';
    }

    /**
     * Compatibilité $media->id
     */
    public function getIdAttribute()
    {
        return $this->id_media;
    }

    /* ===========================
     *        RELATIONS
     * ===========================
     */

    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function auteur()
    {
        return $this->utilisateur();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'media_id', 'id_media');
    }

    /* ===========================
     *      ACCESSORS
     * ===========================
     */

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->chemin_fichier);
    }

    public function getTailleFormatteeAttribute()
    {
        if (!$this->taille_fichier) return 'N/A';

        $bytes = $this->taille_fichier;
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;

        return round($bytes / pow(1024, $power), 2) . ' ' . $units[$power];
    }

    public function getPrixFormateAttribute()
    {
        if (!$this->prix || $this->prix == 0) {
            return 'Gratuit';
        }

        return number_format($this->prix, 0, ',', ' ') . ' FCFA';
    }

    public function getEstPayantAttribute()
    {
        return $this->prix > 0;
    }

    public function getTypeFormateAttribute()
    {
        return [
            'image'    => 'Image',
            'video'    => 'Vidéo',
            'audio'    => 'Audio',
            'document' => 'Document',
            'livre'    => 'Livre',
        ][$this->type_fichier] ?? ucfirst($this->type_fichier);
    }

    public function getEstAccessibleAttribute()
    {
        return $this->accesAutorise();
    }

    /* ===========================
     *         MÉTHODES
     * ===========================
     */

    public function estPayeParUtilisateur($userId = null)
    {
        $userId = $userId ?: auth()->id();

        if (!$userId) {
            return false;
        }

        return $this->paiements()
            ->where('user_id', $userId)
            ->where('statut', 'completed')
            ->exists();
    }

    public function accesAutorise($userId = null)
    {
        if ($this->isGratuit()) {
            return true;
        }

        return $this->estPayeParUtilisateur($userId);
    }

    public function getPrixOuDefaut()
    {
        return $this->prix ?: config('fedapay.default_amount', 1000);
    }

    public function acheter($userId = null, $montant = null)
    {
        $userId = $userId ?: auth()->id();

        if (!$userId) {
            throw new \Exception('Utilisateur non connecté');
        }

        return Paiement::create([
            'user_id'  => $userId,
            'media_id' => $this->id_media,
            'montant'  => $montant ?: $this->getPrixOuDefaut(),
            'statut'   => 'pending',
        ]);
    }

    /* ===========================
     *        SCOPES
     * ===========================
     */

    public function scopeImages($query)
    {
        return $query->where('type_fichier', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type_fichier', 'video');
    }

    public function scopeDocuments($query)
    {
        return $query->where('type_fichier', 'document');
    }

    public function scopeLivres($query)
    {
        return $query->where('type_fichier', 'livre');
    }

    public function scopePayants($query)
    {
        return $query->where('prix', '>', 0);
    }

    public function scopeGratuits($query)
    {
        return $query->where(function ($q) {
            $q->where('prix', 0)->orWhereNull('prix');
        });
    }

    /* ===========================
     *  HELPERS SIMPLIFIÉS
     * ===========================
     */

    public function isImage()    { return $this->type_fichier === 'image'; }
    public function isVideo()    { return $this->type_fichier === 'video'; }
    public function isAudio()    { return $this->type_fichier === 'audio'; }
    public function isDocument() { return $this->type_fichier === 'document'; }
    public function isLivre()    { return $this->type_fichier === 'livre'; }

    public function isPayant()   { return $this->prix > 0; }
    public function isGratuit()  { return !$this->isPayant(); }
}
