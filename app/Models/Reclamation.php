<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class Reclamation extends Model {
    protected $fillable = [
        'titre','description','date','type','type_other',
        'response','priorite','status','user_id','assigned_to',
    ];
    public function user()       { return $this->belongsTo(User::class); }
    public function assignedTo() { return $this->belongsTo(User::class, 'assigned_to'); }
 
    public function getTypeDisplayAttribute(): string {
        if ($this->type === 'other' && $this->type_other) return $this->type_other;
        return ucfirst($this->type);
    }
}