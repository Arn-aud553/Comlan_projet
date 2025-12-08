<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Utilisateur
 *
 * @property int $id_utilisateur
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string $mot_de_passe
 * @property string|null $sexe
 * @property string $statut
 * @property Carbon $date_inscription
 * @property int|null $id_langue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Langue|null $langue
 * @property Collection|Commentaire[] $commentaires
 * @property Collection|Contenu[] $contenus
 * @property Collection|Media[] $media
 * @property Collection|Parler[] $parlers
 *
 * @package App\Models
 */
class Utilisateur extends Model
{
	protected $table = 'utilisateurs';
	protected $primaryKey = 'id_utilisateur';

	protected $casts = [
		'date_inscription' => 'datetime',
		'id_langue' => 'int'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'email',
		'mot_de_passe',
		'sexe',
		'statut',
		'date_inscription',
		'id_langue'
	];

	/**
	 * Hide sensitive attributes
	 */
	protected $hidden = [
		'mot_de_passe'
	];

	/**
	 * Contenus dont l'utilisateur est l'auteur
	 */
	public function contenusAuthored()
	{
		return $this->hasMany(Contenu::class, 'id_auteur');
	}

	/**
	 * Contenus dont l'utilisateur est le modérateur
	 */
	public function contenusModeres()
	{
		return $this->hasMany(Contenu::class, 'id_moderateur');
	}

	public function langue()
	{
		return $this->belongsTo(Langue::class, 'id_langue');
	}

	public function commentaires()
	{
		return $this->hasMany(Commentaire::class, 'id_utilisateur');
	}

	public function contenus()
	{
		return $this->hasMany(Contenu::class, 'id_moderateur');
	}

	public function media()
	{
 		return $this->hasMany(Media::class, 'id_utilisateur');
	}

	public function parlers()
	{
		return $this->hasMany(Parler::class, 'id_utilisateur');
	}
}
