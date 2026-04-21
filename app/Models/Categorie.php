<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {
    protected $fillable = ['name','description'];
    public function tickets() { return $this->hasMany(Ticket::class, 'category_id'); }
}