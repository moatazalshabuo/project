<?php

namespace App\Observers;

use App\Models\ControlMaterial;
use App\Models\rawmaterials;

class CRQuantityObserve
{
    /**
     * Handle the ControlMaterial "created" event.
     */
    public function created(ControlMaterial $controlMaterial): void
    {
       $this->toDo($controlMaterial,True);
    }

    /**
     * Handle the ControlMaterial "updated" event.
     */
    public function updated(ControlMaterial $controlMaterial): void
    {
        //
    }

    /**
     * Handle the ControlMaterial "deleted" event.
     */
    public function deleted(ControlMaterial $controlMaterial): void
    {
        $this->toDo($controlMaterial,False);
    }

    /**
     * Handle the ControlMaterial "restored" event.
     */
    public function restored(ControlMaterial $controlMaterial): void
    {
        //
    }

    /**
     * Handle the ControlMaterial "force deleted" event.
     */
    public function forceDeleted(ControlMaterial $controlMaterial): void
    {
        //
    }

    public function toDo(ControlMaterial $controlMaterial, $type){
        $raw = rawmaterials::find($controlMaterial->raw_id);
        if($type){
            if($controlMaterial->type){
                $raw->quantity += $controlMaterial->quantity;
                $raw->save();
            }else{
                $raw->quantity -= $controlMaterial->quantity;
                $raw->save();
            }
        }else{
            if($controlMaterial->type){
                $raw->quantity -= $controlMaterial->quantity;
                $raw->save();
            }else{
                $raw->quantity += $controlMaterial->quantity;
                $raw->save();
            }
        }
    }
}
