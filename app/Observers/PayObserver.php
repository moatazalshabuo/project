<?php

namespace App\Observers;

use App\Models\pay_receipt;
use App\Models\Treasury;

class PayObserver
{
    /**
     * Handle the pay_receipt "created" event.
     */
    public function created(pay_receipt $pay_receipt): void
    {
        $this->updateTreasuryAfterChange($pay_receipt,true);
    }

    /**
     * Handle the pay_receipt "updated" event.
     */
    public function updated(pay_receipt $pay_receipt): void
    {
        //
    }

    /**
     * Handle the pay_receipt "deleted" event.
     */
    public function deleted(pay_receipt $pay_receipt): void
    {
        $this->updateTreasuryAfterChange($pay_receipt,false);
    }

    /**
     * Handle the pay_receipt "restored" event.
     */
    public function restored(pay_receipt $pay_receipt): void
    {
        //
    }

    /**
     * Handle the pay_receipt "force deleted" event.
     */
    public function forceDeleted(pay_receipt $pay_receipt): void
    {
        //
    }

    public function updateTreasuryAfterChange(pay_receipt $pay_receipt,$type)
    {
        $treasury = Treasury::find(1);

        if(isset($treasury->amount)){
            if($type){
                $treasury->amount = $treasury->amount + $pay_receipt->price;
                $treasury->save();
            }else{
                $treasury->amount = $treasury->amount - $pay_receipt->price;
                $treasury->save();
            }
        }
    }
}
