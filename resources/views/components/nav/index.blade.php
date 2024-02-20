@props(['active' => false ])
<li class="nav-group" x-data="{ expanded: {{ $active ? 'true' : 'false' }} }">
    {{ $slot }}
    @isset($label)
    {{ $label }}
    @endisset
    @isset($group)
    <ul class="nav-group-child" x-show="expanded" x-collapse style="display: none">
       {{ $group }}
    </ul>
    @endisset
</li>
