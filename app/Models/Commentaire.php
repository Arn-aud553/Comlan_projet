<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commentaire
 * 
 * @property int $id_commentaire
 * @property string $texte
 * @property int|null $note
 * @property int $id_contenu
 * @property int|null $id_utilisateur
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Contenu $contenu
 * @property Utilisateur|null $utilisateur
 *
 * @package App\Models
 */
class Commentaire extends Model
{
	protected $table = 'commentaires';
	protected $primaryKey = 'id_commentaire';

	protected $casts = [
		'note' => 'int',
		'id_contenu' => 'int',
		'id_utilisateur' => 'int'
	];

	protected $fillable = [
		'texte',
		'note',
		'id_contenu',
		'id_utilisateur'
	];

	public function contenu()
	{
		return $this->belongsTo(Contenu::class, 'id_contenu');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}
}
