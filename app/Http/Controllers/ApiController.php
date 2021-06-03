<?php

namespace App\Http\Controllers;


use App\Http\Resources\ActivityCollection;
use App\Http\Resources\BudgetCollection;
use Facades\App\Repositories\Activities;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;
use Hash;
use App\User;

class ApiController extends Controller
{
    public function test()
    {
        return response()->json('OK', 200);
    }

    public function get(Request $request)
    {
        $payload = $request->query();
        $url = $request->fullUrl();
        $user = $request->user()->id;
    }

    /**
     * Get Transactions action
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactions(Request $request)
    {
        $payload = $request->query();
        $user = $request->user()->id;


        try {
            $transactions = Activities::get($user, $payload);
            $data =  new ActivityCollection($transactions);
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

    public function login(Request $request)
    {

        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where([
            ['email', '=', $username]
        ])->select('password', 'name', 'email', 'api_token')->first();

        if (Hash::check($password, $user['password'])) {

            return response()->json([
                'data' => $user
            ], 200);
        }
        else
        {
            return response()->json(['data' => 'Bad Login'], 403);
        }


    }

    /**
     * Retrieve User info based on API key
     * @param Request $request
     * @return mixed
     */
    public function user(Request $request)
    {
        return $request->user();
    }

    /**
     * Save
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $payload = $request->query();
        $user = $request->user()->id;

        dump($user);

        // Log::info('Storing activity');

        $activity = Activities::create($request);

        return response()->json([
            'data' => $activity
        ], 200);

    }
}
