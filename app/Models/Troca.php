<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Troca
 * 
 * @property int $ID_Troca
 * @property Carbon|null $DataTroca
 * @property int $ItemID_ItemOferecido
 * @property int $ItemID_Solicitado
 * @property int $Status_TrocaID_Status_Troca
 * 
 * @property Anuncio $anuncio
 * @property StatusTroca $status_troca
 *
 * @package App\Models
 */
class Troca extends Model
{
	protected $table = 'troca';
	protected $primaryKey = 'ID_Troca';
	public $timestamps = false;

	protected $casts = [
		'DataTroca' => 'datetime',
		'ItemID_ItemOferecido' => 'int',
		'ItemID_Solicitado' => 'int',
		'Status_TrocaID_Status_Troca' => 'int'
	];

	protected $fillable = [
		'DataTroca',
		'ItemID_ItemOferecido',
		'ItemID_Solicitado',
		'Status_TrocaID_Status_Troca'
	];

	public function anuncio()
	{
		return $this->belongsTo(Anuncio::class, 'ItemID_Solicitado');
	}

	public function status_troca()
	{
		return $this->belongsTo(StatusTroca::class, 'Status_TrocaID_Status_Troca');
	}
}
