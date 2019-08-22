<?php namespace LLPM\Users\Events;

use User;

class UserWasRegistered {

    public $user;

    public function __construct(User $user) /* or pass in just the relevant fields */
    {
        $this->user = $user;
    }

}