<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\Treasury;

class ObAsset
{
    /**
     * Handle the Asset "created" event.
     */
    public function created(Asset $asset): void
    {
        $this->updateTreasuryAfterChange($asset,true);

    }

    /**
     * Handle the Asset "updated" event.
     */
    public function updated(Asset $asset): void
    {
        //
    }

    /**
     * Handle the Asset "deleted" event.
     */
    public function deleted(Asset $asset): void
    {
        $this->updateTreasuryAfterChange($asset,false);
    }

    /**
     * Handle the Asset "restored" event.
     */
    public function restored(Asset $asset): void
    {
        //
    }

    /**
     * Handle the Asset "force deleted" event.
     */
    public function forceDeleted(Asset $asset): void
    {
        //
    }

    public function updateTreasuryAfterChange(Asset $asset,$type)
    {
        $treasury = Treasury::find(1);

        if(isset($treasury->amount)){
            if($type){
                $treasury->amount = $treasury->amount - $asset->value;
                $treasury->save();
            }else{
                $treasury->amount = $treasury->amount + $asset->value;
                $treasury->save();
            }
        }
    }
}
