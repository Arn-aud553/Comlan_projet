<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Parler
 *
 * @property int $id_utilisateur
 * @property int $id_langue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Langue $langue
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class Parler extends Model
{
	use HasFactory;
	protected $table = 'parler';
	protected $primaryKey = null;
	public $incrementing = false;
	public $timestamps = true;

	protected $fillable = [
		'id_utilisateur',
		'id_langue'
	];

	protected $casts = [
		'id_utilisateur' => 'int',
		'id_langue' => 'int'
	];

	public function langue()
	{
		return $this->belongsTo(Langue::class, 'id_langue');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}
}
