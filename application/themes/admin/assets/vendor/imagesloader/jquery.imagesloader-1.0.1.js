/* ========================================
   Images loader v1.0.1
   http://www.format.it/
   Copyright (c) 2021 Format s.r.l.
   Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)

   Requires: jquery.imagesloader.css
             jquery 3.3.x
             bootstrap 4.3.x
   ======================================== */

if (typeof jQuery === 'undefined') { throw new Error('Images loader requires jQuery') }

// #region Prototype

String.prototype.replaceAll = function (search, replacement) {
  var target = this;
  return target.replace(new RegExp(search, 'g'), replacement);
};

// #endregion

// #region Generic function

// base64ToArrayBuffer
// Convert a base64 image to byte array
function base64ToArrayBuffer(base64) {

  var binary_string = window.atob(base64);
  var len = binary_string.length;
  var bytes = new Uint8Array(len);

  for (var i = 0; i < len; i++)
    bytes[i] = binary_string.charCodeAt(i);
  
  return bytes.buffer;
}

// arrayBufferToBase64
// Convert a byte array image to base64 string
function arrayBufferToBase64(buffer) {

  var binary = '';
  var bytes = new Uint8Array(buffer);
  var len = bytes.byteLength;

  for (var i = 0; i < len; i++)
    binary += String.fromCharCode(bytes[i]);
  
  return window.btoa(binary);
}

// getOrientation
// Extract image orientation from JPEG EXIF image data
// return -2: not jpeg
//        -1: not defined
//       1-8: orientation see: https://stackoverflow.com/questions/7584794/accessing-jpeg-exif-rotation-data-in-javascript-on-the-client-side/32490603#32490603
function getOrientation(src) {

  var view = new DataView(src);

  if (view.getUint16(0, false) != 0xFFD8)
    return -2;
  
  var length = view.byteLength;
  var offset = 2;

  while (offset < length) {

    if (view.getUint16(offset + 2, false) <= 8)
      -1;

    var marker = view.getUint16(offset, false);
    offset += 2;

    if (marker == 0xFFE1) {

      if (view.getUint32(offset += 2, false) != 0x45786966)
        return -1;

      var little = view.getUint16(offset += 6, false) == 0x4949;
      offset += view.getUint32(offset + 4, little);

      var tags = view.getUint16(offset, little);
      offset += 2;

      for (var i = 0; i < tags; i++)
        if (view.getUint16(offset + (i * 12), little) == 0x0112)
          return view.getUint16(offset + (i * 12) + 8, little);
    }
    else if ((marker & 0xFF00) != 0xFF00) {
      break;
    }
    else
      offset += view.getUint16(offset, false);    
  }

  return -1;
}

// imageToFormat
// Convert image object to base64 string
function imageToFormat(img, maxWidth = null, maxHeight = null, imgType = 'image/jpeg', quality = .9, orientation = -1) {

  var canvas = document.createElement("canvas");

  // Calc witdh & heigth
  var width = img.width;
  var height = img.height;

  if (img.width > maxWidth)
    width = maxWidth;  

  if (img.height > maxHeight)
    height = maxWidth;

  // Apply width & height
  canvas.width = img.width;
  canvas.height = img.height;

  // Set proper canvas dimensions before transform & export
  if (orientation >= 5 && orientation <= 8) {
    canvas.width = img.height;
    canvas.height = img.width;
  }

  // Calc scale
  var scaleX = width / img.width;
  var scaleY = height / img.height;
  var scale = 1;

  if (scaleX < scale)
    scale = scaleX;

  if (scaleY < scale)
    scale = scaleY;

  // Apply scale
  canvas.width *= scale;
  canvas.height *= scale;

  var ctx = canvas.getContext("2d");
  ctx.scale(scale, scale);

  // Transform context before drawing image
  switch (orientation) {

    case 1: ctx.transform(1, 0, 0, 1, 0, 0);
      break;
    case 2: ctx.transform(-1, 0, 0, 1, img.width, 0);
      break;
    case 3: ctx.transform(-1, 0, 0, -1, img.width, img.height);
      break;
    case 4: ctx.transform(1, 0, 0, -1, 0, img.height);
      break;
    case 5: ctx.transform(0, 1, 1, 0, 0, 0);
      break;
    case 6: ctx.transform(0, 1, -1, 0, img.height, 0);
      break;
    case 7: ctx.transform(0, -1, -1, 0, img.height, img.width);
      break;
    case 8: ctx.transform(0, -1, 1, 0, 0, img.width);
      break;

    default:
      break;
  }

  ctx.drawImage(img, 0, 0);

  return canvas.toDataURL(imgType, quality);
}

// imageToFormat
$.fn.imageToFormat = function () {

  return this.each(function () {

    this.src = imageToFormat(this);
  });
}

// Rotate image
function drawRotated(img,degree) {

    var canvas = document.createElement("canvas");
    var cContext = canvas.getContext('2d');
    var cw = img.width, ch = img.height, cx = 0, cy = 0;

    // Calculate new canvas size and x/y coorditates for image
  switch (degree) {

      case -90:
        cw = img.height;
        ch = img.width;
        cx = img.width * (-1);
        break;
      case 90:
        cw = img.height;
        ch = img.width;
        cy = img.height * (-1);
        break;
      case 180:
        cx = img.width * (-1);
        cy = img.height * (-1);
        break;
      case 270:
        cw = img.height;
        ch = img.width;
        cx = img.width * (-1);
        break;
    }

    // Rotate image            
    canvas.setAttribute('width', cw);
    canvas.setAttribute('height', ch);
    cContext.rotate(degree * Math.PI / 180);
    cContext.drawImage(img, cx, cy);

    return canvas.toDataURL();
  }

// #endregion

  + function ($) {
    "use strict";

    // Images loader PUBLIC CLASS DEFINITION
    var ImagesLoader = function (name, element, options) {

      this.name = name;
      this.element = element;
      this.$element = $(element);
      this.inProgress = false;

      var iconBasePath = this.path() + "img/";
      this.options = $.extend({ iconBasePath: iconBasePath }, ImagesLoader.DEFAULTS, options, this.$element.data());

      this.enabled = true;

      this.init();
    };

    ImagesLoader.DEFAULTS = {

        fadeTime: 'slow'
      , inputID: 'files'
      , maxfiles: 4
      , maxSize: 5000 * 1024 // Kb
      , minSelect: 1
      , imagesToLoad: null
      , filesType: ["image/jpeg", "image/png", "image/gif"]
      , maxWidth: 1280 // pixel
      , maxHeight: 1024
      , imgType: "image/jpeg"
      , imgQuality: .9
      , errorformat: "Accepted format"
      , errorsize: "Max size allowed"
      , errorduplicate: "File already uploaded"
      , errormaxfiles: "Max images you can upload"
      , errorminfiles: "Minimum number of images to upload"
      , modifyimagetext: "Modify image"
      , rotation: 90
    };

    //#region File

    // get script fullpath
    ImagesLoader.prototype.fullPath = function () {

      return $("script[src*='" + imagesloader_fileName + "']").attr('src');
    }

    // get script path
    ImagesLoader.prototype.path = function () {

      var fullPath = this.fullPath();
      return fullPath.substr(0, fullPath.lastIndexOf("/") + 1);
    }

    // get script filename
    ImagesLoader.prototype.fileName = function () {
      var fullPath = this.fullPath();
      return fullPath.substr(fullPath.lastIndexOf("/") + 1, fullPath.length);
    }

    //#endregion

    /* Windows event */

    //#region Mouse events

    // Button add click
    ImagesLoader.prototype.btnAddClick = function (evt, obj) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      self.$files.click();
    }

    ImagesLoader.prototype.btnChangeClick = function (evt, obj) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      //to make sure the user select file/files
      if (!evt.target.files)
        return;

      //To obtaine a File reference
      var files = evt.target.files;

      //Obtain num of images selected
      var filesLength = self.AttachmentArray.length + evt.target.files.length;

      self.$progress.hide();

      //To check files count according to upload conditions
      if (filesLength > options.maxfiles)
        self.ShowProgress(self.barStyle.warning, options.errormaxfiles + ": " + options.maxfiles, 2000);

      // Find div loadind spinner
      var $divLoading = self.$addImage.find('[data-type="loading"]');
      $divLoading.show();

      // Loop through the FileList and then to render image files as thumbnails.
      (function handle(i) {

        // Exit recursive function on finish
        if (i >= files.length) {

          self.$files.val('');

          // Check if we have reach the maximum number of image
          if (self.AttachmentArray.length >= options.maxfiles)
            self.$addImage.hide();

          $divLoading.hide();
          return;
        }

        let file = files[i];

        // Apply the validation rules for attachments upload
        if (self.ApplyFileValidationRules(file) == false) {
          handle(++i);
          return;
        }

        // Fill the array of attachment
        self.AttachmentArray.push({
          AttachmentType: 1
          , ObjectType: 1
          , FileName: file.name
          , FileDescription: "Attachment"
          , NoteText: ''
          , MimeType: file.type
          , Base64: null
          , Orientation: -1
          , FileSizeInBytes: file.size
          , File: file
        });

        // Instantiate a FileReader object to read its contents into memory
        var fileReader = new FileReader();

        // Closure to capture the file information and apply validation.
        fileReader.onload = function (e) {

          var main = (self.AttachmentArray.length == 1);

          var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(file.name);

          var src = e.target.result;

          var image = new Image();
          image.crossOrigin = "anonymous"; // This enables CORS

          image.onload = function () {

            var base64 = this.src.split("base64,")[1];
            var orientation = getOrientation(base64ToArrayBuffer(base64));

            var src = imageToFormat(this, options.maxWidth, options.maxHeight, options.imgType, options.imgQuality, orientation);

            // Render attachments thumbnails.
            self.RenderThumbnail(src, file.name, main);

            self.AttachmentArray[idx].Base64 = src.split("base64,")[1];
            self.AttachmentArray[idx].Orientation = orientation;

            handle(++i);
          };

          image.src = src;
        };

        // Read in the image file as a data URL.
        // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
        // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
        fileReader.readAsDataURL(file);
      })(0);

    }

    // Button remove click
    ImagesLoader.prototype.btnRemoveClick = function (evt, obj) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      // Find div and id image
      var $div = $(obj).closest('[data-type="image"]');

      // Hide Popover
      var $buttonPopover = $div.find('[data-type="btn-modify"]');
      $buttonPopover.popover('hide');

      var id = $div.data('id');

      // Update main image
      if (self.AttachmentArray.length > 1 && self.AttachmentArray[0].FileName == $div.data('id')) {

        var $nextDiv = $div.next('[data-type="image"]');
        var $noimage = $nextDiv.find('[data-type="noimage"]');

        var $preview = $nextDiv.find('[data-type="preview"]');
        var $btnAdd = $nextDiv.find('[data-type="add"]');
        var $btnModify = $nextDiv.find('[data-type="btn-modify"]');
        var $btnRemove = $nextDiv.find('[data-type="remove"]');
        var $btnMain = $nextDiv.find('[data-type="main"]');
        var $ratioBox = $nextDiv.find('[data-type="image-ratio-box"]');
        var $tag = $ratioBox.find('.main-tag');

        $btnRemove.show();

        $noimage.hide();
        $btnAdd.hide();
        $preview.fadeIn(options.fadeTime);
      }

      // Remove the image from array
      var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(id);

      if (idx !== -1)
        self.AttachmentArray.splice(idx, 1);

      self.$addImage.fadeOut(options.fadeTime);

      $div.fadeOut(options.fadeTime, function () {

        $div.remove();

        var $divImage = self.$addImage.closest('[data-type="image"]');
        $divImage.attr('data-type', 'noimage');

        self.$addImage.fadeIn(options.fadeTime);
      });

      self.$progress.fadeOut(options.fadeTime);
    };

    // Button main click
    ImagesLoader.prototype.btnMainClick = function (evt, obj) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      // Find div and image of the image
      var $div = $(obj).closest('[data-type="image"]');

      var $preview = $div.find('[data-type="preview"]');
      var $ratioBox = $div.find('[data-type="image-ratio-box"]');
      var $tooltip = $ratioBox.attr('data-bs-original-title');
      var id = $div.attr('data-id');
      var imgSource = $preview.attr('src');

      // Hide Popover
      var $buttonPopover = $div.find('[data-type="btn-modify"]');
      $buttonPopover.popover('hide');

      // Find div and image of the main image
      var main = self.AttachmentArray[0];

      var $divMain = $element.find('[data-id="' + main.FileName + '"]');

      var $previewMain = $divMain.find('[data-type="preview"]');
      var $ratioBoxMain = $divMain.find('[data-type="image-ratio-box"]');
      var $tag = $ratioBoxMain.find('.main-tag');
      var $tooltipMain = $ratioBoxMain.attr('data-bs-original-title');

      var imgSourceMain = $previewMain.attr('src');

      // Change image preview
      $tag.hide();

      $preview.fadeOut(options.fadeTime, function () {
        $preview.attr('src', imgSourceMain);
      });

      $previewMain.fadeOut(options.fadeTime, function () {
        $previewMain.attr('src', imgSource);
        $tag.show();
      });

      $preview.fadeIn(options.fadeTime);
      $previewMain.fadeIn(options.fadeTime);

      // Change div data id
      $div.attr('data-id', main.FileName);
      $divMain.attr('data-id', id);

      //Change tooltip
      $ratioBox.attr('data-bs-original-title', $tooltipMain);
      $ratioBoxMain.attr('data-bs-original-title', $tooltip);

      // Find array id of the image and change position of the main image
      var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(id);

      if (idx !== -1) {
        self.AttachmentArray[0] = self.AttachmentArray[idx];
        self.AttachmentArray[idx] = main;
      }
    };

    // Button left click
    ImagesLoader.prototype.btnLeftClick = function (evt, obj) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      // Find div and image of the image
      var $div = $(obj).closest('[data-type="image"]');

      var $preview = $div.find('[data-type="preview"]');
      var $ratioBox = $div.find('[data-type="image-ratio-box"]');
      var $tooltip = $ratioBox.attr('data-bs-original-title');

      var id = $div.attr('data-id');

      // Hide Popover
      var $buttonPopover = $div.find('[data-type="btn-modify"]');
      $buttonPopover.popover('hide');

      // Find array id of the image and left image
      var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(id);
      var leftImageIdx = idx - 1;
      var leftImage = self.AttachmentArray[leftImageIdx];

      //Find div and image of the left image
      var $divLeft = $element.find('[data-id="' + leftImage.FileName + '"]');
      var $previewLeft = $divLeft.find('[data-type="preview"]');
      var $ratioBoxLeft = $divLeft.find('[data-type="image-ratio-box"]');
      var $tooltipLeft = $ratioBoxLeft.attr('data-bs-original-title');
      var imgSource = "data:image/jpeg;base64," + self.AttachmentArray[idx].Base64; 
      var imgSourceLeft = "data:image/jpeg;base64," + leftImage.Base64; 

      var $tag = $ratioBoxLeft.find('.main-tag');

      // Change image preview
      $tag.hide();

      $preview.fadeOut(options.fadeTime, function () {
        $preview.attr('src', imgSourceLeft);
      });

      $previewLeft.fadeOut(options.fadeTime, function () {
        $previewLeft.attr('src', imgSource);

        if (leftImageIdx == 0)
          $tag.show();
      });

      $preview.fadeIn(options.fadeTime);
      $previewLeft.fadeIn(options.fadeTime);

      //Change tooltip
      $ratioBox.attr('data-bs-original-title', $tooltipLeft);
      $ratioBoxLeft.attr('data-bs-original-title', $tooltip);

      //Change div data
      $div.attr('data-id', leftImage.FileName);
      $divLeft.attr('data-id', id);

      if (idx !== -1) {
        self.AttachmentArray[leftImageIdx] = self.AttachmentArray[idx];
        self.AttachmentArray[idx] = leftImage;
      }
    };

    // Button right click
    ImagesLoader.prototype.btnRightClick = function (evt, obj) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      // Find div and image of the image
      var $div = $(obj).closest('[data-type="image"]');

      var $preview = $div.find('[data-type="preview"]');
      var $ratioBox = $div.find('[data-type="image-ratio-box"]');
      var $tooltip = $ratioBox.attr('data-bs-original-title');

      var id = $div.attr('data-id');

      // Hide Popover
      var $buttonPopover = $div.find('[data-type="btn-modify"]');
      $buttonPopover.popover('hide');

      // Find array id of the image and right image
      var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(id);
      var rightImageIdx = idx + 1;
      var rightImage = self.AttachmentArray[rightImageIdx];

      //Find div and image of the left image
      var $divRight = $element.find('[data-id="' + rightImage.FileName + '"]');
      var $previewRight = $divRight.find('[data-type="preview"]');
      var $ratioBoxRight = $divRight.find('[data-type="image-ratio-box"]');
      var $tooltipRight = $ratioBoxRight.attr('data-bs-original-title');
      var imgSource = "data:image/jpeg;base64," + self.AttachmentArray[idx].Base64;
      var imgSourceRight = "data:image/jpeg;base64," + rightImage.Base64; 

      var $tag = $ratioBox.find('.main-tag');

      // Change image preview
      $tag.hide();

      $preview.fadeOut(options.fadeTime, function () {
        $preview.attr('src', imgSourceRight);
      });

      $previewRight.fadeOut(options.fadeTime, function () {
        $previewRight.attr('src', imgSource);
        //$tag.show();
      });

      $preview.fadeIn(options.fadeTime);
      $previewRight.fadeIn(options.fadeTime);

      //Change tooltip
      $ratioBox.attr('data-bs-original-title', $tooltipRight);
      $ratioBoxRight.attr('data-bs-original-title', $tooltip);

      //Change div data
      $div.attr('data-id', rightImage.FileName);
      $divRight.attr('data-id', id);

      if (idx !== -1) {
        self.AttachmentArray[rightImageIdx] = self.AttachmentArray[idx];
        self.AttachmentArray[idx] = rightImage;
      }
    };


    // Button rotate click
    ImagesLoader.prototype.btnRotateClick = function (evt, obj) {

      var self = this;
      var options = self.options;
      var element = self.element;
      var $element = $(element);

      // Find div and id of the image
      var $div = $(obj).closest('[data-type="image"]');
      var $preview = $div.find('[data-type="preview"]');
      var id = $div.attr('data-id');
      var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(id);
   
      // Create new image and pass to drawRotated function to rotate image source   
      var image = new Image();
      image.src = "data:image/jpeg;base64," + self.AttachmentArray[idx].Base64; 

      image.onload = function () {

        var src = drawRotated(this, options.rotation);
        var base64 = src.split("base64,")[1];

        //Change preview with new image rotated
        $preview.attr('src', src);

        // Save the new image 
        self.AttachmentArray[idx].Base64 = base64;
      }

    };

    //#endregion

    /* FUNCTIONS */

    // Show progress bar
    ImagesLoader.prototype.ShowProgress = function (style, msg, delay = 0) {

      var self = this;
      var options = self.options;

      // Already visible with the same text
      if (self.$progress.is(':visible') && self.$progressbar.text() === msg)
        return;

      self.$progressbar.removeClass();

      self.$progressbar.addClass(style.class);
      self.$progressbar.attr('style', style.style);
      self.$progressbar.text(msg);

      self.$progress.hide().fadeIn(options.fadeTime);

      if (delay > 0)
        self.$progress.delay(delay).fadeOut(options.fadeTime);
    }

    // Execute javascript function
    ImagesLoader.prototype.execJsFunction = function () {

      var self = this;
      var options = self.options;

      if (this.jsFunction != null)
        eval(this.jsFunction);
    }

    // #region Image upload

    // Apply the validation rules for attachments upload
    ImagesLoader.prototype.ApplyFileValidationRules = function (readerEvt) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      // To check if the user don't upload same images
      if (self.CheckFileUnique(readerEvt.name) == false) {
        self.ShowProgress(self.barStyle.danger, options.errorduplicate + " (" + readerEvt.name + ")");
        return false;
      }

      // To check file type according to upload conditions
      if (self.CheckFileType(readerEvt.type) == false) {
        self.ShowProgress(self.barStyle.danger, options.errorformat + ": " + options.filesType.toString().replaceAll(',', ', ') + " (" + readerEvt.name + ")");
        return false;
      }

      // To check file size according to upload conditions
      if (self.CheckFileSize(readerEvt.size) == false) {
        self.ShowProgress(self.barStyle.danger, options.errorsize + " " + options.maxSize / 1000 + " Kb (" + readerEvt.name + ")");
        return false;
      }

      // To check files count according to upload conditions
      if (self.CheckFilesCount() == false)
        return false;

      return true;
    }

    // Check file type according to upload conditions
    ImagesLoader.prototype.CheckFileType = function (fileType) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      return options.filesType.indexOf(fileType) != -1
    }

    //To check file Size according to upload conditions
    ImagesLoader.prototype.CheckFileSize = function (fileSize) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      return (fileSize < options.maxSize);
    }

    //To check files count according to upload conditions
    ImagesLoader.prototype.CheckFilesCount = function () {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      //To check the length does not exceed files maximum
      return (self.AttachmentArray.length < options.maxfiles);
    }

    //To check files if the image is not alredy uploaded
    ImagesLoader.prototype.CheckFileUnique = function (filename) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      for (var i = 0; i < self.AttachmentArray.length; i++)
        if (self.AttachmentArray[i].FileName == filename)
          return false;

      return true;
    }

    // Check validity before submit
    ImagesLoader.prototype.CheckValidity = function () {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;
      var retVal = true;

      if (self.AttachmentArray.length < options.minSelect) {

        self.ShowProgress(self.barStyle.danger, options.errorminfiles +": " + options.minSelect);
        retVal = false;
      }

      return retVal;
    }

    // Load images
    ImagesLoader.prototype.LoadImages = function () {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      (function handle(i) {

        if (i >= self.imagesToLoad.length)
          return;

        var url = self.imagesToLoad[i].Url;
        var name = url.substring(url.lastIndexOf('/') + 1);

        var main = (i == 0);

        var name = escape(url.substring(url.lastIndexOf('/') + 1));

        var image = new Image();
        image.crossOrigin = "anonymous"; // This enables CORS
        image.onload = function () {

          var src = imageToFormat(this, options.maxWidth, options.maxHeight, options.imgType, options.imgQuality);
          var base64 = src.split("base64,")[1];

          self.AttachmentArray.push({
            AttachmentType: 1
            , ObjectType: 1
            , FileName: name
            , FileDescription: "Attachment"
            , NoteText: ''
            , MimeType: options.imgType
            , Base64: base64
            , FileSizeInBytes: base64.length
            , File: null
          });

          self.RenderThumbnail(url, name, main, true);

          handle(++i);
        };

        image.src = url;

      })(0);
    }

    //Render attachments thumbnails.
    ImagesLoader.prototype.RenderThumbnail = function (src, name, main = false, reload = false) {

      var self = this;
      var element = self.element;
      var $element = $(element);
      var options = self.options;

      var $div = self.$model.clone(true, true);
      $div.attr('data-type', 'image');
      $div.attr('data-id', name);

      var $noimage = $div.find('[data-type="noimage"]');

      var $preview = $div.find('[data-type="preview"]');
      $preview.attr('src', src);

      var $btnAdd = $div.find('[data-type="add"]');
      let $btnModify = $div.find('[data-type="btn-modify"]');
      var $btnRemove = $div.find('[data-type="remove"]');
      var $btnMain = $div.find('[data-type="main"]');
      var $btnLeft = $div.find('[data-type="left"]');
      var $btnRight = $div.find('[data-type="right"]');
      var $ratioBox = $div.find('[data-type="image-ratio-box"]');

      $ratioBox.attr('data-toggle', 'tooltip');
      $ratioBox.attr('data-placement', 'top');

      if(reload)
        $ratioBox.attr('title', src.substring(src.indexOf('_') + 1));
      else
        $ratioBox.attr('title', decodeURI(name));

      //if is main image
      if (main) {

        var $tag = $ratioBox.find('.main-tag');
        $tag.show();

      }

      $btnModify.fadeIn(options.fadeTime);

      //button modify popover
      $btnModify.popover({

        html: true
        ,trigger: "manual"
        , title: function () {
          return "<p class='m-0 p-0' style='text-align:center'>" + options.modifyimagetext + "</p>";
        }
        , content: function () {

          var popoverContent = $element.find('[data-type="popover"]').first().clone(true, true);

          var id = $btnModify.closest('[data-type="image"]').attr('data-id');
          var idx = self.AttachmentArray.map(function (file) { return file.FileName; }).indexOf(id);

          // If is the main image hide left button and main button 
          if (idx == 0) {

            $(popoverContent).find('[data-operation="left"]').addClass('disabled');
            $(popoverContent).find('[data-operation="left"]').css('cursor', 'default');
            $(popoverContent).find('[data-operation="left"]').removeAttr('data-operation');
            $(popoverContent).find('[data-operation="main"]').addClass('disabled');
            $(popoverContent).find('[data-operation="main"]').css('cursor', 'default');
            $(popoverContent).find('[data-operation="main"]').removeAttr('data-operation');
          }

          // Hide right button if there is no other image in the right
          if (idx == self.AttachmentArray.length - 1) {

            $(popoverContent).find('[data-operation="right"]').addClass('disabled');
            $(popoverContent).find('[data-operation="right"]').css('cursor', 'default');
            $(popoverContent).find('[data-operation="right"]').removeAttr('data-operation');
          }

          $(popoverContent).find('[data-operation]').click(function () {
            $btnModify.parent().trigger($(this).data('operation'));
          });

          return popoverContent;
        }       
      }).on("click", function () {

        $element.find('[data-toggle=popover]').not(this).popover('hide');

        var self = this;
        var $self = $(self);

        $self.popover("show");

        $(".popover").on("mouseleave", function () {
          $self.popover('hide');
        });
      });

      $ratioBox.tooltip();

      $noimage.hide();
      $btnAdd.hide();

      $div.insertBefore(self.$addImage);
      $div.show();

      $preview.fadeIn(options.fadeTime);

      return $div;
    }

    //#endregion

    //#region Ajax calls

    //#endregion

    //#region Tooltip

    // Hide tooltip
    ImagesLoader.prototype.hideTooltip = function () {

      var self = this;
      var options = self.options;

      self.$element.find('[data-toggle="tooltip"]').tooltip('hide');
    }

    // Init tooltip
    ImagesLoader.prototype.initTooltip = function (obj) {

      var self = this;
      var options = self.options;
      var $obj = $(obj);

      $obj.find('[data-toggle="tooltip"]').tooltip({
        delay: { show: 200, hide: 0 },
        trigger: "hover"
      });
    }

    //#endregion

    //#region Init

    // Init component
    ImagesLoader.prototype.init = function () {

      // Declare & init
      var self = this;
      var options = this.options;
      var element = this.element;
      var $element = $(element);

      // To save an array of attachments 
      this.AttachmentArray = [];

      this.jsFunction = options.jsFunction;

      this.$model = $element.find('[data-type="image-model"]');

      this.$model.bind('remove', (function (evt) { self.btnRemoveClick(evt, this); }));
      this.$model.bind('main', (function (evt) { self.btnMainClick(evt, this); }));
      this.$model.bind('left', (function (evt) { self.btnLeftClick(evt, this); }));
      this.$model.bind('right', (function (evt) { self.btnRightClick(evt, this); }));
      this.$model.bind('rotateclockwise', (function (evt) {

        options.rotation = 90;
        self.btnRotateClick(evt, this);
      }));
      this.$model.bind('rotateanticlockwise', (function (evt) {

        options.rotation = -90;
        self.btnRotateClick(evt, this);
      }));

      this.$btnAdd = $element.find('[data-type="add"]');
      this.$btnAdd.click(function (evt) { self.btnAddClick(evt, this); });

      this.$noImage = $element.find('[data-type="noimage"]');
      this.$noImage.click(function (evt) { self.btnAddClick(evt, this); });

      this.$btnRemove = $element.find('[data-type="remove"]');
      this.$btnRemove.click(function (evt) { self.btnRemoveClick(evt, this); });

      this.imagesToLoad = options.imagesToLoad;

      this.$files = $('#' + options.inputID);
      this.$files.bind('change', (function (evt) { self.btnChangeClick(evt, this); }));

      this.$progress = $element.find('[data-type="progress"]').first();
      this.$progressbar = $element.find('[data-type="progressBar"]').first();

      this.barStyle = {
        successStriped: { class: 'progress-bar progress-bar-striped progress-bar-animated bg-success', style: 'width: 100%' }
        , warning: { class: 'progress-bar progress-bar-striped progress-bar-animated bg-warning', style: 'width: 100%; color: #5a5a5a' }
        , success: { class: 'progress-bar bg-success', style: 'width: 100%' }
        , danger: { class: 'progress-bar bg-danger', style: 'width: 100%' }
      };

      // First image
      this.$addImage = this.$model.clone(true, true);
      this.$addImage.attr('data-type', 'image-add');
      this.$addImage.appendTo($element);

      // Load images
      if (this.imagesToLoad != null)
        this.LoadImages();

      // Show add image
      if (this.imagesToLoad == null || this.imagesToLoad.length < this.options.maxfiles)
        this.$addImage.show();
    }

    //#endregion

    // ImagesLoader PLUGIN DEFINITION

    var imagesloader_version = '1.0.1';
    var imagesloader_pluginName = 'format.imagesloader';
    var imagesloader_fileName = "jquery.imagesloader";

    var old = $.fn.imagesloader;

    $.fn.imagesloader = function (option) {

      $.fn.imagesloader.loadCSS();

      return this.each(function () {

        var $this = $(this)
        var data = $this.data(imagesloader_pluginName)
        var options = typeof option == 'object' && option

        if (!data) {
          if (option == 'destroy') return
          this.plugin = new ImagesLoader(imagesloader_pluginName, this, options)
          $this.data(imagesloader_pluginName, this.plugin)
        }

        if (typeof option == 'string') data[option]()
      })
    }

    // Load a CSS file
    $.fn.imagesloader.loadCSS = function () {

      var href = $("script[src*='" + imagesloader_fileName + "']").attr('src').split("-")[0];

      if ($("link[href*='" + imagesloader_fileName + "']").length == 0) {
        var css = $("<link rel='stylesheet' type='text/css' href='" + href + ".css'>");
        $("head").append(css);
      }
    };

    //ImagesLoader costructor
    $.fn.imagesloader.Constructor = ImagesLoader

    // Images loader NO CONFLICT
    $.fn.imagesloader.noConflict = function () {
      $.fn.imagesloader = old
      return this
    }

  }(jQuery);