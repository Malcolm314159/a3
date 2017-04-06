<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillSplitterController extends Controller
{
    public function split(Request $request) {

        $this->validate($request, [
            'tab' => 'required|numeric|min:0',
            'partySize' => 'required|numeric|integer|min:1',
        ]);

        # store the inputs in a variable called inputs
        $inputs = $request->all();

        # puts the inputs into usable variables
        $tab = floatval($inputs['tab']);
        $partySize = intval($inputs['partySize']);
        $quality = $inputs['quality'];
        if (array_key_exists('roundUp', $inputs)) {
            $roundUp = true;
        }
        else {
            $roundUp = false;
        }
        if ($quality == 'excellent') {
            $tipFactor = 1.21;
        }
        elseif ($quality == 'good') {
            $tipFactor = 1.18;
        }
        else {
            $tipFactor = 1.15;
        }

        #compile results
        $amount = $tab*$tipFactor/$partySize;
        if ($roundUp == true) {
            $amount = ceil($amount);
        }
        $results = [
            'tab' => $tab,
            'partySize' => $partySize,
            'quality' => $quality,
            'roundUp' => $roundUp,
            'amount' => $amount,
        ];
        return view('results', $results);
    }
}
