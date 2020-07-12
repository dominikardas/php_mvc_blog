$(() => {
    designer();
    previewPost();
    publishPost();
});

function designer() {

    $(document).on('click', '.c-designer_buttons a', function(e) {

        e.preventDefault();

        var c = $(this).data('command');

        if (c == 'h1' || c == 'h2' || c == 'h3') {
            document.execCommand('formatBlock', false, c);
        }
        else if (c == 'createlink' || c == 'insertimage') {
            url = prompt('Enter the link here: ','http:\/\/');
            document.execCommand(c, false, url);
        }
        else {
            document.execCommand(c, false, null);
        }
    });
}

function previewPost() {

    $(document).on('click', '#js-designer-btn', function(e) {

        e.preventDefault();

        $('input[name=post_content]').val($('#editable_post_content').html());
        $('.l-form-designer').submit();
    });

}

function publishPost() {

    $(document).on('click', '#js-publish-btn', function(e) {

        e.preventDefault();
        popup('.popup-publish');
    });

    $(document).on('click', '#js-publish-confirm-btn', function(e) {

        e.preventDefault();
        $('input[name=post_content]').val($('#editable_post_content').html());
        $('.l-form-designer').attr({
            'action' : '/blog/posts/publish',
            'target' : ''
        });
        $('.l-form-designer').submit();
    });

}
