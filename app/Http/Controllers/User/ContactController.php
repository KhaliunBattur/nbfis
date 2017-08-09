<?php

namespace App\Http\Controllers\User;

use App\User\Contact\Contact;
use App\User\Contact\ContactRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * @var ContactRepositoryInterface
     */
    private $contactRepository;

    /**
     * ContactController constructor.
     * @param ContactRepositoryInterface $contactRepository
     */
    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id, Request $request)
    {
        $contacts = $this->contactRepository->findByUserPaginate($id, $request->get('per_page'), $request->all());

        return response()->json([
            'model' => $contacts
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

        $contact = Contact::create($parameters);

        return response()->json(['result' => !is_null($contact)]);
    }

    /**
     * @param $id
     * @param $emergency_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $emergency_id, Request $request)
    {
        $emergency = $this->contactRepository->findById($emergency_id);

        return response()->json([
            'result' => $emergency->update($request->all())
        ]);
    }

    /**
     * @param $id
     * @param $workplace_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $workplace_id)
    {
        $emergency = $this->contactRepository->findById($workplace_id);

        return response()->json(['result' => $emergency->delete()]);
    }

    /**
     * @param $request
     */
    private function valid($request)
    {
        $this->validate($request, [
            'name' => 'required',
            'relation' => 'required',
            'phone_number' => 'required'
        ]);
    }
}
