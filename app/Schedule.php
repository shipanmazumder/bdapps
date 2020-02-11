<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function installApp()
    {
        return $this->belongsTo("App\InstallApp");
    }
}
