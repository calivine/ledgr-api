<?php

namespace App\Http\Controllers;

use App\Http\Resources\BudgetCollection;
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
            $budget = Budgets::get($user, $payload);
            $data = [
                'data' => new BudgetCollection($budget)
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
}
