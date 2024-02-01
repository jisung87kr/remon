@props(['id' => null, 'name' => null, 'checked' => false, 'required' => false, 'value' => $value])

<input type="checkbox" id="{{ $id }}" value="{{ $value }}" class="hidden peer" required="" @checked($checked) @required($required)>
<label for="{{ $id }}" {{ $attributes->merge(["class" => "text-sm inline-flex items-center justify-between w-full px-3 py-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"]) }}>
    {{ $slot }}
</label>
