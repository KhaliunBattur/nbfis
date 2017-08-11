<?php

namespace App\Http\Controllers\User;

use App\User\Asset\Asset;
use App\User\Asset\AssetRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    /**
     * @var ExpenseRepositoryInterface
     */
    private $assetRepository;

    /**
     * AssetController constructor.
     * @param AssetRepositoryInterface $assetRepository
     */
    public function __construct(AssetRepositoryInterface $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        return response()->json([
            'model' => $this->assetRepository->findByUserAll($id)
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, Request $request)
    {
        $parameters = $request->all();
        $parameters['user_id'] = $id;

        $asset = Asset::create($parameters);

        return response()->json([
            'result' => !is_null($asset)
        ]);
    }

    /**
     * @param $id
     * @param $asset_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $asset_id, Request $request)
    {
        $asset = $this->assetRepository->findById($asset_id);

        return response()->json([
            'result' => $asset->update($request->all())
        ]);
    }

    /**
     * @param $id
     * @param $asset_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $asset_id)
    {
        $asset = $this->assetRepository->findById($asset_id);

        return response()->json([
            'result' => $asset->delete()
        ]);
    }
}
