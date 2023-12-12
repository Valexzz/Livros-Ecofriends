<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function cadastro() {
        return view('auth.register');
    } 

    public function login(){
        return view('auth.login');
    }

    public function store(Request $request ): RedirectResponse
    {
        $user = new User;
        $user->matricula = $request->input('matricula');
        $user->name = $request->input('nome');
        $user->password = $request->input('password');
        $user->curso_id = $request->input('curso');
        $user->email = $request->input('email');
        $user->ano = $request->input('ano');
        $user->telefone = $request->input('telefone');
        $user->save();
        
        //event(new Registered($user));
        return  redirect('cadastro');
    }

    public function autenticar(Request $request): RedirectResponse
    { 
        
        $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required'],
        ]);

        $email = $request->input('email');
        $senha = $request->input('senha');
        
        $user = new User;
        $user = $user->where('email', $email)->where('senha', $senha)->get()->first();
        
        if (isset($user->name)){
           session_start();
           $_SESSION['id'] = $user->id;
           $_SESSION['adm'] = $user->adm;
            return redirect()->route('livros.index');
        }
        return redirect()->route('auth.login');
    }

    public function avisoVerificar(){
        return view('auth.verificar_email');
    }
}
