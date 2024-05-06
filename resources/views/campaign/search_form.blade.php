<form action="" x-data="campaignListData">
    @if($category->name)
        <div class="my-10 border-b flex">
            <a href="{{ route("category.show", $category->name) }}" class="block px-4 py-2 {{ $category->name == '전체' ? 'border-b-2 border-indigo-400' : '' }}">전체</a>
            @foreach($category->categories as $child)
                <a href="{{ route("category.show", $child->name) }}" class="block px-4 py-2 {{ $child->name == $category->name ? 'border-b-2 border-indigo-400' : '' }}">{{ $child->name }}</a>
            @endforeach
        </div>
    @else
        <div class="border px-6 rounded-lg my-6">
            <div class="flex flex-col divide-y overflow-hidden h-[160px]"
                 :class="{'open' : open, '!h-auto' : open}">
                <div class="md:flex py-3 items-center">
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">검색어</div>
                    <div class="md:grow">
                        <x-input name="keyword" :value="request()->input('keyword')" class="w-full"></x-input>
                    </div>
                </div>
                <div class="md:flex py-3 items-center">
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">캠페인 타입</div>
                    <div class="md:grow">
                        <ul class="flex flex-wrap gap-3">
                            @foreach($campaignTypes as $type)
                                <li class="">
                                    <x-checkbox-button id="campaign_type_{{$type->id}}"
                                                       name="campaign_type[]"
                                                       value="{{$type->name}}"
                                                       xmodel="campaignType"
                                    >{{ $type->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="md:flex py-3 items-center">
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">제품별</div>
                    <div class="md:grow">
                        <ul class="flex flex-wrap gap-3">
                            @foreach($productCategory->categories as $category2)
                                <li class="">
                                    <x-checkbox-button id="product_{{$category2->id}}"
                                                       name="product[]"
                                                       value="{{$category2->name}}"
                                                       :checked="in_array($category2->name, request()->input('product', []))">{{ $category2->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="md:flex py-3 items-center">
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">유형별</div>
                    <div class="md:grow">
                        <ul class="flex flex-wrap gap-3">
                            @foreach($typeCategory->categories as $category2)
                                <li class="">
                                    <x-checkbox-button id="type_{{$category2->id}}"
                                                       name="type[]"
                                                       value="{{$category2->name}}"
                                                       :checked="in_array($category2->name, request()->input('type', []))">{{ $category2->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <template x-if="hasShippingType">
                    <div class="md:flex py-3 items-center">
                        <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">지역별</div>
                        <div class="md:grow">
                            <ul class="flex flex-wrap gap-3">
                                @foreach($locationCategory->categories as $location)
                                    @foreach($location->categories as $locationChild)
                                        <li>
                                            <x-checkbox-button id="type_{{$locationChild->id}}"
                                                               name="type[]"
                                                               value="{{$locationChild->name}}"
                                                               :checked="in_array($locationChild->name, request()->input('type', []))">{{ $locationChild->name }}</x-checkbox-button>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </template>
            </div>
            <div class="py-3 text-center relative">
                <div class="bg-gradient-to-t from-[#fff] h-[20px] absolute left-0 top-o right-0 top-[-20px]"></div>
                <button type="button" @click="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-chevron-compact-down"
                         :class="{'rotate-180' : !open}"
                         width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 11l8 3l8 -3" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="text-center mb-12">
            <a href="{{ route(request()->route()->getName()) }}" class="button button-gray">초기화</a>
            <button class="button button-default">검색</button>
        </div>
    @endif
</form>
<script>
  const campaignListData = {
    campaignType: @json(request()->input('campaign_type', [])),
    open: false,
    hasShippingType(){
      const filtered = this.campaignType.filter(item => item === '방문형');
      return filtered.length > 0;
    },
    toggle(){
      this.open = !this.open;
      console.log(this.open);
    }
  };
</script>
