<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class TipsterController extends Controller
{
    public function stats(User $user)
    {
        $tips = $user->tips()->get();

        $total    = $tips->count();
        $wins     = $tips->where('status', 'win')->count();
        $losses   = $tips->where('status', 'loss')->count();
        $pending  = $tips->where('status', 'pending')->count();
        $decided  = $wins + $losses;
        $winRate  = $decided > 0 ? round(($wins / $decided) * 100, 1) : 0;

        $settledTips  = $tips->whereIn('status', ['win', 'loss']);
        $settledCount = $settledTips->count();
        $roi = 0;

        if ($settledCount > 0) {
            $winnings = $settledTips->where('status', 'win')->sum('odds');
            $roi = round((($winnings - $settledCount) / $settledCount) * 100, 1);
        }

        return response()->json([
            'tipster' => [
                'id'   => $user->id,
                'name' => $user->name,
            ],
            'stats' => [
                'total'    => $total,
                'wins'     => $wins,
                'losses'   => $losses,
                'pending'  => $pending,
                'win_rate' => $winRate,
                'roi'      => $roi,
            ],
        ]);
    }
}