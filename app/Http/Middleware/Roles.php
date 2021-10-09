<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class Roles
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
        $routeName = Route::getFacadeRoot()->current()->uri();

        $route = explode('/', $routeName);  //بياخد الراوت اللي قي المتصفح فوق و يقسمه الي اجزاء

        // $roleRoutes = Role::distinct()->whereNotNull('allowed_route')->pluck('allowed_route')->toArray(); //allowed_route الموجوده في الداتا بيز هيكون فيها كذا نوع هو هياخد من كل نوع حاجه واحده بس

        if (auth()->check()) {
            if (!in_array($route[0], $this->roleRoutes() )) {
                return $next($request);
            } else {
                if ($route[0] != $this->userRoutes() ) {
                    $path = $route[0] == $this->userRoutes() ? $route[0].'.login' : '' . $this->userRoutes().'.index';
                    return redirect()->route($path);
                } else {
                    return $next($request);
                }
            }
        } else {

            $routeDistination = in_array($route[0], $this->roleRoutes() ) ? $route[0].'.login' : 'login';

            $path = $route[0] != '' ? $routeDistination : $this->userRoutes().'.index';

            return redirect()->route($path);
        }
    }

    //بخزنها في الكاش علشان مش تتكرر كل مره افتح صفحة ويب ينفذ الامر دا
    protected function roleRoutes()
    {
        //لو مافيش قيمة مخزنة عند تحميل الصفحات باسم هذا الكاش - نفذ الخطوات التالية
        if (!Cache::has('role_routes'))
        {
            //تذكر هذا الكاش دائما وهعطيه اسمه
            //'role_routes'=>اسم الكاش
            //,....=>قيمة الكاش او القيمة اللي هيتذكرها الكاش
            Cache::forever('role_routes', Role::distinct()->whereNotNull('allowed_route')->pluck('allowed_route')->toArray());
        }
        //لو فيه بقي قسمة متخزنة هاتها و ارجع بقيمتها
        return Cache::get('role_routes');
    }

    protected function userRoutes()
    {
        if (!Cache::has('user_routes'))
        {
            Cache::forever('user_routes', auth()->user()->roles[0]->allowed_route );
        }
        return Cache::get('user_routes');
    }
}
