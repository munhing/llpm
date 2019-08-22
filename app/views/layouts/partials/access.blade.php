<?php
	$role = Auth::user()->roles->first();

    $allowViewUsers = '';
    $allowViewUserRoles = '';
	$allowContainerConfirmation = '';
	$allowContainerConfirmationBypass = '';
	$allowContainerConfirmationCancel = '';

	if(! $role->permissions->isEmpty()) {
	    foreach($role->permissions as $permission) {

            if($permission->route_name == 'users') {
                $allowViewUsers = 'hidden';
            }

            if($permission->route_name == 'roles') {
                $allowViewUserRoles = 'hidden';
            }

	        if($permission->route_name == 'action.container.confirmation') {
	            $allowContainerConfirmation = 'hidden';
	        }
	        if($permission->route_name == 'action.container.confirmation.bypass') {
	            $allowContainerConfirmationBypass = 'hidden';
	        }

	        // if($permission->route_name == 'action.container.confirmation.cancel') {
	        //     $allowContainerConfirmationCancel = 'hidden';
	        // }	        	        
	    }
	}
    // dd('Access');	
?>