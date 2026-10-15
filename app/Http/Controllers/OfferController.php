<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'candidate'], true)) {
            $offers = Offer::with('company')->latest()->get();
        } else {
            abort_unless($user->role === 'entreprise', 403);

            $company = Company::where('user_id', $user->id)->first();

            $offers = $company
                ? Offer::where('companies_id', $company->id)
                    ->with('company')
                    ->latest()
                    ->get()
                : collect();
        }

        return view('offer.index', compact('offers'));
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'entreprise', 403);

        return view('offer.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'entreprise', 403);

        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_debut' => ['required', 'date'],
            'salaire' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $validated['companies_id'] = $company->id;

        Offer::create($validated);

        return redirect()
            ->route('offer.index')
            ->with('success', 'Offre ajoutée avec succès.');
    }

    public function show(Offer $offer)
    {
        return view('offer.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        $this->authorizeOffer($offer);

        return view('offer.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $this->authorizeOffer($offer);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_debut' => ['required', 'date'],
            'salaire' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $offer->update($validated);

        return redirect()
            ->route('offer.index')
            ->with('success', 'Offre modifiée avec succès.');
    }

    public function destroy(Offer $offer)
    {
        $this->authorizeOffer($offer);

        $offer->delete();

        return redirect()
            ->route('offer.index')
            ->with('success', 'Offre supprimée.');
    }

    private function authorizeOffer(Offer $offer): void
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        $company = Company::where('user_id', $user->id)->first();

        abort_unless(
            $user->role === 'entreprise'
            && $company
            && $offer->companies_id === $company->id,
            403
        );
    }
}
