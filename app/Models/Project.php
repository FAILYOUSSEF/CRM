<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = [
        'titre','ficher','description','date_duree','date_fin',
        'status','priorite','budget','client_id',
    ];

    public function employees() { return $this->belongsToMany(User::class, 'user_project'); }
    public function client()    { return $this->belongsTo(User::class, 'client_id'); }
    public function tasks()     { return $this->hasMany(Task::class); }
    public function tickets()   { return $this->hasMany(Ticket::class); }
}
