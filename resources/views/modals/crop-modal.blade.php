@push('style')
<style>
    .modal-content{
        background: white;
    }
    .modal-content .modal-body{
        padding: 10px 32px 32px;
    }
    .modal-content .modal-body .crop-main-image-wrapper{
        overflow: hidden;
    }
    .modal-content .modal-body .crop-main-image-wrapper img{
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    .modal-content .modal-body .preview-image-wrapper{
        overflow: hidden;
    }
    .modal-content .modal-body .preview-image-wrapper img{
        object-fit: cover;
        object-position: top;
        width: 100%;
        height: 100%;
    }
    .preview {
    border: 3px solid #15b9a9;
    margin: 0px;
    overflow: hidden;
    width: 160px;
    height: 160px;
}
    .preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        object-position: top;
    }
    .modal-header{
        border-bottom: none;
    }
    .modal-footer {
    justify-content: center;
    border-top: 1.5px solid #1413131a;
    padding-top: 0px;
    padding-bottom: 12px;
}

    div#cropmodal {
    z-index: 99999 !important;
}

#cropmodal .modal-header button.close {
    border: 0px;
    padding: 0px;
    margin: 0px;
    height: 30px;
    width: 30px;
    border-radius: 50%;
    color: red;
    font-size: 22px;
    display: flex;
    justify-content: center;
    align-items: center;
}

#cropmodal button#crop {
    overflow: hidden;
    border: 1px solid #15B9A9;
    padding: 3px 16px;
    border-radius: 30px;
    display: inline-block;
    color: #15B9A9;
    background-color: #fff;
    position: relative;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0;
}
</style>
@endpush
<div class="modal fade modal-crop-effect" id="cropmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md modal-margin" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-end">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="img-container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="crop-main-image-wrapper">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="preview-image-wrapper">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <div class="col-md-12 mt-3 text-right">
                <button type="button" class="d-inline-flex align-top cmnbttn cmnbttn--active2-190 cmnbttn--width190 position-relative border-btn-crop" id="crop">Crop</button>
            </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
