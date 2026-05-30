<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TipController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $tips = Tip::with('user')->latest()->get();
        return view('tips.index', compact('tips'));
    }

    public function create()
    {
        return view('tips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'match_teams' => 'required|string|max:255',
            'prediction'  => 'required|string|max:255',
            'odds'        => 'required|numeric|min:1.01|max:1000',
            'match_date'  => 'required|date',
        ]);

        $request->user()->tips()->create($validated);

        return redirect('/')->with('success', 'Tip bol pridaný!');
    }

    public function edit(Tip $tip)
    {
        $this->authorize('update', $tip);
        return view('tips.edit', compact('tip'));
    }

    public function update(Request $request, Tip $tip)
    {
        $this->authorize('update', $tip);

        $validated = $request->validate([
            'match_teams' => 'required|string|max:255',
            'prediction'  => 'required|string|max:255',
            'odds'        => 'required|numeric|min:1.01|max:1000',
            'match_date'  => 'required|date',
            'status'      => 'required|in:pending,win,loss,void',
        ]);

        $tip->update($validated);

        return redirect('/')->with('success', 'Tip bol upravený!');
    }

    public function destroy(Tip $tip)
    {
        $this->authorize('delete', $tip);
        $tip->delete();
        return redirect('/')->with('success', 'Tip bol zmazaný!');
    }
}