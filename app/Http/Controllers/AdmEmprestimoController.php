<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Models\Emprestimo;
use App\Models\User;
use App\Models\Livro;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;

use App\Jobs\EmprestimoConfirmadoJob;
use App\Jobs\EmprestimoDevolvidoJob;
use App\Jobs\EmprestimoRecusadoJob;

class AdmEmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        $livros = Livro::all();
        $emprestimos = Emprestimo::with(['user', 'livro'])->whereNotIn('status', ['devolvido', 'recusado']);
        $emprestimos_devolvidos = Emprestimo::with(['user', 'livro'])->whereIn('status', ['devolvido', 'recusado']);

        $emprestimos->whereHas('user', function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        });

        $emprestimos->whereHas('livro', function ($query) use ($request) {
            $query->where('titulo', 'like', '%' . $request->input('titulo') . '%');
        });

        $emprestimos->where('status', 'like', '%' . $request->input('status') . '%') ;

        $emprestimos = $emprestimos->get();
        $emprestimos_devolvidos = $emprestimos_devolvidos->get();

        return view('adm.emprestimos', ['emprestimos' => $emprestimos, 'emprestimos_devolvidos' => $emprestimos_devolvidos, 'users' => $users, 'livros' => $livros]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $user = Auth::user();
        $emprestimo = new Emprestimo;

        $emprestimo->user_id = $request->input('user');
        $emprestimo->livro_id = $request->input('livro');
        $emprestimo->devolucao = Carbon::today()->addDays(3);

        $emprestimo->save();

        return redirect('adm/emprestimos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $emprestimo = Emprestimo::with(['user', 'livro'])->find($id);

        return view('adm.emprestimo', ['emprestimo' => $emprestimo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $status)
    {
        $emprestimo = Emprestimo::with(['user', 'livro'])->find($id);
        $livro = Livro::find($emprestimo->livro_id);
        $emprestimo->status = $status;

        if($status == 'confirmado'){
            $emprestimo->data_emprestimo = Carbon::today();
            $emprestimo->devolucao = Carbon::today()->addDays(3);

        }

        if (($status == 'confirmado' || $status == 'pendente') && $livro->estoque < 0){
            return redirect('adm/emprestimos#emprestimosTable')->with('error-update', 'Erro ao atualizar status do empréstimo! Tente novamente.');
        }
        else if ($status == 'recusado' || $status == 'devolvido'){
            $livro->estoque += 1;
        }
        $emprestimo->save();
        $livro->save();

        if($status == 'confirmado'){
            dispatch(new EmprestimoConfirmadoJob($emprestimo));
        } 
        else if($status == 'recusado'){
            dispatch(new EmprestimoRecusadoJob($emprestimo));
        }
        else if($status == 'devolvido'){
            dispatch(new EmprestimoDevolvidoJob($emprestimo));
        }
        
        return redirect('adm/emprestimos#emprestimo-'.$emprestimo->id)->with('success-update', 'Empréstimo '.$status.' com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $emprestimo = Emprestimo::find($id);
        Emprestimo::destroy($id);
        $livro = Livro::find($emprestimo->livro_id);
        if ($livro->status != 'recusado' || $livro->status != 'devolvido'){
            $livro->estoque += 1;
        }

        return redirect('adm/emprestimos#emprestimosTable')->with('success-delete', 'Empréstimo deletado com sucesso!');
    }
}
