<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class member_loan extends Model
{
    use HasFactory,LogsActivity;
    protected $primaryKey ="member_loan_id";

    protected static $logOnlyDirty = true;
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = "member_loans";
        $activity->description = $eventName;
        $activity->causer_id =1;
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }
}
