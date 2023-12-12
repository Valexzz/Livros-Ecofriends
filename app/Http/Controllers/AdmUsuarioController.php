<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Emprestimo;
use App\Models\Curso;
use Illuminate\Http\RedirectResponse;

class AdmUsuarioController extends Controller
{
    public function index(Request $request){
        $users = User::with('curso')->orderByDesc('adm');
        $cursos = Curso::orderBy('descricao');
        $emprestimos = Emprestimo::with('user')->where('status', '!=', 'recusado')->where('status', '!=', 'devolvido');

        foreach ($request->only(['matricula', 'curso_id', 'name']) as $tabela => $pesquisa){
            if($pesquisa){
                $users->where($tabela, 'like', '%'.$pesquisa.'%');
            }
        }
        
        $emprestimos = $emprestimos->get();
        $users = $users->get();
        $cursos = $cursos->get();

        return view('adm.usuarios', ['users' => $users, 'emprestimos' => $emprestimos, 'cursos' => $cursos]);
    }

    public function giveAdm($id, $give): RedirectResponse
    {
        $adm = $give ? '1' : '0';
        $user = User::find($id);
        $user->adm = $adm;
        $user->save();
        
        return redirect('adm/usuarios#id-'.$id);
    }

    public function destroy(string $id): RedirectResponse
    {
        $emprestimos = new Emprestimo; 

        $user = User::withCount([
            'emprestimos' => function ($query) {
                $query->whereNotIn('status', ['recusado', 'devolvido']);
            }
        ])->find($id);

        if(!$user->emprestimos_count){
            $emprestimos->whereIn('status', ['recusado', 'devolvido'])
            ->where('user_id', $id)
            ->delete();
            User::destroy($id);
            return redirect("adm/usuarios#usersTable")->with('success-delete', 'Usuário removido com sucesso! Empréstimos devolvidos e recusados desse usuário também foram removidos.');
        }

        return redirect('adm/usuarios#usersTable')->with('error-delete', 'Erro ao deletar usuário, tente novamente mais tarde!');;
    }
}
