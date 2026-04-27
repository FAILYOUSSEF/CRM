<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingRequest;
use Illuminate\Http\Request;
 
class MeetingController extends Controller {
    public function index(Request $request) {
        $q = auth()->user()->meetings()->with('creator');
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        $meetings = $q->latest()->paginate(15)->withQueryString();
        return view('client.meetings.index', compact('meetings'));
    }
    public function show(Meeting $meeting) {
        return view('client.meetings.show', compact('meeting'));
    }
    public function respond(Request $request, Meeting $meeting) {
        $request->validate(['response'=>'required|in:accepted,refused']);
        $meeting->participants()->updateExistingPivot(auth()->id(), ['response'=>$request->response]);
        return back()->with('success','Response recorded.');
    }
    public function requestMeeting() {
        return view('client.meetings.request');
    }
    public function storeRequest(Request $request) {
        $data = $request->validate([
            'titre'=>'required','description'=>'nullable','preferred_date'=>'nullable|date',
        ]);
        $data['requested_by'] = auth()->id();
        $data['status']       = 'pending';
        MeetingRequest::create($data);
        return redirect()->route('client.meetings.index')->with('success','Meeting request submitted.');
    }
}
 