<?php

use App\Models\IncompleteApplication;

Schedule::call(function (){
    $applications = IncompleteApplication::with(['package'])->whereTime('created_at', '>=', now()->minutes(30))->get();
    foreach ($applications as $application) {
        try {
            if ($application?->package && $application->reminder_count < 1){
                Mail::to($application->email)->send(new \App\Mail\ReminderMail($application->package,$application->id));
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
        $application->increment('reminder_count');
    }
});