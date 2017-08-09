<?php

namespace App\Http\Controllers\User;

use App\User\Workplace\Workplace;
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

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id, Request $request)
    {
        $workplaces = $this->workplaceRepository->findByUserPaginate($id, $request->get('per_page'), $request->all());

        return response()->json([
            'model' => $workplaces
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, Request $request)
    {
        $this->valid($request);

        $parameters = $request->all();

        $parameters['user_id'] = $id;

        $workplace = Workplace::create($parameters);

        return response()->json(['result' => !is_null($workplace)]);
    }

    /**
     * @param $id
     * @param $workplace_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $workplace_id, Request $request)
    {
        $workplace = $this->workplaceRepository->findById($workplace_id);

        return response()->json([
            'result' => $workplace->update($request->all())
        ]);
    }

    /**
     * @param $id
     * @param $workplace_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $workplace_id)
    {
        $workplace = $this->workplaceRepository->findById($workplace_id);

        return response()->json(['result' => $workplace->delete()]);
    }

    /**
     * @param $request
     */
    private function valid($request)
    {
        $this->validate($request, [
            'organization' => 'required',
            'date_employment' => 'required',
            'position' => 'required'
        ]);
    }
}
