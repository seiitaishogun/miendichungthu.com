<?php

namespace Modules\Acl\Http\Middleware;

use App\Http\Middleware\QueuesUpdateDatabase;
use App\Libraries\APIStoreService;
use Closure;

class VerifyWebDefault
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // update service
        app()->make(APIStoreService::class)->checkForUpdateForCore();

        // checking update database
        (new QueuesUpdateDatabase())->handle($request, $next);

        if ($request->segment(1) === admin_path()) {
            // auto language vi redirect to admin
            session(['lang' => 'vi']);

            if(! auth()->check()) {
                return redirect('/auth');
            }
        }

        if ($request->has('affiliate')) {
            session(['affiliate' => $request->get('affiliate')]);
        }
        if ($request->has('user_verify')) {
            session(['user_verify' => $request->get('user_verify')]);
        }
        if ($request->has('utm_source')) {
            session(['utm_source' => $request->get('utm_source')]);
        }

        if (request()->get('cnvteam')) {
            session()->put('save_original_content', true);
        }

        return $next($request);
    }
}