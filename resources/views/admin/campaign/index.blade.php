<x-admin-layout>
    @include('campaign.list', ['campaigns' => $campaigns, 'category' => $category, 'mode' => 'admin'])
</x-admin-layout>
