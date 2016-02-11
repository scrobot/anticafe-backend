var photo_counter = parseInt($('#photoCounter').text())
var dzId = $('#image-dropzone');

Dropzone.options.imageDropzone = {

    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 8,
    maxFiles: 5,
    previewsContainer: '#dropzonePreview',
    previewTemplate: document.querySelector('#preview-template').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Убрать',
    dictFileTooBig: 'Максимальный размер файла 8MB',
    dictMaxFilesExceeded: 'Вы можете загружать не более 5 файлов одновременно в одну работу',

    // The setting up of the dropzone
    init:function() {

        var thisDropzone = this;

        $.ajax({
            type: 'GET',
            url: '/handlers/images/thumbnails',
            data: {
                _session: dzId.find('input[name="_session"]').val()
            },
            dataType: 'html',
            success: function(data){
                var rep = JSON.parse(data);
                $.each(rep, function(key,value){

                    var mockFile = { name: value.name, size: value.size };

                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);

                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);

                    thisDropzone.options.complete.call(thisDropzone, mockFile, 1);

                });
            }
        });

        this.on("removedfile", function(file) {
            $.ajax({
                type: 'POST',
                url: '/handlers/images/delete',
                data: {
                    id: file.name,
                    _token: dzId.find('input[name="_token"]').val(),
                    _folder: dzId.find('input[name="_folder"]').val(),
                    _session: dzId.find('input[name="_session"]').val()
                },
                dataType: 'html',
                success: function(data){
                    var rep = JSON.parse(data);
                    if(rep.code == 200)
                    {
                        photo_counter--;
                        $("#photoCounter").text(photo_counter);
                    }

                }
            });

        } );
    },
    error: function(file, response) {
        if($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
    success: function(file,done) {
        photo_counter++;
        $("#photoCounter").text(photo_counter);
    }
}

$('body').on('click', '.dz-preview', function(){
    var current = $(this);

    if(current.hasClass('dz-remove')) {
        return false;
    }

    var filename = current.find('.dz-filename span').text()

    $.ajax({
        type: 'POST',
        url: '/handlers/images/preview',
        data: {
            id: filename,
            _token: dzId.find('input[name="_token"]').val(),
            _session: dzId.find('input[name="_session"]').val()
        },
        dataType: 'html',
        success: function(data){
            var rep = JSON.parse(data);
            if(rep.code == 200)
            {
                $('.dz-preview').removeClass('dz-preview-checked')
                current.addClass('dz-preview-checked')
            }

        }
    });

})

$(document).ready(function(){

    var html = "<input type='hidden' name='_session' value='" + dzId.find('input[name="_session"]').val() + "'>"

    console.log(html)

    $('.image-handler-binded-form').find('input[name="_token"]').after(html)

})