<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\CheckGroupMembership as Middleware;

class CheckGroupMembership extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    
    public function handle($request, Closure $next, $groupName)
    {
        if(Auth::user()->isInGroup($groupName)) {
            return $next($request);
        }
        return redirect()->route('home')->with('error', 'アクセス権限がありません');
    }
}
