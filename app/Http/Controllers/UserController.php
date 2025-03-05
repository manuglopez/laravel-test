<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function check_update(string $name, string $email)
    {
        // TASK: find a user by $name and update it with $email
        //   if not found, create a user with $name, $email and random password
        //$user = NULL; // updated or created user
        // Buscar un usuario por el nombre
    $user = User::where('name', $name)->first();

    if ($user) {
        // Si el usuario existe, actualiza su email si es diferente
        if ($user->email !== $email) {
            $user->update(['email' => $email]);
        }
    } else {
        // Si el usuario no existe, lo crea con un password aleatorio
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('secret'),
        ]);
    }

        return $user->name;
    }
}
