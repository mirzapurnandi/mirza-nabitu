<?php

namespace App\Services;

use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;

class ReminderService
{
    public function listData($limit)
    {
        $status = false;
        $code = 200;
        $result = [];
        $error = "";
        try {
            $result['reminders'] = Reminder::orderBy('id', 'desc')->limit($limit)->get();
            $result['limit'] = $limit;

            $message = 'Get All Data Reminders';
            $status = true;
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $error = "Unsuccessfully...";
            $result = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine()
            ];
        }

        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'error' => $error,
            'result' => $result
        ];
    }

    public function getDataByID($id)
    {
        $status = false;
        $code = 200;
        $result = [];
        $error = "";
        try {
            $result = Reminder::findOrFail($id);

            $message = 'Get Data By ID Reminders';
            $status = true;
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $error = "Unsuccessfully...";
            $result = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine()
            ];
        }

        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'error' => $error,
            'result' => $result
        ];
    }

    public function createData($datas)
    {
        $status = false;
        $code = 200;
        $result = [];
        $error = "";
        try {
            $result = new Reminder();
            $result->title = $datas['title'];
            $result->description = $datas['description'];
            $result->remind_at = $datas['remind_at'];
            $result->event_at = $datas['event_at'];
            $result->save();

            $message = 'Succesfully create Reminders';
            $code = 201;
            $status = true;
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $error = "Unsuccessfully...";
            $result = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine()
            ];
        }

        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'error' => $error,
            'result' => $result
        ];
    }
}
