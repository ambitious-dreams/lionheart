<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class UserRepository extends Repository {

    public function __construct(User $model){
        $this->model = $model;
    }

    public function findOAuthUser($provider, $userData) {

        return $this->model
                ->where($provider.'_id', $userData->getId())
                ->first();
    }

    public function validateOAuthUser($userData) {

        $data = ['email' => $userData->getEmail()];
        $rules = ['email' => 'required|email|unique:users,email'];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors =  $validator->errors()->all();
            Session::put('errors', implode(', ', $errors));
            return redirect('/');
        }

        return true;
    }

    public function createOAuthUser($userData, $provider) {

        $names = $this->getOAuthUserNames($userData);

        $user = new User;
        $user->name = $names['name'];
        $user->surname = $names['surname'];
        $user->avatar_url = $userData->getAvatar();
        $user->email = $userData->getEmail();
        $user->password = bcrypt(Str::random(10));
        $user->{$provider.'_id'} = $userData->getId();
        $user->save();

        return $user;
    }

    public function getOAuthUserNames($userData) {

        $nickParts = explode(' ', $userData->getName());
        $name = $nickParts[0];
        $surnameParts = $nickParts;
        if (count($nickParts) > 1) { unset($surnameParts[0]); }
        $surname = count($nickParts) > 1 ? implode(' ', $surnameParts) : $name;

        return compact('name', 'surname');
    }

    public function logIn($user) {

        Auth::loginUsingId($user->id);
    }
}
