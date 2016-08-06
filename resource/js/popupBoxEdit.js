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

//https://www.devbridge.com/sourcery/components/jquery-autocomplete/
//https://github.com/Pixabay/jQuery-autoComplete

jQuery(document).ready(function(){
    //register functions here
    popupBoxEdit.autoComplete();

    popupBoxEdit;
});