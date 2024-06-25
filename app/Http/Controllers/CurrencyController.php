<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    // ----------------------------------------------------------------
    // Getting the currencies Symbols from the FIXER API
    // ----------------------------------------------------------------
    public function currencies()
    {
        $apiKey = env('FIXER_API_KEY');
        $response = Http::get("http://data.fixer.io/api/symbols", [
            'access_key' => $apiKey
        ]);

        if ($response->successful() && $response->json()['success']) {
            $symbols = array_keys($response->json()['symbols']);
        } else {
            $symbols = [];
        }

        // Map the data in view template (currency_converter.blade.php)
        return view('currency_converter', compact('symbols'));
    }

    public function convert(Request $request)
    {
        // ----------------------------
        // Validate the input fields
        // ----------------------------
        $request->validate([
            'amount' => 'required|numeric',
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
        ]);

        // getting form inputs
        $amount = $request->input('amount');
        $from = $request->input('from_currency');
        $to = $request->input('to_currency');

        // ----------------------------------
        // getting apiKey from .env files
        // ----------------------------------
        $apiKey = env('FIXER_API_KEY');

        // HTTP API Request to Fixer.io
        $response = Http::get("http://data.fixer.io/api/latest", [
            'access_key' => $apiKey,
            'symbols' => "{$from},{$to}"
        ]);

        if ($response->successful() && $response->json()['success']) {
            $rates = $response->json()['rates'];

            // Calculate conversion based on EUR as the base currency (I'm using the unpaid version of Fixer)
            // ----------------------------------------------------------------------------------------------
            if ($from === 'EUR') {
                $convertedAmount = $amount * $rates[$to];
            } elseif ($to === 'EUR') {
                $convertedAmount = $amount / $rates[$from];
            } else {
                $convertedAmount = ($amount / $rates[$from]) * $rates[$to];
            }
            // output json on ajax request! 
            return response()->json(['success' => true, 'amount' => $amount, 'currency_from' => $from, 'converted_amount' => $convertedAmount, 'currency_to' => $to]);
        } else {
            return response()->json(['success' => false, 'message' => 'Error fetching exchange rates'], 500);
        }
    }

}
