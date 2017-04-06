<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillSplitterController extends Controller
{
    public function split(Request $request) {

			# store the inputs in a variable called inputs
			$inputs = $request->all();

			# validate the numeric data
			// $validator = Validator::make(
			// 	[
			// 		'tab' => $inputs['tab'],
			// 		'partySize' => $inputs['partySize'],
			// 	],
			// 	[
			// 		'tab' => 'required|numeric|min:0',
			// 		'partySize' => 'required|numeric|integer|min:1',
			// 	]
			// );

			// if ($validator->fails()) {
			// 	$errors = $validator->messages();
			// 	return view('errors')->with($errors);
			// }
			// else {
				$errors = false;
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
					$tipFactor = 1.22;
				}
				elseif ($quality == 'good') {
					$tipFactor = 1.18;
				}
				else {
					$tipFactor = 1.15;
				}
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
	#		}
		}
}
