<x-mail::message>

Olá, {{$emprestimo->user->name}}!
Você fez um empréstimo do livro "{{$emprestimo->livro->titulo}}" às {{$emprestimo->created_at}}

<x-mail::panel >
Vá para o IFTO Campus Palmas para pegar o livro e que alguém responsável da administração possa confirmar seu empréstimo!
</x-mail::panel>

</x-mail::message>
