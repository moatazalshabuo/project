<?php

namespace App\Observers;

use App\Models\Salesbill;
use App\Models\Treasury;

class salesObserve
{
    /**
     * Handle the Salesbill "created" event.
     */
    public function created(Salesbill $salesbill): void
    {
        //
    }

    /**
     * Handle the Salesbill "updated" event.
     */
    public function updated(Salesbill $salesbill): void
    {

    }

    /**
     * Handle the Salesbill "deleted" event.
     */
    public function deleted(Salesbill $salesbill): void
    {
        //
    }

    /**
     * Handle the Salesbill "restored" event.
     */
    public function restored(Salesbill $salesbill): void
    {
        //
    }

    /**
     * Handle the Salesbill "force deleted" event.
     */
    public function forceDeleted(Salesbill $salesbill): void
    {
        //
    }
}
