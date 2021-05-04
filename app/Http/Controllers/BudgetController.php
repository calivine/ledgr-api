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

            $data =  new BudgetCollection(Budgets::get($user, $payload));
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
