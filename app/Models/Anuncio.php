<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Anuncio
 * 
 * @property int $ID_Anuncio
 * @property string|null $Titulo
 * @property string|null $Descricao
 * @property float|null $Preco
 * @property int $UtilizadorID_User
 * @property int $AprovacaoID_aprovacao
 * @property int $Tipo_ItemID_Tipo
 * @property int $CategoriaID_Categoria
 * @property int $Status_AnuncioID_Status_Anuncio
 * 
 * @property Aprovacao $aprovacao
 * @property TipoItem $tipo_item
 * @property StatusAnuncio $status_anuncio
 * @property Categorium $categorium
 * @property Utilizador $utilizador
 * @property Collection|Compra[] $compras
 * @property Collection|ItemImagem[] $item_imagems
 * @property Collection|Mensagem[] $mensagems
 * @property Collection|Troca[] $trocas
 *
 * @package App\Models
 */
class Anuncio extends Model
{
    protected $table = 'anuncio';
    protected $primaryKey = 'ID_Anuncio';
    public $timestamps = false;

    protected $casts = [
        'preco' => 'float',
        'UtilizadorID_User' => 'int',
        'AprovacaoID_aprovacao' => 'int',
        'Tipo_ItemID_Tipo' => 'int',
        'Status_AnuncioID_Status_Anuncio' => 'int'
    ];

    protected $fillable = [
        'titulo',
        'descricao',
        'preco',
        'UtilizadorID_User',
        'AprovacaoID_aprovacao',
        'Tipo_ItemID_Tipo',
        'CategoriaID_Categoria',
        'Status_AnuncioID_Status_Anuncio'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Utilizador::class, 'UtilizadorID_User', 'ID_User');
    }

    public function imagens()
    {
        return $this->belongsToMany(Imagem::class, 'item_imagem', 'ItemID_Item', 'ImagemID_Imagem');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'CategoriaID_Categoria', 'ID_Categoria');
    }

    public function tipoItem()
    {
        return $this->belongsTo(TipoItem::class, 'Tipo_ItemID_Tipo', 'ID_Tipo');
    }

    public function status()
    {
        return $this->belongsTo(StatusAnuncio::class, 'Status_AnuncioID_Status_Anuncio', 'ID_Status_Anuncio');
    }

    public function aprovacao()
    {
        return $this->belongsTo(Aprovacao::class, 'AprovacaoID_aprovacao', 'ID_aprovacao');
    }

    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class, 'UtilizadorID_User');
    }

	public function compras()
	{
		return $this->hasMany(Compra::class, 'AnuncioID_Anuncio');
	}

	public function item_imagems()
	{
		return $this->hasMany(ItemImagem::class, 'ItemID_Item');
	}

	public function mensagems()
	{
		return $this->hasMany(Mensagem::class, 'ItemID_Item');
	}

	public function trocas()
	{
		return $this->hasMany(Troca::class, 'ItemID_Solicitado');
	}
}
