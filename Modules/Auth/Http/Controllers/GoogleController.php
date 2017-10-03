<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\Http\Requests;
use App\Http\Controllers\AppBaseController;
use AdamWathan\EloquentOAuth\Facades\OAuth;
use Redirect;

class GoogleController extends AppBaseController
{
    public function googleAuthorize()
    {
        return OAuth::authorize('google');
    }

    public function login()
    {

        try {
            OAuth::login('google', function ($user, $details) {
                $user->name = $details->raw()['name'];
                $user->email = $details->raw()['email'];
                $user->remember_token = $details->access_token;
                $user->password = '';
                $user->save();
                $user->roles()->syncWithoutDetaching([1]);

                \Auth::guard()->login($user);
            });
        } catch (ApplicationRejectedException $e) {
            // User rejected application
        } catch (InvalidAuthorizationCodeException $e) {
            // Authorization was attempted with invalid
            // code,likely forgery attempt
        }
        return Redirect::intended('');
    }
}
