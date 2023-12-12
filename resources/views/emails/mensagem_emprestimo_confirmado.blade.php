<x-mail::message>

Olá, {{$emprestimo->user->name}}!
Seu empréstimo do livro "{{$emprestimo->livro->titulo}}" foi confirmado às {{$emprestimo->data_emprestimo}}!

Prazo de devolução: {{$emprestimo->devolucao}}
<x-mail::panel >
Para devolver, vá para o IFTO Campus Palmas para devolver o livro a alguém responsável da administração.
Devolva antes do prazo de devolução!
</x-mail::panel>

</x-mail::message>
