<form action="{{action('\Pinerp\ImageHandler\ImageHandlerController@postStore')}}" id="image-dropzone" class="uploadform dropzone no-margin dz-clickable">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="imageable_id" value="{{$object->id}}">
    <input type="hidden" name="imageable_type" value="{{get_class($object)}}">
    <div class="dz-default dz-message">
        <p>{{trans('image_handler::trans.info')}}</p>
    </div>
</form>
@if(count($object->images))
<div>
    <h4>{{trans('image_handler::trans.attached_images')}}</h4>
    <ul>
        @foreach($object->images as $image)
            <li><img src="{{uploads().$image->filename}}" width="75" height="75"> <a href="{{action('\Pinerp\ImageHandler\ImageHandlerController@getDeleteImage', $image->id)}}" class="btn btn-danger destroy-image">Удалить</a></li>
        @endforeach
    </ul>
</div>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        //       Dropzone.autoDiscover = false; // keep this line if you have multiple dropzones in the same page
        $(".uploadform").dropzone({
            acceptedFiles: "image/*",
            paramName: "file",
            url: '{{action('\Pinerp\ImageHandler\ImageHandlerController@postStore')}}',
            maxFiles: 5, // Number of files at a time
            maxFilesize: 10, //in MB
            maxfilesexceeded: function(file)
            {
                alert('Вы не можете приложить более 5 фото к одной работе!');
            },
            /*success: function (response) {
             var x = JSON.parse(response.xhr.responseText);
             $('.icon').hide(); // Hide Cloud icon
             $('#uploader').modal('hide'); // On successful upload hide the modal window
             $('.img').attr('src',x.img); // Set src for the image
             $('.thumb').attr('src',x.thumb); // Set src for the thumbnail
             $('img').addClass('imgdecoration');
             this.removeAllFiles(); // This removes all files after upload to reset dropzone for next upload
             console.log('Image -> '+x.img+', Thumb -> '+x.thumb); // Just to return the JSON to the console.
             },*/
            addRemoveLinks: true,
            removedfile: function(file) {
                    var _ref; // Remove file on clicking the 'Remove file' button
                $.post('{{action('\Pinerp\ImageHandler\ImageHandlerController@postRemoveImage')}}', {
                    _token: '{{csrf_token()}}',
                    filename: file.name
                }, function(response) {
                    if(response.code == 200) {
                        console.log('removed');
                    }
                })
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });
    });
</script>

