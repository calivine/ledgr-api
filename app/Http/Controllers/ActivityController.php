<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityCollection;
use App\Pending;

use Facades\App\Repositories\PendingActivities;
use Facades\App\Repositories\Activities;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;

class ActivityController extends Controller
{
    /**
     * Get Transactions action
     * @param Request $request
     * @return
     */
    public function get(Request $request)
    {
        $payload = $request->query();
        $user = $request->user()->id;
        if ($request->path() == "transactions/pending")
        {

        }


        try {
            $data = new ActivityCollection(Activities::get($user, $payload));
        }
        catch (QueryException $e) {
            $data = [
                'message' => $e,
                'status' => 400
            ];
        }
        catch (Throwable $e) {
            $data = [
                'message' => $e,
                'status' => 400
            ];
        }
        finally {
            return $data;
        }

    }

    /**
     * Save
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->path();
        if ($request->path() == "transactions/pending")
        {
            $activity = PendingActivities::create($request);
        }
        else
        {
            $activity = Activities::create($request);
        }
        Log::info('Storing activity');
        // $activity = Activities::create($request);

        return response()->json([
            'data' => $activity
        ], 200);

    }
}
