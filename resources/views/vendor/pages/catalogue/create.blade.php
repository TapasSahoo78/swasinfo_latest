@extends('vendor.layouts.app')
@section('pagetitlesection', __('Catalogue'))
@section('content')
    <div class="container-fluid pt-4 px-4">
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Product List</a></li>
            <li>Add Product</li>
        </ul>
        <!-- Tab Start -->
        <div class="tabcard">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Add a product</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Bulk Upload</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Upload & Manage
                        Videos</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <h4>Add Product</h4>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-12">
                                <h5>Category</h5>
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Brand Name</label>
                                                    <select class="form-select">
                                                        {{-- <option selected="">Select a category</option> --}}
                                                        {{ getProductBrand('') }}
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Product Category</label>
                                                    <select class="form-select" id="productCategory">
                                                        {{-- <option selected="">Select tags</option> --}}
                                                        {{ getAllCategory('') }}
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Sub Category</label>
                                                    <select class="form-select" id="sub_categories">
                                                        {{-- <option selected="">Select tags</option> --}}
                                                        {{-- {{ getSubCategory('') }} --}}
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Product Name</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                                        placeholder="Select a category" aria-describedby="emailHelp">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Country of Origin</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                                        placeholder="Select a category" aria-describedby="emailHelp">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <div class="status-card">
                                                        <h6>Status</h6>
                                                        <div class="draft-text">Draft</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Product Status</label>
                                                    <select class="form-select">
                                                        <option selected="">Draft</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 ">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Manufacturer Details</label>
                                                    <textarea class="form-control" placeholder="Placeholder text. . ." id="floatingTextarea"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Packer Details</label>
                                                    <textarea class="form-control" placeholder="Placeholder text. . ." id="floatingTextarea"></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                    <label for="" class="form-label">Product Description</label>
                                                    <textarea class="form-control" placeholder="Placeholder text. . ." id="floatingTextarea"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <h5>Media</h5>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12 mediacard">
                                        <h6>Photo</h6>
                                        <div class="photocard mb-3">
                                            <div class="photocard-icon"><img src="img/photocard-icon.png" alt="">
                                            </div>
                                            <p>Drag and drop image here, or click add image</p>
                                            <a href="#" class="addimage-btn">Add Image <input type="file"
                                                    id="myFile" name="filename2"></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12 mediacard">
                                        <h6>Video</h6>
                                        <div class="photocard mb-3">
                                            <div class="photocard-icon"><img src="img/video-icon.png" alt="">
                                            </div>
                                            <p>Drag and drop video here, or click add video</p>
                                            <a href="#" class="addimage-btn">Add Video <input type="file"
                                                    id="myFile" name="filename2"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <h5>Pricing</h5>
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Base Price</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type base price here. . ." aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Sale Price</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type base price here. . ." aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Discount Type</label>
                                            <select class="form-select">
                                                <option selected="">Select a discount type</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Discount Precentage (%)</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type discount precentage. . ." aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">GST (%)</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type base price here. . ." aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">HSN ID</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type VAT amount. . ." aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <h5>Inventory</h5>
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">SKU</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type product SKU here. . ." aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Material</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Product barcode. . ." aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Quantity</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Type product quantity here. . ."
                                                aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Unit</label>
                                            <select class="form-select">
                                                <option selected="">Type product unit here. . .</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <h5>Inventory</h5>
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Weight</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="0.25 kg" aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Height</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="10 cm" aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Length</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="10 cm" aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Width</label>
                                            <select class="form-select">
                                                <option selected="">7 cm</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <h5>Variation</h5>
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Variation Type</label>
                                            <select class="form-select">
                                                <option selected="">Color</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Variation</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Black" aria-describedby="emailHelp">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Variation Type</label>
                                            <select class="form-select">
                                                <option selected="">Color</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Variation</label>
                                            <div class="variationcard">
                                                <input type="email" class="form-control" id="exampleInputEmail1"
                                                    placeholder="Gray" aria-describedby="emailHelp">
                                                <div class="times-icon"><i class="fa fa-times" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <a href="#" class="add-variantbtn"><i class="fa fa-plus"
                                                    aria-hidden="true"></i>
                                                Add Variant</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="footerbtn-section">
                        <a href="#" class="cancelpro-btn"><i class="fa fa-times" aria-hidden="true"></i>
                            Cancel</a> <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Save Product</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <h4>Bulk Upload</h4>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Select Category</label>
                                            <select class="form-select">
                                                <option selected="">Select a category</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <div class="download-format"> <a href="#" class="add-variantbtn"><i
                                                        class="fa fa-download" aria-hidden="true"></i> Download Format</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <h5 class="mb-0">Upload a file</h5>
                                            <p>Explination of what to do here and why it is important.</p>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12 mediacard">
                                                    <div class="photocard mb-3">
                                                        <div class="photocard-icon"><img src="img/photocard-icon.png"
                                                                alt=""></div>
                                                        <p>Drag and drop image here, or click add image</p>
                                                        <a href="#" class="addimage-btn">Import File <input
                                                                type="file" id="myFile" name="filename2"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="footerbtn-section">
                        <a href="#" class="cancelpro-btn"><i class="fa fa-times" aria-hidden="true"></i>
                            Cancel</a> <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Save</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <h4>Upload & Manage Videos</h4>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Select Product</label>
                                            <select class="form-select">
                                                <option selected="">Select a type</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12 mediacard">
                                                    <div class="photocard mb-3">
                                                        <div class="photocard-icon"><img src="img/photocard-icon.png"
                                                                alt=""></div>
                                                        <p>Drag and drop image here, or click add image</p>
                                                        <a href="#" class="addimage-btn">Upload&nbsp;Image <input
                                                                type="file" id="myFile" name="filename2"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="mediacard mediacard2">
                                                <div class="photocard mb-3">
                                                    <div class="times-circle"><i class="fa fa-times-circle-o"
                                                            aria-hidden="true"></i></div>
                                                    <div class="photocard-icon"><img src="img/photocard-icon.png"
                                                            alt=""></div>
                                                </div>
                                                <div class="photocard mb-3">
                                                    <div class="times-circle"><i class="fa fa-times-circle-o"
                                                            aria-hidden="true"></i></div>
                                                    <div class="photocard-icon"><img src="img/photocard-icon.png"
                                                            alt=""></div>
                                                </div>
                                                <div class="photocard mb-3">
                                                    <div class="times-circle"><i class="fa fa-times-circle-o"
                                                            aria-hidden="true"></i></div>
                                                    <div class="photocard-icon"><img src="img/photocard-icon.png"
                                                            alt=""></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <form class="category-form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <label for="" class="form-label">Select Product</label>
                                            <select class="form-select">
                                                <option selected="">Select a type</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-12 mediacard">
                                                    <div class="photocard mb-3">
                                                        <div class="photocard-icon"><img src="img/video-icon.png"
                                                                alt=""></div>
                                                        <p>Drag and drop video here, or click add video</p>
                                                        <a href="#" class="addimage-btn">Upload Video <input
                                                                type="file" id="myFile" name="filename2"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="mediacard mediacard2">
                                                <div class="photocard mb-3">
                                                    <div class="times-circle"><i class="fa fa-times-circle-o"
                                                            aria-hidden="true"></i></div>
                                                    <div class="photocard-icon"><img src="img/video-icon.png"
                                                            alt=""></div>
                                                </div>
                                                <div class="photocard mb-3">
                                                    <div class="times-circle"><i class="fa fa-times-circle-o"
                                                            aria-hidden="true"></i></div>
                                                    <div class="photocard-icon"><img src="img/video-icon.png"
                                                            alt=""></div>
                                                </div>
                                                <div class="photocard mb-3">
                                                    <div class="times-circle"><i class="fa fa-times-circle-o"
                                                            aria-hidden="true"></i></div>
                                                    <div class="photocard-icon"><img src="img/video-icon.png"
                                                            alt=""></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="footerbtn-section">
                        <a href="#" class="cancelpro-btn"><i class="fa fa-times" aria-hidden="true"></i>
                            Cancel</a> <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Save</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Start End -->
    </div>
@endsection
@push('scripts')
    <script>
        // Your JavaScript file or script tag in the Blade view
        $(document).ready(function() {
            $('#productCategory').change(function() {
                var categoryId = $(this).val();
                $.ajax({
                    url: "{{ route('ajax.vendor.sub.categories') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        categoryId: categoryId
                    },
                    success: function(data) {
                        $('#sub_categories').empty();
                        $.each(data, function(key, value) {
                            $('#sub_categories').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endpush
