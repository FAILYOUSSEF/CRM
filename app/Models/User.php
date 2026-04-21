<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name','email','password','phone','cin','salaire',
        'date_naissance','date_embauche','rib','addresse','status',
        'type_contrat','fichier_de_contrat','ville','type_client',
    ];
    protected $hidden = ['password','remember_token'];

    // Role helpers
    public function isAdmin()    { return $this->type_client === 'admin'; }
    public function isEmployee() { return $this->type_client === 'employee'; }
    public function isClient()   { return $this->type_client === 'client'; }

    // Relationships
    public function projects()         { return $this->belongsToMany(Project::class, 'user_project'); }
    public function clientProjects()   { return $this->hasMany(Project::class, 'client_id'); }
    public function tasks()            { return $this->hasMany(Task::class, 'employee_id'); }
    public function tickets()          { return $this->hasMany(Ticket::class); }
    public function reclamations()     { return $this->hasMany(Reclamation::class); }
}