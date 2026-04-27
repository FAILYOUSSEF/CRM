<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
 
class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
 
    protected $fillable = [
        'name','email','password','phone','cin','salaire',
        'date_naissance','date_embauche','rib','addresse','status',
        'type_contrat','fichier_de_contrat','ville','type_client',
    ];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
 
    public function isAdmin()    { return $this->hasRole('admin'); }
    public function isEmployee() { return $this->hasRole('employee'); }
    public function isClient()   { return $this->hasRole('client'); }
 
    public function projects()        { return $this->belongsToMany(Project::class, 'user_project'); }
    public function clientProjects()  { return $this->hasMany(Project::class, 'client_id'); }
    public function tasks()           { return $this->hasMany(Task::class, 'employee_id'); }
    public function tickets()         { return $this->hasMany(Ticket::class); }
    public function reclamations()    { return $this->hasMany(Reclamation::class); }
    public function meetings()        { return $this->belongsToMany(Meeting::class, 'meeting_user')->withPivot('response'); }
    public function createdMeetings() { return $this->hasMany(Meeting::class, 'created_by'); }
    public function meetingRequests() { return $this->hasMany(MeetingRequest::class, 'requested_by'); }
}