<?php

use App\Models\User;
use App\Models\Peserta;
use App\Models\DataSeminar;

function totalSeminar()
{
    return DataSeminar::count();
}

function totalPeserta()
{
    return Peserta::count();
}

function totalUser()
{
    return User::count();
}

function totalActiveUser()
{
    return User::where('status_user', '>', 0)->count();

}

function totalInactiveUser()
{
    return User::where('status_user', '<', 1)->count();
}

