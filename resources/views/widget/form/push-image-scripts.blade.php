@push('js')
    <script>
        var inputIdSelectImg = null;
        function initializeCheckSelectImg(id)
        {
            inputIdSelectImg = id;
            document.body.onfocus = checkItSelectImg;
        }
        function checkItSelectImg()
        {
            setTimeout(function () {
                if($('#'+inputIdSelectImg+'_img').attr('src') === defaultImageUrl){
                    wideCardDeleteImage(inputIdSelectImg);
                }
            }, 500);
            document.body.onfocus = null;
        }

        function addNewItemsForm() {
            var addNewItemsFormBtn = $('#add-new-items-form-btn').clone();
            $('#add-new-items-form-btn').remove();
            var newItemI = Date.now()+'_';
            $('#add-new-card-photo-template').tmpl({
                newItemI: newItemI,
            }).appendTo('#items-card-photos-div');
            $('#items-card-photos-div').append(addNewItemsFormBtn);

            $('#{{ $id }}_'+newItemI).trigger('click');
            initializeCheckSelectImg('{{ $id }}_'+newItemI);
        }

        function wideCardDeleteImage(id, clearOnly) {
            var itemId = $('#'+id+'_wide-card');
            var urlDeleteImage = itemId.find('img').attr('src');
            urlDeleteImage = urlDeleteImage.split("?")[0];
            if(urlDeleteImage && urlDeleteImage !== '' && urlDeleteImage !== defaultImageUrl){
                var val = $('#images_deleted_input').val();
                $('#images_deleted_input').val((val !== '' ? val+','+urlDeleteImage : urlDeleteImage));
            }
            if(clearOnly){
                itemId.find('img').attr('src', defaultImageUrl);
            }else {
                itemId.remove();
            }
        }

    </script>
@endpush