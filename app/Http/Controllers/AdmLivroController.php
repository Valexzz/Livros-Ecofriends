<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Models\Livro;
use App\Models\Emprestimo;
use App\Models\AreaConhecimento;

use Illuminate\Support\Facades\Validator;

class AdmLivroController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $livros = Livro::withCount([
            'emprestimos' => function ($query) {
                $query->whereNotIn('status', ['recusado', 'devolvido']);
            }
        ])->with('areaConhecimento:id,descricao');
        $areas_conhecimento = AreaConhecimento::get();

        foreach ($request->only(['titulo', 'area_conhecimento_id', 'numero_cadastro']) as $tabela => $pesquisa){
            if ($pesquisa){
                $livros->where($tabela, 'like', '%'.$pesquisa.'%');
            }
        }

        $livros = $livros->get();
        
        return view('adm.livros', ['livros' => $livros, 'areas_conhecimento' => $areas_conhecimento]  );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $livro = new Livro;

        $validator = $request->validate([
            'titulo' => ['required', 'max:100', 'min:6',],
            'area_conhecimento' => ['required'],
            'numero_cadastro' => ['required', 'unique:livros'],
            'estoque' => ['required', 'integer', 'min:1'],
        ]);
        
        $livro->titulo = $request->input('titulo');
        $livro->area_conhecimento_id = $request->input('area_conhecimento');
        $livro->numero_cadastro = $request->input('numero_cadastro');
        $livro->estoque = max(1, round($request->input('estoque')));

        $livro->save();

        return redirect('adm/livros')->with('success-store', 'Livro cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $livro = Livro::with('areaConhecimento:id,descricao')->find($id);

        return view('adm.livro', ['livro' => $livro]);
    }

    public function edit(string $id)
    {
        $livro = Livro::withCount('emprestimos')->find($id);
        return response()->json($livro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $livro = Livro::find($id);
        $livro->titulo = $request->input('titulo');
        $livro->area_conhecimento_id = $request->input('area_conhecimento');
        $livro->numero_cadastro = $request->input('numero_cadastro');
        $livro->estoque = max(0, round($request->input('estoque')));
        $livro->save();

        return redirect("adm/livros")->with('success-update', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $emprestimos = new Emprestimo; 
        $livro = Livro::withCount([
            'emprestimos' => function ($query) {
                $query->whereNotIn('status', ['recusado', 'devolvido']);
            }
        ])->find($id);

        if(!$livro->emprestimos_count){
            $emprestimos->whereIn('status', ['recusado', 'devolvido'])
                        ->where('livro_id', $id)
                        ->delete();
            Livro::destroy($id);
            return redirect("adm/livros#booksTable")->with('success-delete', 'Livro removido com sucesso! Empréstimos devolvidos e recusados desse livro também foram removidos.');
        }
        return redirect("adm/livros#booksTable")->with('error-delete', 'Erro ao deletar livro! Tente novamente.');
    }
}
