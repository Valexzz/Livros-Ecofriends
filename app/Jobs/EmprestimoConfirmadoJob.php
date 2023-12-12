<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\MensagemEmprestimoConfirmado;

class EmprestimoConfirmadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emprestimo;
    
    /**
     * Create a new job instance.
     */
    public function __construct($emprestimo)
    {
        $this->emprestimo = $emprestimo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->emprestimo->user->email)->send(new MensagemEmprestimoConfirmado($this->emprestimo));
    }
}
