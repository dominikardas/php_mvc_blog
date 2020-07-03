var _loading = '<span id="js-loading"></span>';
var isLoading = false,
    allPostsLoaded = false;

$( () => {
    $('#page-loading').remove();

    $('#js-load-more').bind('click', loadMorePosts);
    $(window).scroll(checkPageBottom);
});

$(window).load( () => {
    $('#page-loading').remove();
});

async function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}  

function loading(container) {

    if (container != null && !isLoading)  $(container).append(_loading);    
    else $('#js-loading').remove();

    isLoading = !isLoading;
}

function loadMorePosts() {

    if (isLoading || allPostsLoaded) {
        return;
    }

    var currPage = parseInt($('#js-load-more').attr('data-curr-page'));
    var url = $(location).attr('href') + '?page=' + currPage;

    loading('.c-container-posts');

    $.ajax({
        url: url,
        success: function(data){

            loading();

            if (!data) {
                allPostsLoaded = true;
                return;
            }

            $('#js-load-more').attr('data-curr-page', (currPage + 1).toString());
            $('.c-container-posts').append(data);
        }
    });

}

function checkPageBottom() {
    
    if($(window).scrollTop() + $(window).height() > $(document).height() - 375) {
        loadMorePosts();
    }
}