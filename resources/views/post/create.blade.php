<x-help-layout>
    <x-slot name="header">{{ $board->name }}</x-slot>
    <form action="" class="mt-6">
        <div class="flex gap-1 flex-wrap">
            <button type="button" class="button button-gray-outline shrink-0">카테고리1</button>
            <button type="button" class="button button-gray-outline shrink-0">카테고리2</button>
            <button type="button" class="button button-gray-outline shrink-0">카테고리1</button>
        </div>
        <div class="mt-3">
            <input type="text" class="form-control">
            <textarea name="" id="" cols="30" rows="10" class="form-control mt-3"></textarea>
            <div class="text-center mt-6">
                <a href="" class="button button-gray-outline">취소</a>
                <input type="submit" class="button button-gray" value="등록">
            </div>
        </div>
    </form>
</x-help-layout>
