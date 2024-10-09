<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Models\Event;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index()
    {
        return view('logs.index', [
            'title' => 'Loglar'
        ]);
    }

    public function json(Request $request)
    {
        $log = Log::orderBy('id', 'DESC');
        if ($request->get('sort')) {
            $log = Log::orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($request->get('search')) {
            $log->whereAny(['data', 'table_name'], 'LIKE', '%' . $request->get('search'). '%');
        }
        if ($request->get('user_id')) {
            $log->where('user_id', $request->get('user_id'));
        }
        if ($request->get('log_type')) {
            $log->where('log_type', $request->get('log_type'));
        }
        if ($request->get('table_name')) {
            $log->where('table_name', $request->get('table_name'));
        }
        if ($request->get('start_date')) {
            $log->where('log_date', '>=', date('Y-m-d 00:00:00', strtotime($request->get('start_date'))));
        }
        if ($request->get('end_date')) {
            $log->where('log_date', '<=', date('Y-m-d 23:59:59', strtotime($request->get('end_date'))));
        }

        return response()->json([
            'total' => $log->count(),
            'totalNotFiltered' => $log->count(),
            'rows' => LogResource::collection($log->page()),
        ]);
    }

    public function detail(Log $log)
    {
        $data = [];
        if (!in_array($log->log_type, ['create', 'delete']) && $log->table_name && !str_contains($log->table_name, 'meta') && $log->data_id) {
            $data = Log::orderBy('id', 'ASC')
                ->where('id', '>', $log->id)
                ->where('table_name', $log->table_name)
                ->where('data_id', $log->data_id)
                ->first();

            if ($data) {
                $data = $data->json_data;
            } else {
                $data = (array) DB::table($log->table_name)->find($log->data_id);
            }
        }


        return response()->json([
            'title' => sprintf('#%s - %s', $log->id, $log->log_date?->format('Y-m-d H:i')),
            'body' => view('logs.offcanvas', [
                'log' => $log,
                'data' => $data,
                'diff' => $data ? array_diff_assoc($log->json_data, $data) : []
            ])->render()
        ]);
    }
}
