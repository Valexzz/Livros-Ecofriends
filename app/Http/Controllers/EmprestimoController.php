<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Models\Emprestimo;
use App\Models\User;
use App\Models\Livro;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

use App\Mail\MensagemEmprestimo;
use Illuminate\Support\Facades\Mail;

use App\Jobs\EmprestimoJob;

class EmprestimoController extends Controller
{
    public function index(){
        $emprestimos = Emprestimo::with(['user', 'livro'])->whereNotIn('status', ['recusado', 'devolvido'])->where('user_id', Auth::id())->get();
        $emprestimos_devolvidos = Emprestimo::with(['user', 'livro'])->whereIn('status', ['recusado', 'devolvido'])->where('user_id', Auth::id())->get();
        return view('index.emprestimos', ['emprestimos' => $emprestimos, 'emprestimos_devolvidos' => $emprestimos_devolvidos]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $emprestimo = new Emprestimo;
        $emprestimo->user_id = Auth::id();
        $emprestimo->livro_id = $request->input('livro');

        $livro = Livro::find($request->input('livro'));
        if ($livro->estoque > 0){
            $livro->estoque -= 1;
        } else {
            return redirect('/emprestimos')->with('error', 'Erro ao cadastrar empréstimo! Tente novamente.');
        }

        $livro->save();
        $emprestimo->save();

        $emprestimo_usuario = Emprestimo::with(['user', 'livro']);
        $emprestimo_usuario = $emprestimo_usuario->find($emprestimo->id);

        dispatch(new EmprestimoJob($emprestimo));

        return redirect('/emprestimos#emprestimosTable')->with('success', 'Empréstimo feito com sucesso, vá para o IFTO Campus Palmas e contate um administrador para confirmar seu empréstimo e pegar seu livro!');
    }
    
}
