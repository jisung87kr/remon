<x-app-layout>
    @include('campaign.form', ['action' => route('campaigns.update', $campaign), 'method' => 'PUT'])
</x-app-layout>
