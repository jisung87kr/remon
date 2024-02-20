<x-admin-layout>
    @include('campaign.form', ['action' => route('admin.campaigns.update', $campaign), 'method' => 'PUT'])
</x-admin-layout>
