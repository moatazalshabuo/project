<?php

namespace App\Observers;

use App\Models\Exchange;
use App\Models\Treasury;

class ExchangeObserver
{
    /**
     * Handle the Exchange "created" event.
     */
    public function created(Exchange $exchange): void
    {
        $this->updateTreasuryAfterChange($exchange,true);
    }

    /**
     * Handle the Exchange "updated" event.
     */
    public function updated(Exchange $exchange): void
    {
        //
    }

    /**
     * Handle the Exchange "deleted" event.
     */
    public function deleted(Exchange $exchange): void
    {
        $this->updateTreasuryAfterChange($exchange,false);
    }

    /**
     * Handle the Exchange "restored" event.
     */
    public function restored(Exchange $exchange): void
    {
        //
    }

    /**
     * Handle the Exchange "force deleted" event.
     */
    public function forceDeleted(Exchange $exchange): void
    {
        //
    }

    public function updateTreasuryAfterChange(Exchange $exchange,$type)
    {
        $treasury = Treasury::find(1);

        if(isset($treasury->amount)){
            if($type){
                $treasury->amount = $treasury->amount - $exchange->price;
                $treasury->save();
            }else{
                $treasury->amount = $treasury->amount + $exchange->price;
                $treasury->save();
            }
        }
    }
}
