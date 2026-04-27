<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class Meeting extends Model {
    protected $fillable = [
        'titre','description','date_heure','lieu','type','link','status','created_by',
    ];
    protected $casts = ['date_heure' => 'datetime'];
 
    public function creator()      { return $this->belongsTo(User::class, 'created_by'); }
    public function participants() { return $this->belongsToMany(User::class, 'meeting_user')->withPivot('response'); }
}