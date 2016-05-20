<script type="text/javascript">
    $(document).ready(function(){
        var $tags = $('.tags');
        $tags.on("click", "input[type='checkbox']", function(){
            var root = $(this).closest('ul').parent();
            var isGroup = root.hasClass("form-group");
            if(!isGroup) {
                root.find('.group_tag').prop( "checked", true )
            }
        })
    })
</script>