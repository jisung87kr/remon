<x-admin-layout>
    @include('campaign.form', ['action' => route('admin.campaigns.store'), 'method' => 'POST'])
</x-admin-layout>
