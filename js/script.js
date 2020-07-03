var _loading = '<span id="js-loading"></span>';
var isLoading = false,
    allPostsLoaded = false;

$( () => {

    $('#js-load-more').bind('click', loadMorePosts);
    $(window).scroll(checkPageBottom);
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
        loading();
        return;
    }

    var currPage = parseInt($('#js-load-more').attr('data-curr-page'));
    var url = $(location).attr('href') + '?page=' + currPage;

    loading('.c-container-posts');

    $.ajax({
        url: url,
        success: function(data){
            loading();
            $('.c-container-posts').append(data);
            $('#js-load-more').attr('data-curr-page', (currPage + 1).toString());

            console.log(data);

            if (!data) {
                allPostsLoaded = true;
            }
        }
    });

}

function checkPageBottom() {
    
    if($(window).scrollTop() + $(window).height() > $(document).height() - 375) {
        loadMorePosts();
    }
}