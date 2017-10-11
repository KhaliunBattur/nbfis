<?php

namespace App\Listeners;

use App\Events\AccountDestroyed;
use App\Season\Season;
use App\Season\SeasonRepositoryInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountDestroyedListener
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
     * @param  AccountDestroyed $event
     * @return void
     * @throws \Exception
     */
    public function handle(AccountDestroyed $event)
    {
        try
        {
            if($event->account->transactions()->count() > 0)
            {
                throw new \Exception('Утсгах боломжгүй', 403);
            }

            if($event->account->haveBalance())
            {
                throw new \Exception('Утсгах боломжгүй', 403);
            }

            foreach ($this->seasonRepository->findAll() as $season)
            {
                $season->accounts()->detach($event->account->getKey());
            }
        }catch (\Exception $exception)
        {
//            response()->json([
//                'message' => $exception->getMessage()
//            ]);
        }
    }
}
