<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        abort_unless(
            in_array(Auth::user()->role, ['entreprise', 'admin'], true),
            403
        );

        $user = Auth::user();

        $companies = $user->role === 'admin'
            ? Company::all()
            : Company::where('user_id', $user->id)->get();

        return view('company.index', compact('companies'));
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        return view('company.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'unique:companies,user_id'],
            'nom' => ['required', 'string', 'max:255'],
        ]);

        Company::create($validated);

        return redirect()
            ->route('company.index')
            ->with('success', 'Entreprise ajoutée.');
    }

    public function show(Company $company)
    {
        $this->authorizeCompany($company);

        return view('company.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $this->authorizeCompany($company);

        return view('company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->authorizeCompany($company);

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $company->update($validated);

        return redirect()
            ->route('company.index')
            ->with('success', 'Entreprise mise à jour.');
    }

    public function destroy(Company $company)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $company->delete();

        return redirect()
            ->route('company.index')
            ->with('success', 'Entreprise supprimée.');
    }

    private function authorizeCompany(Company $company): void
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'admin'
            || (
                $user->role === 'entreprise'
                && $company->user_id === $user->id
            ),
            403
        );
    }
}
