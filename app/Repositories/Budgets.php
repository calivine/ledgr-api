<?php


namespace App\Repositories;

use App\Budget;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Budgets
{
    public function create($new_category, $new_planned_budget, $user, $month, $year)
    {
        return $this->storeCategory($new_category, $new_planned_budget, $user, $month, $year);
    }

    public function get($user, $payload)
    {
        $data = DB::table('budgets')
            ->join('pendings', 'budgets.user_id', '=', 'pendings.user_id')
            ->where('budgets.user_id', '=', $user)
            ->where('pendings.approved', '=', false);


        if (count($payload) > 1)
        {
            $params = Arr::except($payload, ['api_token']);


            $data = $data->where($params)
                ->get();
        }
        else
        {
            $data = $data->get();
        }

        return $data;


    }

    private function storeCategory($new_category, $new_planned_budget, $user, $month, $year)
    {
        $category = new Budget;
        $category->category = $new_category;
        $category->planned = $new_planned_budget;
        $category->year = $year; // date('Y');
        $category->month = $month; // date('F');
        $category->period = $month . ' ' . $year; // date('F') . ' ' . date('Y');
        $category->user()->associate($user);

        $category->save();

        Log::info('Saved new category ' . $new_category . ' ' . $category->id);

        return $category;

    }


}