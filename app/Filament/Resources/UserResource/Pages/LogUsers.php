<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class LogUsers extends ListActivities
{
    protected static string $resource = UserResource::class;

}