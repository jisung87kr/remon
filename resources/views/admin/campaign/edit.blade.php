<x-admin-layout>
    @include('campaign.form', ['action' => route('admin.campaign.update', $campaign), 'method' => 'PUT'])
</x-admin-layout>
