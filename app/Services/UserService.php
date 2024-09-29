<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function findOrCreate($data)
    {
        // Find user
        $user = User::whereEmail($data['email'])->first();

        if(blank($user)){
            $data['password'] = Hash::make(123456); //default password
            $user = new User();
            $user->fill($data);
            $user->save();
        }

        return $user;
    }
}
