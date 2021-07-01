<?php


namespace App\Repositories;

use App\Pending;

class PendingActivities
{

    public function create($request)
    {
        // TODO: Store new Pending Activity

        $user = $request->user();
        $activity = $request->input('text');

        return $this->storeActivity($activity, $user);

    }


    private function storeActivity($activity, $user)
    {
        $pendingActivity = new Pending();
        $pendingActivity->text($activity);
        $pendingActivity->user()->associate($user);
        $pendingActivity->save();
        return $pendingActivity;
    }

}