<?php


namespace App\Repositories;

use App\Activity;
use App\Budget;
use Arr;
use Carbon\Carbon;
use DB;
use Facades\App\Repositories\Budgets;
use Illuminate\Database\QueryException;
use Log;
use Illuminate\Http\Request;



class Activities
{
    CONST CACHE_KEY = 'ACTIVITIES';

    public function get($user, $payload)
    {
        $data = DB::table('budgets')
            ->join('activities', 'budgets.id', '=', 'activities.budget_id')
            ->where('activities.user_id', '=', $user)
            ->orderBy('activities.date', 'desc');



        if (count($payload) > 1)
        {
            $params = Arr::except($payload, ['api_token']);

            $values = array_values($params);
            $keys = array_keys($params);

            $keys = array_map('add_db_prefix', $keys);
            $params = array_combine($keys, $values);
            $data = $data->where($params)
                         ->get();
        }
        else
        {
            $data = $data->get();
        }

        return $data;
    }

    /** Get all transactions for a user.
     *
     * @param $user
     * @return mixed
     */
    public function all($user)
    {
        return DB::table('budgets')
            ->join('activities', 'budgets.id', '=', 'activities.budget_id')
            ->where('activities.user_id', '=', $user)
            ->orderBy('activities.date', 'desc')
            ->get();
    }

    public function create($request)
    {
        $date = $request->input('date');
        $amount = $request->input('amount');
        $description = $request->input('description');
        $category = $request->input('category');

        $user = $request->user();

        return $this->storeActivity($date, $amount, $description, $category, $user);

    }

    private function storeActivity($date, $amount, $description, $category, $user)
    {
        $year = date('Y', strtotime($date));
        $month = date('F', strtotime($date));

        // Get Budget Category To Associate w/ Activity
        $budget = Budget::where([
            ['year', '=', $year],
            ['month', '=', $month],
            ['user_id', '=', $user->id],
            ['category', '=', $category]
        ])->first();

        // If Budget Sheet Doesn't Exist,
        if ($budget == null)
        {
            // Create a new budget category
            $budget = Budgets::create($category, 0, $user, $month, $year); // new StoreCategory($category, 0, $user, $month, $year);
            Log::info($year . " " . $month . " " . $user->id . " " . $category);
            // $budget = $budget->rda['budget'];
        }

        // Save Transaction To Activities Table
        $activity = new Activity();

        $activity->description = $description;
        $activity->amount = $amount;
        $activity->category = $category;
        $activity->date = $date;
        // Link To User Signed-In
        $activity->user()->associate($user);
        // Link To Budget Category
        $activity->budget()->associate($budget);
        $activity->save();

        Log::info('Updating budget: ' . $activity->budget_id . ' by ' . $activity->amount);
        $budget->actual += $activity->amount;
        $budget->save();

        return $activity;
    }



}