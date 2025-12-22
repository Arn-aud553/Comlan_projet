<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Region
 * 
 * @property int $id_region
 * @property string $nom_region
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Contenu[] $contenus
 *
 * @package App\Models
 */
class Region extends Model
{
	use HasFactory;
	protected $table = 'regions';
	protected $primaryKey = 'id_region';

	protected $fillable = [
		'nom_region',
		'description'
	];

	public function contenus()
	{
		return $this->hasMany(Contenu::class, 'id_region');
	}
}
