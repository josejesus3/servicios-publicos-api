<?php
namespace App\Services\Auth;

use App\Models\User;

class UserRegistrationService {

    public function userCreate( array $data ) {

        return User::create( $data );
    }
}