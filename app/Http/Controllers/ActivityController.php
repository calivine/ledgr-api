<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityCollection;
use Facades\App\Repositories\Activities;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;

class ActivityController extends Controller
{
    /**
     * Get Transactions action
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $payload = $request->query();
        $user = $request->user()->id;


        try {
            $transactions = Activities::get($user, $payload);
            $data = [
                'data' => new ActivityCollection($transactions)
            ];
            $status = 200;
        }
        catch (QueryException $e) {
            $data = [
                'message' => $e
            ];
            $status = 400;

        }
        catch (Throwable $e) {
            $data = [
                'message' => $e
            ];
            $status = 400;

        }
        finally {
            return response()->json($data, $status);
        }

    }

    /**
     * Save
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Log::info('Storing activity');
        $activity = Activities::create($request);

        return response()->json([
            'data' => $activity
        ], 200);

    }
}
