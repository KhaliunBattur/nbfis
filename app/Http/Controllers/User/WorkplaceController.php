<?php

namespace App\Http\Controllers\User;

use App\User\Workplace\WorkplaceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkplaceController extends Controller
{
    /**
     * @var WorkplaceRepositoryInterface
     */
    private $workplaceRepository;

    /**
     * WorkplaceController constructor.
     * @param WorkplaceRepositoryInterface $workplaceRepository
     */
    public function __construct(WorkplaceRepositoryInterface $workplaceRepository)
    {
        $this->workplaceRepository = $workplaceRepository;
    }
}
