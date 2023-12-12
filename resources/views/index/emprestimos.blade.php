@extends('layouts.layout')

@section('conteudo')

@if (session('success'))
    <div class="modal fade" tabindex="-1" id="successModal" aria-labelledby="modal-success" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Empréstimo feito com sucesso!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ session('success') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" >OK</button>
                </div>
            </div>
        </div>
    </div>
@elseif (session('error'))
    <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Erro ao fazer empréstimo!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ session('error') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" >OK</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-header" id="emprestimosTable">
        Seus empréstimos
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emprestimos as $e)             
                        <tr>
                            <td>{{ $e->livro->titulo }}</td>
                            <td>{{ $e->data_emprestimo ? $e->data_emprestimo->format('d/m/Y') : 'Ainda não confirmado!'}}</td>
                            <td>{{ $e->devolucao ? $e->devolucao->format('d/m/Y').' às 00:00' : 'Não confirmada!'}}</td>
                            <td>{{ $e->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
    
            </table>
        </div>
    </div>
</div>
@if ($emprestimos_devolvidos)
    <div class="card mt-4 old-card">
        <div class="card-header">
            Empréstimos recusados ou devolvidos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-secondary">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emprestimos_devolvidos as $e)             
                            <tr>
                                <td>{{ $e->livro->titulo }}</td>
                                <td>{{ $e->data_emprestimo ? $e->data_emprestimo->format('d/m/Y') : 'Não confirmada!'}}</td>
                                <td>{{ $e->devolucao ? $e->devolucao->format('d/m/Y') : 'Não confirmada!'}}</td>
                                <td>{{ $e->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
        
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

@section('script')

@if(session('success'))
<script type="module">
    $(document).ready(function(){
        const success_modal = new bootstrap.Modal('#successModal')
        success_modal.show()
    });
</script>
@endif

@endsection