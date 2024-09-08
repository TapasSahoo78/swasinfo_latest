<div>
    <h2 class="text-medium leading-snug text-slate-800 font-bold mb-2">Overview</h2>
    <p class="mb-6">{{ $productData->description ? $productData->description : '' }}</p>
</div>
<div>
    <h2 class="text-medium leading-snug text-slate-800 font-bold mb-2">Price :<span
            class="text-sm text-slate-600 font-medium ml-2">${{ $productData->price ? number_format($productData->price, 2) : '0.00' }}</span>
    </h2>
</div><br>
<div>
    <h2 class="text-medium leading-snug text-slate-800 font-bold mb-2">Brand :<span
            class="text-sm text-slate-600 font-medium ml-2">{{ $productData->brand ? $productData->brand->name : '---' }}</span>
    </h2>
</div><br>
<div>
    <h2 class="text-medium leading-snug text-slate-800 font-bold mb-2">Attributes</h2>
    <div class="row">
        @forelse ( $productData->specifications as $key=>$specification)
        <label class="">{{ $key }}</label><br>
            @forelse ($specification as $attributeValue)
                <div class="col-md-4">
                    <span class="text-sm text-slate-600 font-medium ml-2">
                        <button data-price="{{ $attributeValue['price'] }}" class="btn border-slate-200 hover:border-slate-300">
                            {{ $attributeValue['value']?$attributeValue['value']:'---' }}
                        </button>
                    </span>
                </div>
            @empty

            @endforelse

        @empty
              <label class="">{{ '---' }}</label>
        @endforelse
    </div>
</div>
