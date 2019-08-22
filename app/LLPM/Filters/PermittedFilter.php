<?php

namespace LLPM\Filters;

use Auth;
use Flash;
use Redirect;

class PermittedFilter {

    public function filter($route, $request)
    {
        $permitted = true;
        
        $user = Auth::user();

        foreach($user->roles as $role) {

            foreach($role->permissions as $permission) {

                if($permission->route_name == ($route->getName())) {
                    $permitted = false;
                    break;                   
                }

            }
        }
       
        if(!$permitted) {
            Flash::warning('You are not allowed to access the requested page! ' . $route->getName());
            return Redirect::back();
        }
    }

}