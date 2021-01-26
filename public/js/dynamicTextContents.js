// setup an "add a TextContent" link
var addTextContentLink = $('<a href="#" class="add-text-content-link btn btn-primary">Add new text content</a>');
var newLinkLi = $('<div></div>').append(addTextContentLink);

jQuery(document).ready(function () {
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    var collectionHolder = $('#post_textContentList');
    collectionHolder.append(newLinkLi);
    collectionHolder.data('index', collectionHolder.find(':input').length);

    addTextContentLink.on('click', function (e) {
        e.preventDefault();

        addTextContentForm(collectionHolder, newLinkLi);
    });
});

function addTextContentForm(collectionHolder, newLinkLi) {
    var prototype = collectionHolder.data('prototype');
    var index = collectionHolder.data('index');
    var newForm = prototype.replace(/__name__/g, index);

    collectionHolder.data('index', index + 1);
    var newFormLi = $('<div></div>').append(newForm);

    newFormLi.append('<a href="#" class="remove-text-content btn btn-danger">Remove text content</a><hr /><br />');
    newLinkLi.before(newFormLi);

    $('.remove-text-content').click(function (e) {
        e.preventDefault();
        $(this).parent().remove();

        return false;
    });
}
