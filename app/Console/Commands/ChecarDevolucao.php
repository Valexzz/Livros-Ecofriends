<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use App\Mail\MensagemEmprestimoAviso;
use App\Mail\MensagemEmprestimoAtrasado;

use Carbon\Carbon;

use App\Models\Emprestimo;

use App\Jobs\EmprestimoAvisoJob;
use App\Jobs\EmprestimoAvisoAtrasado;

class ChecarDevolucao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checar-devolucao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Avisa ao usuário 2 dias antes sobre a data de devolução do livro';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emprestimos_avisos = Emprestimo::with(['user', 'livro'])
            ->where('devolucao', '>=', Carbon::today())
            ->where('devolucao', '<=', Carbon::today()->addDays(3))
            ->where('status', 'confirmado')
            ->get();

        $emprestimos_atrasados = Emprestimo::with(['user', 'livro'])
            ->where('devolucao', '<', Carbon::now())
            ->where('status', 'confirmado')
            ->get();

        foreach ($emprestimos_avisos as $e) {
            dispatch(new EmprestimoAvisoJob($e));
        }

        foreach ($emprestimos_atrasados as $e) {
            $e->status = 'atrasado';
            $e->save();
            dispatch(new EmprestimoAtrasadoJob($e));
        }
    }
}
