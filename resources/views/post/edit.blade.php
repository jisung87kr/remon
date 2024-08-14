<x-board-layout>
    <x-slot name="header">{{ $board->name }}</x-slot>
    @include('post.form', ['method' => 'PUT', 'route' => route('board.post.update', [$board, $post])])
</x-board-layout>
