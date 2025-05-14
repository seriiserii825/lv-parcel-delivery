
<?php
namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function register($fields)
    {
        $fields['password'] = Hash::make($fields['password']);
        $fields['role'] = 'admin';

        $user = User::create($fields);

        $token = $user->createToken($fields['name'])->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}

