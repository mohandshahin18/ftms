<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.Company.{id}', function ($company, $id) {
    return (int) $company->id === (int) $id;
},['guards'=>['company']]);

Broadcast::channel('App.Models.Student.{id}', function ($student, $id) {
    return (int) $student->id === (int) $id;
},['guards'=>['student']]);

Broadcast::channel('App.Models.Trainer.{id}', function ($trainer, $id) {
    return (int) $trainer->id === (int) $id;
},['guards'=>['trainer']]);
