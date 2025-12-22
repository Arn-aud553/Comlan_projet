<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Commentaire
 * 
 * @property int $id_commentaire
 * @property string $texte
 * @property int|null $note
 * @property int $id_contenu
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Contenu $contenu
 * @property User $user
 *
 * @package App\Models
 */
class Commentaire extends Model
{
	use HasFactory;
	protected $table = 'commentaires';
	protected $primaryKey = 'id_commentaire';

	protected $casts = [
		'note' => 'int',
		'id_contenu' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'texte',
		'note',
		'id_contenu',
		'user_id',
		'statut'
	];

	public function contenu()
	{
		return $this->belongsTo(Contenu::class, 'id_contenu');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
