<x-admin-layout>
    @include('campaign.form', ['action' => route('admin.campaign.store'), 'method' => 'POST'])
</x-admin-layout>
