<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = [
        'deadline','description','sujet','message','status',
        'reponce','priorite','project_id','user_id','category_id',
    ];

    public function project()  { return $this->belongsTo(Project::class); }
    public function user()     { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Categorie::class, 'category_id'); }
}