<!-- Sidebar -->
<form id="productFilterForm" enctype="multipart/form-data">
    <div>
        <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5 min-w-60">
            <div class="grid md:grid-cols-2 xl:grid-cols-1 gap-6">
                <!-- Group 1 -->
                <div>
                    <div class="text-sm text-slate-800 font-semibold mb-3">Categories</div>
                    <ul class="space-y-2">
                        @forelse ($listCategories as $category)
                            <li>
                                <label class="flex items-center">
                                    <input type="checkbox" name="category[]" class="form-checkbox" value="{{ $category->id }}" />
                                    <span class="text-sm text-slate-600 font-medium ml-2">{{ $category->name }}</span>
                                </label>
                            </li>
                        @empty
                        @endforelse

                    </ul>
                </div>
                <!-- Price Range -->
                <div>
                    <div class="text-sm text-slate-800 font-semibold mb-3">Price Range</div>
                    <label class="sr-only">Price</label>
                    <select class="form-select w-full" name="priceRange">

                        @if(isset($maxPrice) && isset($minPrice))
                            <option value="{{ $minPrice.'-'.$maxPrice }}">No Range Selected</option>
                            @php
                                $avgdiffrence= ceil(($maxPrice-$minPrice)/4);
                                $j=0;
                            @endphp
                            {{-- @foreach (range($minPrice,$maxPrice,$avgdiffrence) as $key=>$number )

                                <option value="{{ $i.'-'.$i+$avgdiffrence }}">from {{ $i }} to {{ $number+$avgdiffrence }}</option>
                            @endforeach --}}

                            @for ($i=$minPrice ; $i<$maxPrice; $i+=$avgdiffrence)
                                @php
                                    $i= ($j==0)? $i : $i++;
                               @endphp
                                <option value="{{ $i.'-'.$i+$avgdiffrence }}">from {{ $i }} to {{ $i==$maxPrice  ? '+' : $i+$avgdiffrence }}</option>
                                @php
                                    $j++;
                                @endphp
                            @endfor
                        @endif
                    </select>
                </div>
                <!-- Group 3 -->
                <!--  -->
                <div class="row">
                    <div class="col-md-3">
                        {{-- <a href="{{ route('admin.product.list') }}" class="btn-xs border-slate-200 hover:border-slate-300 text-slate">Reset</a> --}}
                        <a href="{{ route('admin.product.list') }}" class="btn-xs bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">Reset</a>
                    </div>
                    <div class="col-md-1">
                        {{-- <button type="button" class="btn-xs bg-indigo-500 hover:bg-indigo-600 text-white">Reset</button> --}}
                    </div>

                    <div class="col-md-3">
                        <a href="javascript:void(0)" class="btn-xs bg-indigo-500 hover:bg-indigo-600 text-white checkList">Apply</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
