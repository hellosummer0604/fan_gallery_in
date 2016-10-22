var popupBoxEdit = popupBoxEdit || {}

popupBoxEdit.autoComplete = function () {

    //var bestPictures = new Bloodhound({
    //    datumTokenizer: Bloodhound.tokenizers.whitespace('value'),
    //    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //    // url points to a json file that contains an array of country names, see
    //    // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
    //    prefetch: '/ajax_controller/tag/'
    //});
    //
    //jQuery('.innerBox .typeahead').typeahead(null, {
    //    name: 'dsad',
    //    display: 'value',
    //    source: bestPictures
    //}).bind('typeahead:selected', function(obj, selected, name) {
    //    console.log(selected);
    //});


    var tagList = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/ajax_controller/tag',
        //prefetch: 'https://twitter.github.io/typeahead.js/data/films/post_1960.json',

    });

    jQuery('#imgTagNameAutoComplete .typeahead').typeahead({
        minLength: 1,
        hint: true,
        highlight: true,
        limit: 100
    }, {
        name: 'best-pictures',
        display: 'value',
        source: tagList,
    }).bind('typeahead:selected', function(obj, datum, name) {
        console.log(datum.id);
        console.log(datum.value);
    });

}

popupBoxEdit.bindRemoveTag = function() {
    jQuery('.itag').each(function() {
        jQuery(this).off('click').on('click', function (event) {
            event.preventDefault();
        });
    })

    jQuery('.itag').each(function() {
        jQuery(this).off('dblclick').on('dblclick', function(event) {
            jQuery(this).remove();

            event.preventDefault();
        });
    });


}

popupBoxEdit.getAllTags = function () {
    var tagArray = [];

    jQuery('#imgTags > .itag').each(function() {
        tagArray.push(jQuery(this).find('a').text());
    });

    return tagArray;
}

popupBoxEdit.addNewTag = function () {
    jQuery('#newImgTag').keyup(function(e){
        if(e.keyCode == 13)
        {
            var tagName = jQuery(this).val().trim();

            if (tagName.length < 1 || tagName > 20) {
                return;
            }

            if (popupBoxEdit.getAllTags().length >= 10) {
                return;
            }

            if (popupBoxEdit._isDuplicateTag(tagName) == false) {
                jQuery('span#imgTags').append('<div class=\"itag\"><a href=\"#\">'+ tagName + '</a></div>');

                popupBoxEdit.bindRemoveTag();

                jQuery(this).val('');
            }

            jQuery(this).val('');
        }
    });
}

popupBoxEdit._isDuplicateTag = function(tagName) {
    var isDuplicate = false;

    jQuery.each(popupBoxEdit.getAllTags(), function (invex, value) {
        if (value == tagName) {
            isDuplicate = true;
            return false;
        }
    });

    return isDuplicate;
}

//https://www.devbridge.com/sourcery/components/jquery-autocomplete/
//https://github.com/Pixabay/jQuery-autoComplete

jQuery(document).ready(function(){
    //register functions here
    popupBoxEdit.autoComplete();

    popupBoxEdit.bindRemoveTag();

    popupBoxEdit.addNewTag();
    //popupBoxEdit;
});