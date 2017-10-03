<?php

namespace App\Listeners;

use App\Events\AccountUpdated;
use App\Season\SeasonRepositoryInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountUpdatedListener
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
     * @param  AccountUpdated $event
     * @return void
     * @throws \Exception
     */
    public function handle(AccountUpdated $event)
    {
        $season = $this->seasonRepository->findCurrentByObject();

        if(!is_null($season))
        {
            $currency = $event->request->get('currency');

            if($currency['id'] != $event->account->currency_id)
            {
                if($event->account->balance($season->getKey()) > 0)
                {
                    throw new \Exception("Валютын төрөл солих боломжгүй", 403);
                }

                if($event->account->transactions()->count() > 0)
                {
                    throw new \Exception('Валютын төрөл солих боломжгүй', 403);
                }
            }
        }
    }
}
