<?php


namespace App\Repositories;

use App\Pending;
use DB;
use Illuminate\Http\Request;

class PendingActivities
{

    public function create($request)
    {
        // TODO: Store new Pending Activity

        $user = $request->user();
        $activity = $request->input('text');

        return $this->storeActivity($activity, $user);

    }

    public function get($user)
    {
        $data = DB::table('pendings')
            ->where('user_id', '=', $user)
            ->get();
        return $data;

    }


    private function storeActivity($activity, $user)
    {
        $pendingActivity = new Pending();
        $pendingActivity->text($activity);
        $pendingActivity->user()->associate($user);
        // $pendingActivity->approved(false);
        $pendingActivity->save();
        return $pendingActivity;
    }



}