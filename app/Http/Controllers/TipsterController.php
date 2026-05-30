<?php

namespace App\Http\Controllers;

use App\Models\User;

class TipsterController extends Controller
{
    public function show(User $user)
    {
        // Načítaj tipy usera
        $tips = $user->tips()->latest()->get();

        // Základné štatistiky
        $total   = $tips->count();
        $wins    = $tips->where('status', 'win')->count();
        $losses  = $tips->where('status', 'loss')->count();
        $pending = $tips->where('status', 'pending')->count();

        // Úspešnosť (len rozhodnuté tipy)
        $decided = $wins + $losses;
        $winRate = $decided > 0 ? round(($wins / $decided) * 100) : 0;

        // ROI výpočet
        $settledTips = $tips->whereIn('status', ['win', 'loss']);
        $settledCount = $settledTips->count();

        if ($settledCount > 0) {
            $winnings = $settledTips->where('status', 'win')->sum('odds');
            $roi = round((($winnings - $settledCount) / $settledCount) * 100, 1);
        } else {
            $roi = 0;
        }

        return view('tipster.show', compact(
            'user', 'tips', 'total', 'wins', 'losses', 'pending', 'winRate', 'roi'
        ));
    }
}