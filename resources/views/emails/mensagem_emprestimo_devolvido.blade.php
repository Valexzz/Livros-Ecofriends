<x-mail::message>

Olá, {{$emprestimo->user->name}}!
Você devolveu o livro "{{$emprestimo->livro->titulo}}" antes da validade do empréstimo!

</x-mail::message>
