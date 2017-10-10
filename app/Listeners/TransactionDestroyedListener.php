<?php

namespace App\Listeners;

use App\Events\TransactionDestroyed;
use App\Transaction\Property;
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
            if($event->transaction->transactionAble instanceof Receivable)
            {
                if($event->transaction->account->type == 'active')
                {
                    if($event->transaction->type == 'debit')
                    {
                        $event->transaction->transactionAble->delete();
                    }
                }
                else
                {
                    if($event->transaction->type == 'credit')
                    {
                        $event->transaction->transactionAble->delete();
                    }
                }
            }

            if($event->transaction->transactionAble instanceof Property)
            {
                if($event->transaction->account->type == 'active')
                {
                    if($event->transaction->type == 'debit')
                    {
                        $event->transaction->transactionAble->delete();
                    }
                }
            }
        }
    }
}
