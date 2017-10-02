<?php

namespace App\Listeners;

use App\Events\TransactionDestroyed;
use App\Transaction\Receivable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionDestroyedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TransactionDestroyed  $event
     * @return void
     */
    public function handle(TransactionDestroyed $event)
    {
        if (!is_null($event->transaction->transaction_able))
        {
            $event->transaction->transactionAble->delete();
        }
    }
}
