<?php namespace LLPM;

use Auth;

trait AccessTrait {
	
	public function getAccess()
	{
        $access = $this->getProperties();

        // dd(!Auth::user());

        if(!Auth::user()) {
            return $access;
        }

        $role = Auth::user()->roles->first();

    	if(! $role->permissions->isEmpty()) {

    	    foreach($role->permissions as $permission) {

                if($permission->route_name == 'users') {
                    $access['allowViewUsers'] = 'hidden';
                    // dd($access['allowViewUsers']);
                }

                if($permission->route_name == 'roles') {
                    $access['allowViewUserRoles'] = 'hidden';
                }

    	        if($permission->route_name == 'action.container.confirmation') {
    	            $access['allowContainerConfirmation'] = 'hidden';
    	        }

    	        if($permission->route_name == 'action.container.confirmation.bypass') {
    	            $access['allowContainerConfirmationBypass'] = 'hidden';
    	        }

    	        if($permission->route_name == 'action.container.confirmation.cancel') {
    	            $access['allowContainerConfirmationCancel'] = 'hidden';
    	        }	        	        
    	    }
    	}

        return $access;	
	}

    protected function getProperties()
    {
        return $props = [
            'allowViewUsers' => '',
            'allowViewUserRoles' => '',
            'allowContainerConfirmation' => '',
            'allowContainerConfirmationBypass' => '',
            'allowContainerConfirmationCancel' => ''
        ];
    }
}