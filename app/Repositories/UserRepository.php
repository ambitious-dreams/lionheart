<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class UserRepository extends Repository {

    public function __construct(User $model){
        $this->model = $model;
    }

    public function createOrFindOAuthUser($provider, $providerID, $details) {

        $user = $this->model
                ->where($provider.'_id', $providerID)
                ->first();

        if ($user) {
            return compact('user');
        }

        $validationResult = $this->validateOAuthUser($details);

        if ($validationResult !== true) {
            return $validationResult;
        }

        $names = $this->getOAuthUserNames($details);
        $user = $this->createOAuthUser($details, $names, $provider, $providerID);

        return compact('user');
    }

    public function validateOAuthUser($details) {

        $data = ['email' => $details['email']];
        $rules = ['email' => 'required|email|unique:users,email'];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors =  $validator->errors()->all();
            Session::put('errors', implode(', ', $errors));
            return redirect('/');
        }

        return true;
    }

    public function getOAuthUserNames($details) {

        $nickParts = explode(' ', $details['name']);
        $name = $nickParts[0];
        $surnameParts = $nickParts;
        if (count($nickParts) > 1) { unset($surnameParts[0]); }
        $surname = count($nickParts) > 1 ? implode(' ', $surnameParts) : $name;

        return compact('name', 'surname');
    }

    public function createOAuthUser($details, $names, $provider, $providerID) {

        $user = new User;
        $user->name = $names['name'];
        $user->surname = $names['surname'];
        $user->avatar_url = $details['avatar'];
        $user->email = $details['email'];
        $user->password = bcrypt(Str::random(10));
        $user->{$provider.'_id'} = $providerID;
        $user->save();

        return $user;
    }
}
