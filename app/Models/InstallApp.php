<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InstallApp extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'id');
    }

    public function get_app_details(): array
    {
        $apps = InstallApp::with('category')->where('user_id', Auth::user()->id)->get();
        $data = [];

        if ($apps) {
            foreach ($apps as $key=>$value) {
                $data[$key]['id'] = $value->id;
                $data[$key]['app_name'] = $value->app_name;
                $data[$key]['ussd_code'] = $value->ussd_code;
                $data[$key]['category_name'] = $value->category->name;
                $data[$key]['total_subscriber'] = 0;
                $where_match = ['app_id' => $value->id, 'is_sent' => 0];
                $app_remain_sms = Content::where($where_match)->count();
                $data[$key]['app_remain_sms'] = $app_remain_sms;

                if ($app_remain_sms <= 10) {
                    $data[$key]['class_name'] = 'danger';
                } else {
                    $data[$key]['class_name'] = 'success';
                }
            }
        }

        return $data;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
