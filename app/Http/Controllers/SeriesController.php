<?php

namespace App\Http\Controllers;

use App\Serie;
use App\Http\Requests\SeriesFormRequest;
use Illuminate\Http\Request;


//extends Controller -> herda da pasta controller
class SeriesController extends Controller
{
    //método index() //Request para pegar a mensagem da sessão
    public function index(Request $request) {
        $series = Serie::query()
            ->orderBy('nome')
            ->get();

        // passando a variável série para a view como parâmetro (segundo parâmetro do return)
        // return view ('series.index', [
        //     'series' => $series
        // ]);

        // * em caso de chave e valor com mesmo nome pode ser usado a função compact do php

        // pegando a mesagem na sessão
        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view ('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        // $nome = $request->nome;
        // $serie = Serie::create([
        //     'nome' => $nome
        // ]);

        // --> uma das formas de validação // essa foi transferida para o Request(SeriesFormRequest)

        // $request ->validate([
        //     'nome' => 'required|min:3'
        // ]);

        $serie = Serie::create($request->all());

        //pegando sessão na requisição e adiciona item msg
        $request->session()
            ->flash(
                'mesangem',
                "Série {$serie->id} criada com sucesso {$serie->nome}"
            );

            return redirect()->route('listar_series');
    }

    public function destroy(Request $request)
    {
        Serie::destroy($request->id);
        $request->session()
            ->flash(
                'mesangem',
                "Série  {$serie->nome} removida com sucesso!"
            );

            return redirect()->route('listar_series');
    }
}
