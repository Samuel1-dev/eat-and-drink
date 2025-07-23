<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stand_id',
        'details_commande',
    ];

    /**
     * Une commande appartient à un stand.
     */
    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }
}