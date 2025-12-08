<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'media_id',
        'contenu_id', // Ajouter ce champ
        'montant',
        'statut',
        'transaction_id',
        'payment_method',
        'payment_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id_media');
    }

    // Ajouter cette relation
    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'contenu_id', 'id_contenu');
    }

    // Scope pour les paiements complétés
    public function scopeCompleted($query)
    {
        return $query->where('statut', 'completed');
    }

    // Scope pour les paiements en attente
    public function scopePending($query)
    {
        return $query->where('statut', 'pending');
    }
}