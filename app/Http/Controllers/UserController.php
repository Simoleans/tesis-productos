<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Log};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->has('searchTerm')) {
            $query = User::where('name', 'like', "%".request('searchTerm')."%");

            if($query->count() == 0) {
                return redirect()->route('users.index')->with('success', 'No se encontraron resultados');
            }else{
                return view('users.index', [
                    'users' => $query->where('id','!=',auth()->user()->id)->paginate(10)
                ]);
            }

        }
        return view('users.index', [
            'users' => User::where('id','!=',auth()->user()->id)->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'confirmed|required|min:8',
        ],
        [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser un email válido',
            'email.unique' => 'El email ya está en uso',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
        ]);

        Log::create([
            'user_id' => auth()->user()->id,
            'message' => 'Creó al usuario '.$request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('users.edit', [
            'user' => User::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ],
        [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser un email válido',
            'email.unique' => 'El email ya está en uso',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol = $request->rol;
        $user->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'message' => 'Editó al usuario '.$request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //disabled
    public function disabled(Request $request)
    {
        $user = User::find($request->id);
        $user->status = 0;
        $user->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'message' => 'Inhabilitó al usuario '.$user->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario inhabilitado correctamente');
    }

    //enabled
    public function enabled(Request $request)
    {
        $user = User::find($request->id);
        $user->status = 1;
        $user->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'message' => 'Habilitó al usuario '.$user->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario habilitado correctamente');
    }

    //passUpdate
    public function passUpdate(Request $request)
    {
        $user = User::find($request->id);
        $user->password = Hash::make('12345678');
        $user->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'message' => 'Cambio la contraseña del usuario '.$user->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Contraseña cambiada a "12345678", el usuario la cambia en su perfil');
    }
}
