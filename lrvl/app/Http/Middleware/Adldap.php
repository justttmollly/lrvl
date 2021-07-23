<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class Adldap
{
//    use Helper;
    public $attributes;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */

    public function handle(Request $request, Closure $next)
    {
        $authenticated = false;

        if ($email = $request->getUser() && $password = $request->getPassword()) {
            Log::info("Authenticate user using basic auth");
            $credentials = array(
                'samaccountname' => $request->getUser(),
                'password' => $request->getPassword()
            );
            //
            $authenticated = $this->authLdapUser($credentials);

            if($authenticated) {
                $user = $this->getLdapUser($request->getUser());
            }
        }
        if (!empty($user)) {
            $authenticated = true;
            if(!$this->checkRoles($user['groups'], $role)) {
                return response("User is not authorize for this request.", 401);
            }
            $request->attributes->add(['user_groups' => $user['groups']]);
            return $next($request);
        }

        if (!$authenticated) {
            return response("Unauthorized: Access is denied due to invalid credentials.", 401);
        }
    }
        //return $next($request);
}
