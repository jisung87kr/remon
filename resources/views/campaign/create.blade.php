<x-app-layout>
    @include('campaign.form', ['action' => route('campaigns.store'), 'method' => 'POST'])
</x-app-layout>
