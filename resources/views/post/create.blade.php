<x-help-layout>
    <x-slot name="header">{{ $board->name }}</x-slot>
    @include('post.form', ['method' => 'POST', 'route' => route('board.post.store', $board)])
</x-help-layout>
