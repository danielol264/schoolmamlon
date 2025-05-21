<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\alumno;
use App\Models\maestro;
use App\Models\grupo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(){
        $maestro=maestro::whereDoesntHave('user')->get();
        $alumnos = alumno::whereDoesntHave('user')->get();
        $grupos=grupo::all();
        return view('administracion.register',["maestros"=>$maestro,"grupos"=>$grupos,"alumnos"=>$alumnos]);
    }
    public function actualizarContraseña(Request $request, User $user){
        $validated=$request->validate([
            'password' => 'required|string|confirmed',
        ]);
        try{
        $user->password=Hash::make($validated['password']);
        session()->flash('success','La contraseña se actualizo correctamente');

        }catch(\Exception $e){
            session()->flash('error','La contraseña no se actualizo correctamente');
        }
        return view('administracion.dashboard');
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|confirmed',
            'ROL' => 'required|in:A,M,G',
        ];
    
        // Validaciones condicionales
        if ($request->ROL === 'A') {
            $rules['id_alumno'] = 'required|integer';
            $rules['id_grupo'] = 'required|integer';
        } elseif ($request->ROL === 'M') {
            $rules['id_maestro'] = 'required|integer';
           
        } 
        // Ejecutar validación
        $validatedData = $request->validate($rules);
    
        // Hasheo de contraseña
        $validatedData['password'] = Hash::make($validatedData['password']);
        try{
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = $validatedData['password'];
            $user->ROL = $validatedData['ROL'];

            if ($user->ROL === 'M') {
                $user->id_maestro = $validatedData['id_maestro'];
                $user->id_grupo=null;
                $user->id_alumno=null;
            } elseif ($user->ROL === 'A') {
                $user->id_maestro =null;
                $user->id_alumno = $validatedData['id_alumno'];
                $user->id_grupo = $validatedData['id_grupo'] ;
            }
            else {
                $user->id_maestro = null;
                $user->id_alumno = null;
                $user->id_grupo = null;
            }
            $user->save();
            session()->flash('success','El usuario se registro correctamente');
        }catch(\Exception $e){
            session()->flash('error','El usuario no se registro correctamente');
        }
        return redirect()->route('administracion.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        $maestro=maestro::whereDoesntHave('user')->get();
        $alumnos = alumno::whereDoesntHave('user')->get();
        $grupos=grupo::all();
        return view('administracion.edit',["user"=>$user,"maestros"=>$maestro,"grupos"=>$grupos,"alumnos"=>$alumnos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'ROL' => 'required|in:A,M,G',
            'id_maestro' => 'nullable|exists:maestros,id',
            'id_alumno' => 'nullable|exists:alumnos,id',
            'id_grupo' => 'nullable|exists:grupos,id',
        ]);
        try{
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->ROL = $validatedData['ROL'];

            if ($user->ROL === 'M') {
                $user->id_maestro = $validatedData['id_maestro'] ?? null;
                $user->id_grupo=null;
                $user->id_alumno=null;
            } elseif ($user->ROL === 'A') {
                $user->id_maestro =null;
                $user->id_alumno = $validatedData['id_alumno'] ?? null;
                $user->id_grupo = $validatedData['id_grupo'] ?? null;
            }

            $user->save();
            session()->flash('success','El usuario se actualizo correctamente');
        }catch(\Exception $e){
            session()->flash('error','El usuario no se actualizo correctamente');
            return redirect()->route('administracion.dashboard');
        }
        return view('administracion.dashboard');
    }


    public function destroy(user $user)
    {
        try{
            $user->delete();
            session()->flash('success','Usuario eliminado correctamente');
            return redirect()->route('administracion.dashboard');
        }catch(\Exception $e){
            session()->flash('error','El usuario no se elimino correctamente');
            return redirect()->route('administracion.dashboard');
                }
    }
}
