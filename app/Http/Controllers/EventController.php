<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index() {
        $events = DB::table('events')->where('approved', false)->orWhere('approved', true)->orderByDesc('event_date')->get();
        return view('events.index', compact('events'));
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'event_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('image')->store('events', 'public');
        DB::table('events')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'image_url' => '/storage/' . $imagePath,
            'approved' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('events.index')->with('success', 'Event submitted for approval.');
    }

    public function pending() {
        $events = DB::table('events')->where('approved', false)->orderByDesc('event_date')->get();
        return view('events.pending', compact('events'));
    }

    public function approve($id) {
        DB::table('events')->where('id', $id)->update(['approved' => true]);
        return back()->with('success', 'Event approved.');
    }

    public function reject($id) {
        DB::table('events')->where('id', $id)->delete();
        return back()->with('success', 'Event rejected and deleted.');
    }

    public function gallery() {
        $events = DB::table('events')->where('approved', true)->orderByDesc('event_date')->get();
        return view('events.gallery', compact('events'));
    }
}
