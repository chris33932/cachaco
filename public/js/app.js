// this variable is the list in the dom, it's initiliazed when the document is ready


var $collectionHolder;
// the link which we click on to add new items
var $addNewItem = $('<a href="#" class="btn btn-info">agregar detalle</a>');
// when the page is loaded and ready
$(document).ready(function () {
    // get the collectionHolder, initilize the var by getting the list;
    $collectionHolder = $('#hecho_list');
    // append the add new item link to the collectionHolder
    $collectionHolder.append($addNewItem);
    // add an index property to the collectionHolder which helps track the count of forms we have in the list
    $collectionHolder.data('index', $collectionHolder.find('.card').length)
    // finds all the cards in the list and foreach one of them we add a remove button to it
    // add remove button to existing items
    $collectionHolder.find('.card').each(function () {
        // $(this) means the current card that we are at
        // which means we pass the card to the addRemoveButton function
        // inside the function we create a footer and remove link and append them to the card
        // more informations in the function inside
        addRemoveButton($(this));
    });
    // handle the click event for addNewItem
    $addNewItem.click(function (e) {
        // preventDefault() is your  homework if you don't know what it is
        // also look up preventPropagation both are usefull
        e.preventDefault();
        // create a new form and append it to the collectionHolder
        // and by form we mean a new card which contains the form
        addNewForm();
    })
});
/*
 * creates a new form and appends it to the collectionHolder
 */
function addNewForm() {
    // getting the prototype
    // the prototype is the form itself, plain html
    var prototype = $collectionHolder.data('prototype');
    // get the index
    // this is the index we set when the document was ready, look above for more info
    var index = $collectionHolder.data('index');
    // create the form
    var newForm = prototype;
    // replace the __name__ string in the html using a regular expression with the index value
    newForm = newForm.replace(/__name__/g, index);
    // incrementing the index data and setting it again to the collectionHolder
    $collectionHolder.data('index', index+1);
    // create the card
    // this is the card that will be appending to the collectionHolder
    var $card = $('<div class="card card-warning"><div class="card-heading"></div></div>');
    // create the card-body and append the form to it
    var $cardBody = $('<div class="card-body"></div>').append(newForm);
    // append the body to the card
    $card.append($cardBody);
    // append the removebutton to the new card
    addRemoveButton($card);
    // append the card to the addNewItem
    // we are doing it this way to that the link is always at the bottom of the collectionHolder
    $addNewItem.before($card);
}

/**
 * adds a remove button to the card that is passed in the parameter
 * @param $card
 */
function addRemoveButton ($card) {
    // create remove button
    var $removeButton = $('<a href="#" class="btn btn-danger">Remove</a>');
    // appending the removebutton to the card footer
    var $cardFooter = $('<div class="card-footer"></div>').append($removeButton);
    // handle the click event of the remove button
    $removeButton.click(function (e) {
        e.preventDefault();
        // gets the parent of the button that we clicked on "the card" and animates it
        // after the animation is done the element (the card) is removed from the html
        $(e.target).parents('.card').slideUp(1000, function () {
            $(this).remove();
        })
    });
    // append the footer to the card
    $card.append($cardFooter);
}

//autocompletado



  $(document).ready(function(){
    $('#hecho_rep_geo_ocu > option[value="1"]').attr('selected', 'selected');
    });

    $(document).ready(function(){
    $('#hecho_oca_delito > option[value="6"]').attr('selected', 'selected');
        });
      

