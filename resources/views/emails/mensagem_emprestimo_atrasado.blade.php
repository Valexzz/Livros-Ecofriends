<x-mail::message>

Olá, {{$emprestimo->user->name}}!
O prazo de devolução do empréstimo do livro "{{$emprestimo->livro->titulo}}" está atrasado!

Prazo de devolução: {{$emprestimo->devolucao}}
<x-mail::panel >
Vá para o IFTO Campus Palmas para devolver o livro a alguém responsável da administração que possa confirmar sua devolução!
</x-mail::panel>

</x-mail::message>
