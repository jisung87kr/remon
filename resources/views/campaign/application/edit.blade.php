<x-app-layout>
    @include('campaign.application.form', ['route' => route('campaign.application.update', [$campaign, $campaignApplication]), 'method' => 'PUT'])
</x-app-layout>
