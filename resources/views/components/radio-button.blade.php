@props(['id' => null, 'name' => null, 'checked' => false, 'required' => false, 'value' => $value, "xmodel" => null])

<input type="radio" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" class="hidden peer" @checked($checked) @required($required) @if($xmodel)x-model="{{$xmodel}}"@endif>
<label for="{{ $id }}" {{ $attributes->merge(["class" => "text-sm inline-flex items-center justify-between px-3 py-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100"]) }}>
    {{ $slot }}
</label>
