<?php

namespace App\Observers;

use App\Models\Treasury;
use App\Models\WDTreasury;

class WDObserver
{
    /**
     * Handle the WDTreasury "created" event.
     */
    public function created(WDTreasury $wDTreasury): void
    {
        $this->updateTreasuryAfterChange($wDTreasury,true);
    }

    /**
     * Handle the WDTreasury "updated" event.
     */
    public function updated(WDTreasury $wDTreasury): void
    {
        $this->updateTreasuryAfterChange($wDTreasury,true);
    }

    /**
     * Handle the WDTreasury "deleted" event.
     */
    public function deleted(WDTreasury $wDTreasury): void
    {
        $this->updateTreasuryAfterChange($wDTreasury,false);
    }

    /**
     * Handle the WDTreasury "restored" event.
     */
    public function restored(WDTreasury $wDTreasury): void
    {
        //
    }

    /**
     * Handle the WDTreasury "force deleted" event.
     */
    public function forceDeleted(WDTreasury $wDTreasury): void
    {
        //
    }
    public function updateTreasuryAfterChange(WDTreasury $wDTreasury,$type)
    {
        $treasury = Treasury::find(1);

        if(isset($treasury->amount)){
            if($type){
                if($wDTreasury->type){
                    $treasury->amount = $treasury->amount + $wDTreasury->ammont;
                    $treasury->save();
                }else{
                    $treasury->amount = $treasury->amount - $wDTreasury->ammont;
                    $treasury->save();
                }
            }else{
                if(!$wDTreasury->type){
                    $treasury->amount = $treasury->amount + $wDTreasury->ammont;
                    $treasury->save();
                }else{
                    $treasury->amount = $treasury->amount - $wDTreasury->ammont;
                    $treasury->save();
                }
            }

        }
    }
}
