<?php


function add_db_prefix($key) {
    $budgets = ["month", "year", "period"];
    $activities = ["category", "description", "amount"];
    if (in_array($key, $activities))
    {
        return "activities." . $key;
    }
    else if (in_array($key, $budgets))
    {
        return "budgets." . $key;
    }
    return $key;
}

