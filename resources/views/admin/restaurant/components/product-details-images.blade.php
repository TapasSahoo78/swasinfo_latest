<figure class="mb-6">
    <div class="row">
        @foreach ($productData->product_images as $image)
            <div class="col-md-4">
                <img class="w-64 rounded-sm" src="{{ $image }}"
                    width="100" height="75" alt="Product" />
            </div>
        @endforeach
    </div>
</figure>
