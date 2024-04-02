<x-app-layout>
    @include('campaign.application.form', ['route' => route('campaign.application.store', [$campaign]), 'method' => 'POST'])
</x-app-layout>
