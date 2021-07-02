<?php

namespace App\Http\Controllers;

use App\Http\Resources\BudgetCollection;
use App\Http\Resources\PendingCollection;
use Facades\App\Repositories\PendingActivities;
use Facades\App\Repositories\Budgets;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function get(Request $request)
    {
        $payload = $request->query();
        $user = $request->user()->id;
        // $budgetData = new BudgetCollection(Budgets::get($user, $payload));
        $budgetData = Budgets::get($user, $payload);
        // $pendingActivities = new PendingCollection(PendingActivities::get($user));
        $pendingActivities = PendingActivities::get($user);
        $responsePayload = ['budget' => $budgetData, 'pending' => $pendingActivities];

        try {
            $data = [
                'url' => $request->fullUrl(),
                'data' => $responsePayload
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
