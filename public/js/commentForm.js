$(document).ready(function () {
  $('[name="comment"]').submit(function (event) {
    event.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var method = form.attr('method');
    var data = form.serialize();

    $.ajax({
      url: url,
      method: method,
      data: data,
      dataType: 'json',
      success: function (response) {

        var newCommentHtml = `
          <div style="background: #cccccc; ">
            <p>Name:
              <a href="mailto:${response.email}">${response.name}</a>
            </p>
            <p>${response.comment}</p>
          </div>
          <hr/>
        `;

        $('#comments').prepend(newCommentHtml);

        form.trigger('reset');
      }
    });
  });
});
