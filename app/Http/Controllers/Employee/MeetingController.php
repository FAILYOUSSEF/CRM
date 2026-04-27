<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
 
class MeetingController extends Controller {
    public function index(Request $request) {
        $q = auth()->user()->meetings()->with('creator');
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        $meetings = $q->latest()->paginate(15)->withQueryString();
        return view('employee.meetings.index', compact('meetings'));
    }
    public function respond(Request $request, Meeting $meeting) {
        $request->validate(['response'=>'required|in:accepted,refused']);
        $meeting->participants()->updateExistingPivot(auth()->id(), ['response'=>$request->response]);
        return back()->with('success','Response recorded.');
    }
}