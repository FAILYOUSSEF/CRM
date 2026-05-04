<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingRequest;
use App\Models\User;
use Illuminate\Http\Request;
 
class MeetingController extends Controller {
    public function __construct() {
        $this->middleware('permission:meeting-list',   ['only' => ['index', 'show']]);
        $this->middleware('permission:meeting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meeting-edit',   ['only' => ['edit', 'update', 'acceptRequest', 'refuseRequest']]);
        $this->middleware('permission:meeting-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        $q = Meeting::with('creator','participants');
        if ($request->search) $q->where('titre','like',"%{$request->search}%");
        if ($request->status) $q->where('status',$request->status);
        $meetings = $q->latest()->paginate(15)->withQueryString();
        $requests = MeetingRequest::with('requester')->where('status','pending')->latest()->get();
        return view('admin.meetings.index', compact('meetings','requests'));
    }
    public function create() {
        $users = User::whereIn('type_client',['employee','client'])->get();
        return view('admin.meetings.create', compact('users'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'titre'=>'required','description'=>'nullable',
            'date_heure'=>'required|date','lieu'=>'nullable',
            'type'=>'required|in:online,presentiel',
            'link'=>'nullable','participants'=>'required|array',
        ]);
        $data['created_by'] = auth()->id();
        $data['status'] = 'planifié';
        $meeting = Meeting::create($data);
        $participants = array_fill_keys($request->participants, ['response'=>'pending']);
        $meeting->participants()->sync($participants);
        return redirect()->route('admin.meetings.index')->with('success','Meeting created.');
    }
    public function show(Meeting $meeting) {
        $meeting->load('creator','participants');
        return view('admin.meetings.show', compact('meeting'));
    }
    public function edit(Meeting $meeting) {
        $users = User::whereIn('type_client',['employee','client'])->get();
        $current = $meeting->participants->pluck('id')->toArray();
        return view('admin.meetings.edit', compact('meeting','users','current'));
    }
    public function update(Request $request, Meeting $meeting) {
        $data = $request->validate([
            'titre'=>'required','description'=>'nullable',
            'date_heure'=>'required|date','lieu'=>'nullable',
            'type'=>'required|in:online,presentiel',
            'link'=>'nullable','status'=>'required|in:planifié,annulé,terminé',
            'participants'=>'nullable|array',
        ]);
        $meeting->update($data);
        $participants = array_fill_keys($request->participants ?? [], ['response'=>'pending']);
        $meeting->participants()->sync($participants);
        return redirect()->route('admin.meetings.index')->with('success','Meeting updated.');
    }
    public function destroy(Meeting $meeting) {
        $meeting->delete();
        return redirect()->route('admin.meetings.index')->with('success','Meeting deleted.');
    }
    public function acceptRequest(MeetingRequest $meetingRequest) {
        // Create a meeting from the request
        $meeting = Meeting::create([
            'titre' => $meetingRequest->titre,
            'description' => $meetingRequest->description,
            'date_heure' => $meetingRequest->preferred_date ?? now()->addDays(7),
            'type' => 'online',
            'status' => 'planifié',
            'created_by' => auth()->id(),
        ]);
        
        // Add the requester as a participant
        $meeting->participants()->sync([$meetingRequest->requested_by => ['response' => 'pending']]);
        
        // Update the request status
        $meetingRequest->update(['status' => 'accepted']);
        
        return back()->with('success', 'Meeting request accepted and meeting scheduled.');
    }
    public function refuseRequest(MeetingRequest $meetingRequest) {
        $meetingRequest->update(['status'=>'refused']);
        return back()->with('success','Request refused.');
    }
}