<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class Project extends Model {
    protected $fillable = [
        'titre','ficher','description','date_debut','date_fin',
        'status','priorite','budget','progress','client_id',
    ];
 
    public function employees() { return $this->belongsToMany(User::class, 'user_project'); }
    public function client()    { return $this->belongsTo(User::class, 'client_id'); }
    public function tasks()     { return $this->hasMany(Task::class); }
    public function tickets()   { return $this->hasMany(Ticket::class); }
 
    public function getProgressColorAttribute(): string {
        if ($this->progress >= 75) return 'emerald';
        if ($this->progress >= 40) return 'amber';
        return 'red';
    }
}