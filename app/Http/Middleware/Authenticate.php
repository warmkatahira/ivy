<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        /* if (! $request->expectsJson()) {
            return route('login');
        } */

        // 接続しようとしていたURI別でリダイレクト先を設定
        if (! $request->expectsJson()) {
            $URI = explode("/", $request->getRequestUri());
            switch ($URI[1]){
                //管理画面が https/xxx.xxx/admin/xxxxxのケース
                case 'data':
                return route('dashboard');
                //管理画面が https/xxx.xxx/shop_admin/xxxxxのケース
                case 'inventory':
                return route('dashboard');
                case 'maintenance';
                return route('dashboard');
            }
        }
    }
}
