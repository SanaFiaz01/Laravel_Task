<?php

namespace App\Http\Controllers;

use App\Models\Spin;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpinController extends Controller
{
    public function useSpin()
    {
        $user = Auth::user();

        // Check if user has used all free spins for the day
        $todaySpins = Spin::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($todaySpins >= 3) {
            return response()->json(['message' => 'No free spins left for today.'], 400);
        }

        // Add to wallet and create transaction
        $this->addTransaction($user->id, 100, 'spin', 'addition');
        $this->createSpin($user->id, 'free');

        return response()->json(['message' => 'Spin successful.', 'amount' => 100]);
    }

    public function buySpin()
    {
        $user = Auth::user();

        // Check if user has enough balance
        if ($user->wallet_balance < 200) {
            return response()->json(['message' => 'Insufficient funds.'], 400);
        }

        // Deduct from wallet and create transaction
        $this->addTransaction($user->id, 200, 'buy', 'deduction');
        $this->createSpin($user->id, 'purchased');

        return response()->json(['message' => 'Spin purchased successfully.', 'amount' => 200]);
    }

    public function getUserSpinHistory()
    {
        $user = Auth::user();
        $spins = Spin::where('user_id', $user->id)->get();

        return response()->json($spins);
    }

    public function getAdminSpinHistory()
    {
        $spins = Spin::all();

        return response()->json($spins);
    }

    private function addTransaction($userId, $amount, $source, $type)
    {
        Transaction::create([
            'transaction_id' => 'speedforce-' . now()->year . '-' . Str::random(10),
            'user_id' => $userId,
            'amount' => $amount,
            'source' => $source,
            'type' => $type,
        ]);
    }

    private function createSpin($userId, $type)
    {
        Spin::create([
            'user_id' => $userId,
            'type' => $type,
        ]);
    }
}
