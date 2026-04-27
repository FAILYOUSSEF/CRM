<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class MeetingRequest extends Model {
    protected $fillable = [
        'titre','description','preferred_date','status','requested_by',
    ];
    public function requester() { return $this->belongsTo(User::class, 'requested_by'); }
}
 