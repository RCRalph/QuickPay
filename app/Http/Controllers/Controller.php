<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Currency;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function getBalance()
    {
        $tRecipient = auth()->user()->transactionsRecipient
			->groupBy("currency_id")
			->map(function ($row) {
            	return $row->sum('amount');
        	});

        $tSender = auth()->user()->transactionsSender->groupBy("currency_id")->map(function ($row) {
            return -$row->sum('amount');
        });

        $keysAndValues = [
            array_merge(
                $tRecipient->keys()->toArray(),
                $tSender->keys()->toArray()
            ),
            array_merge(
                $tRecipient->values()->toArray(),
                $tSender->values()->toArray()
            )
		];

        $balance = [];
        for ($i = 0; $i < count($keysAndValues[0]); $i++) {
			$id = Currency::find($keysAndValues[0][$i])->id;
            if (array_key_exists($id, $balance)) {
                $balance[$id] += $keysAndValues[1][$i];
            }
            else {
				$balance[$id] = $keysAndValues[1][$i];
			}
		}

		foreach($balance as $key => $value) {
			if ($value < 0.01) {
				unset($balance[$key]);
			}
		}

        return collect($balance)->sortDesc();
    }
}
