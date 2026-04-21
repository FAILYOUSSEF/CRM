<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
    protected $fillable = [
        'titre','description','date_debut','duree','priorite',
        'status','date_fin','commentaire','employee_id','project_id',
    ];

    public function employee() { return $this->belongsTo(User::class, 'employee_id'); }
    public function project()  { return $this->belongsTo(Project::class); }
}