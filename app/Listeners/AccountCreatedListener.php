<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use App\Season\SeasonRepositoryInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountCreatedListener
{

    /**
     * @var SeasonRepositoryInterface
     */
    private $seasonRepository;

    /**
     * Create the event listener.
     *
     * @param SeasonRepositoryInterface $seasonRepository
     */
    public function __construct(SeasonRepositoryInterface $seasonRepository)
    {
        //
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AccountCreated  $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {
        $season = $this->seasonRepository->findCurrentByObject();

        if(!is_null($season))
        {
            $season->accounts()->attach($event->account->getKey(), [
                'exchange' => $season->currencies()->where('currency_id', $event->account->currency_id)->first()->exchange,
                'balance' => 0
            ]);
        }
    }
}
