# ImagesLoader

<!--version-->

[ImagesLoader](https://github.com/itformat/imagesloader/) is a modular images loader plugin for Bootstrap.

## Live Demo
See live at https://www.format.it/demo/imagesloader

## Screen shots
<a href="https://www.format.it/demo/imagesloader">
  <img alt="ImagesLoader" src="https://www.format.it/demo/imagesloader/screenshots/0001.png" />
</a>

## Install
- Cloning using Git: `git clone https://github.com/ITformat/imagesloader.git`

## Versions

First release 1.0.1

Dependecies:
  - Jquery v3.5.1
  - Bootstrap v.4.5.2

## Example

```html

<html>
<head>
  <title>Format ImagesLoader</title>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" crossorigin="anonymous">

  <!-- Format Images loader CSS -->
  <link rel="stylesheet" href="./jquery.imagesloader.css">

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <!-- Font awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js" crossorigin="anonymous"></script>

  <!-- Images loader -->
  <script src="./jquery.imagesloader-1.0.1.js"></script>

</head>

<body>

  <div class="container col-8 pt-5">

    <form id="frm" method="post" class="needs-validation" novalidate="">

      <!--Image Upload-->
      <div class="row mt-3 mb-2">

        <div class="col-12 pr-0 text-left">
          <label for="Images" class="col-form-label text-nowrap"><strong>Images loader</strong></label>
        </div>
      </div>

      <!--Image container -->
      <div class="row" data-type="imagesloader" 
           data-errorformat="Accepted file formats" data-errorsize="Maximum size accepted" data-errorduplicate="File already loaded" 
           data-errormaxfiles="Maximum number of images you can upload" data-errorminfiles="Minimum number of images to upload" 
           data-modifyimagetext="Modify immage" data-maxFiles="4">

        <!-- Progress bar -->
        <div class="col-12 order-1 mt-2">
          <div data-type="progress" class="progress" style="height: 25px; display:none;">
            <div data-type="progressBar" 
                 class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%;">Load in progress...</div>
          </div>
        </div>

        <!-- Model -->
        <div data-type="image-model" class="col-4 pl-2 pr-2 pt-2" style="max-width:200px; display:none;">

          <div class="ratio-box text-center" data-type="image-ratio-box">
            <img data-type="noimage" class="btn btn-light ratio-img img-fluid p-2 image border dashed rounded" src="./img/photo-camera-gray.svg" style="cursor:pointer;">
            <div data-type="loading" class="img-loading" style="color:#218838; display:none;">
              <span class="fa fa-2x fa-spin fa-spinner"></span>
            </div>
            <img data-type="preview" class="btn btn-light ratio-img img-fluid p-2 image border dashed rounded" src="" style="display: none; cursor: default;">
            <span class="badge badge-pill badge-success p-2 w-50 main-tag" style="display:none;">Main</span>
          </div>

          <!-- Buttons -->
          <div data-type="image-buttons" class="row justify-content-center mt-2">
            <button data-type="add" class="btn btn-outline-success" type="button"><span class="fa fa-camera mr-2"></span>Add</button>
            <button data-type="btn-modify" type="button" class="btn btn-outline-success m-0" data-toggle="popover" data-placement="right" style="display:none;">
              <span class="fa fa-pencil-alt mr-2"></span>Modify
            </button>
          </div>
        </div>

        <!-- Popover operations -->
        <div data-type="popover-model" style="display:none">
          <div data-type="popover" class="ml-3 mr-3" style="min-width:150px;">
            <div class="row">
              <div class="col p-0">
                <button data-operation="main" class="btn btn-block btn-success btn-sm rounded-pill" type="button"><span class="fa fa-angle-double-up mr-2"></span>Main</button>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6 p-0 pr-1">
                <button data-operation="left" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button"><span class="fa fa-angle-left mr-2"></span>Left</button>
              </div>
              <div class="col-6 p-0 pl-1">
                <button data-operation="right" 
                        class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">Right<span class="fa fa-angle-right ml-2"></span></button>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6 p-0 pr-1">
                <button data-operation="rotateanticlockwise" 
                        class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button"><span class="fas fa-undo-alt mr-2"></span>Rotate</button>
              </div>
              <div class="col-6 p-0 pl-1">
                <button data-operation="rotateclockwise" 
                        class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">Rotate<span class="fas fa-redo-alt ml-2"></span></button>
              </div>
            </div>
            <div class="row mt-2">
              <button data-operation="remove" class="btn btn-outline-danger btn-sm btn-block" type="button"><span class="fa fa-times mr-2"></span>Remove</button>
            </div>
          </div>
        </div>

      </div>

      <div class="form-group row">
        <div class="input-group">
          <!--Hidden file input for images-->
          <input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
        </div>
      </div>

    </form>

    <div class="row mt-2">
      <div class="col-md-4 offset-md-8 text-center mb-4">
        <button id="btnContinue" type="submit" form="frm" class="btn btn-block btn-outline-success float-right" data-toggle="tooltip" data-trigger="manual" data-placement="top" data-title="Continue">
          Continue<span id="btnContinueIcon" class="fa fa-chevron-circle-right ml-2"></span><span id="btnContinueLoading" class="fa fa-spin fa-spinner ml-2" style="display:none"></span>
        </button>
      </div>
    </div>

  </div>

  <div class="container col-4 pt-5 text-center">
    <label class="col-form-label text-nowrap"><italic>*Thanks to all everybody that will support this project.*</italic></label>
    <form action="https://www.paypal.com/donate" method="post" target="_top">
      <input type="hidden" name="hosted_button_id" value="FDL9PF2E2MGF8" />
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
      <img alt="" border="0" src="https://www.paypal.com/en_IT/i/scr/pixel.gif" width="1" height="1" />
    </form>
  </div>

  <!-- Custom javascript -->
  <script type="text/javascript">
    // Ready
    $(document).ready(function () {

      // Create image loader plugin
      var imagesloader = $('[data-type=imagesloader]').imagesloader({
        minSelect: 3
       ,imagesToLoad: [{"Url":"./img/Nespresso001.jpg","Name":"Nespresso001"},{"Url":"./img/Nespresso002.jpg","Name":"Nespresso002"}]
      });

      //Form
      $frm = $('#frm');

      // Form submit
      $frm.submit(function (e) {

        var $form = $(this);

        var files = imagesloader.data('format.imagesloader').AttachmentArray;
        var il = imagesloader.data('format.imagesloader');

        if (il.CheckValidity())
          alert('Upload ' + files.length + ' files');        

        e.preventDefault();
        e.stopPropagation();
      });

    });
  </script>
</body>
</html>
```
## Contributions
* [Issues](https://github.com/ITformat/ImagesLoader/issues)
* [Pull Requests](https://github.com/ITformat/ImagesLoader/pulls)
* [Milestones](https://github.com/ITformat/ImagesLoader/milestones)

This project exists thanks to all the [people who contribute](https://github.com/ITformat/ImagesLoader/graphs/contributors).

## License
The MIT License (MIT).
Please see the [License File](https://github.com/ITformat/ImagesLoader/blob/main/LICENSE) for more information.

## Credits

Written and maintained by [Marco Montagnani](https://www.format.it/#team) and all other contributors.

<a class="readme-logo" href="https://www.format.it/">
  <img alt="Format" src="https://www.format.it/img/logo-format.png" width="300px" />
</a>

*Thanks to all everybody that will support this project.*

[![Paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/donate?hosted_button_id=FDL9PF2E2MGF8)

