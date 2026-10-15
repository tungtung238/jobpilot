<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $candidates = Candidate::with('user')->get();
        } else {
            abort_unless($user->role === 'candidate', 403);

            $candidates = Candidate::where('user_id', $user->id)->get();
        }

        return view('candidate.index', compact('candidates'));
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        return view('candidate.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'unique:candidates,user_id'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ]);

        Candidate::create($validated);

        return redirect()
            ->route('candidate.index')
            ->with('success', 'Candidate ajouté avec succès.');
    }

    public function show(Candidate $candidate)
    {
        $this->authorizeCandidate($candidate);

        return view('candidate.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $this->authorizeCandidate($candidate);

        return view('candidate.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $this->authorizeCandidate($candidate);

        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ]);

        $candidate->update($validated);

        return redirect()
            ->route('candidate.index')
            ->with('success', 'Profil mis à jour.');
    }

    public function destroy(Candidate $candidate)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $candidate->delete();

        return redirect()
            ->route('candidate.index')
            ->with('success', 'Candidate supprimé.');
    }

    private function authorizeCandidate(Candidate $candidate): void
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'admin'
            || ($user->role === 'candidate' && $candidate->user_id === $user->id),
            403
        );
    }
}
