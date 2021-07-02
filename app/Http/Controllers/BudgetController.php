<?php

namespace App\Http\Controllers;

use App\Http\Resources\BudgetCollection;
use App\Http\Resources\PendingCollection;
use App\Repositories\PendingActivities;
use Facades\App\Repositories\Budgets;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function get(Request $request)
    {
        $payload = $request->query();
        $user = $request->user()->id;

        try {
            
            $data = [
                'url' => $request->fullUrl(),
                'data' => ['budget' => new BudgetCollection(Budgets::get($user, $payload)),
                           'pending' => new PendingCollection(PendingActivities::get($user))]
            ];

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
}
