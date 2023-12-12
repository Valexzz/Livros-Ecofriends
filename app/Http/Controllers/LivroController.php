<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\AreaConhecimento;

class LivroController extends Controller
{
    public function index(Request $request){
        $livros = Livro::with('areaConhecimento:id,descricao')->where('estoque', '>', '0');
        $areas_conhecimento = AreaConhecimento::get();
        
        foreach ($request->only(['titulo', 'area_conhecimento_id', 'numero_cadastro']) as $tabela => $pesquisa){
            if ($pesquisa){
                $livros->where($tabela, 'like', '%'.$pesquisa.'%');
            }
        }

        $livros_fora = Livro::with('areaConhecimento:id,descricao')->where('estoque', '0');
        $livros = $livros->get();
        $livros_fora = $livros_fora->get();

        return view('index.livros', ['livros' => $livros, 'livros_fora' => $livros_fora, 'areas_conhecimento' => $areas_conhecimento]);

    }

    public function livro(string $id){

        $livro = Livro::with('areaConhecimento:id,descricao')->find($id);

        return view('index.livro', ['livro' => $livro]);
    }
}
