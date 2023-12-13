<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\ReminderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as Controller;

class ReminderController extends Controller
{
    protected $reminderService;
    public function __construct(ReminderService $reminderService)
    {
        $this->reminderService = $reminderService;
    }

    public function index(Request $request): JsonResponse
    {
        $limit = $request->limit ? $request->limit : 10;

        $result = $this->reminderService->listData($limit);
        if ($result['status'] == false) {
            return $this->errorResponse($result['error'], $result['message'], $result['code']);
        }

        return $this->successResponse($result['result'], $result['code']);
    }

    public function view(Request $request)
    {
        $result = $this->reminderService->getDataByID($request->id);
        if ($result['status'] == false) {
            return $this->errorResponse($result['error'], $result['message'], $result['code']);
        }

        return $this->successResponse($result['result'], $result['code']);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'remind_at' => 'required|numeric',
            'event_at' => 'required|numeric'
        ], [
            'title.required' => 'Title harus diisi',
            'remind_at.required' => 'remind_at harus diisi',
            'remind_at.numeric' => 'remind_ad harus angka',
            'event_at.required' => 'event_at harus diisi',
            'event_at.numeric' => 'event_at harus angka'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error.', $validator->errors(), 422);
        }

        $result = $this->reminderService->createData([
            'title' => $request->title,
            'description' => $request->description,
            'remind_at' => $request->remind_at,
            'event_at' => $request->event_at
        ]);

        if ($result['status'] == false) {
            return $this->errorResponse($result['error'], $result['message'], $result['code']);
        }

        return $this->successResponse($result['result'], $result['code']);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        //
    }
}
