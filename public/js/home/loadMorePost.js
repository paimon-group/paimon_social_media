$(document).ready(function (){
    function getLocation()
    {
        var location =  window.location.href;
        var indexCut = location.lastIndexOf("/");
        location = location.substring(indexCut);

        return location;
    }

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {


            if(getLocation() == '/home')
            {
                loadMorePostHome();
            }
            if(getLocation() == '/profile')
            {
                loadMorePostProfile();
            }
        }
    });

    function loadMorePostHome()
    {
        postHome = '<div class="post-home post-home-custom" id="">' +
            '<div class="post-header-home">' +
            '<div class="avatar-post-home">' +
            '<img src="image/avatar/avatar.jpg" alt="avatar">' +
            '</div>' +
            '<div class="user-name-and-time-post-home">' +
            '<a href="">' +
            '<div><h5>nguyen nhat khang</h5></div>' +
            '</a>' +
            '<div>12/12/2022 12:12:12</div>' +
            '</div>' +
            '<div class="option-post-home dropstart">' +
            '<button type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
            '<div><i class="bi-three-dots"></i></div>' +
            '</button>' +
            '<ul class="dropdown-menu tab-option-post-home">' +
            '<li class="dropdown-item">Delete<i class="bi-trash3-fill"></i></li>' +
            '<li class="dropdown-item">Hiden<i class="bi-incognito"></i></li>' +
            '<li class="dropdown-item">Report<i class="bi-lightning-fill"></i></li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '<div class="caption-post-home">' +
            '<p>' +
            'Mọi người gửi xe trong hầm nếu lấy thẻ (nhất là ô tô) nhớ để ý khi nhân viên quẹt thẻ. Nhân viên' +
            'thường làm động tác giả, k quẹt thẻ và mở barrier, đến lúc ra sẽ là giá mồm. Nếu mọi người để ý thì ' +
            'khi quẹt thẻ để ra màn hình nhỏ phía trước sẽ hiện số tiền, còn nếu nhân viên không quẹt, màn hình' +
            'nhỏ phía trước chỉ hiện "Hẹn gặp lại" ' +
            '</p> ' +
            '</div>' +
            '<div class="post-body-home">' +
            '<div class="img-post-home">' +
            '<img src="image/post/test-post.jpg" alt="img-post">' +
            '</div>' +
            '</div>' +
            '<div class="post-footer-home">' +
            '<div class="tym-block-post-home"> ' +
            '<div class="tym-post-home"><i class="bi-heart icon-tym-post-home" id="tym_i" data-post_id="{{ i }}"></i></div>' +
            '<div class="count-tym-post-home">123k</div>' +
            '</div>' +
            '<div class="comment-block-post-home">' +
            '<div class="comment-post-home" id="comment_{{ i }}" data-comment_id="{{ i }}"><i class="bi-chat-right-dots"></i></div>' +
            '<div class="count-comments-post-home">123k</div>' +
            '</div>' +
            '</div>' +
            '<div class="user-comments-home" id="user_comments_{{ i }}">' +
            '<hr class="separator-comment-with-post-home"> ' +
            '<div class="comment-box-post-home">'+
            '<div class="avatar-post-home">'+
            '<img src="image/avatar/avatar.jpg" alt="avatar">'+
            '</div>'+
            '<input type="text" class="txt_comment_post_home" id="txt_comment_post_home_{{ i }}" placeholder="  comment...">'+
            '<div class="btn-send-comment-post"><i class="bi-send-fill"></i></div>'+
            '</div>'+
            '</div>'+
            '</div>';

        postHomes = "";
        for (let i = 0; i < 10;i++)
        {
            postHomes += postHome;
        }

        $('.home-main').append(postHomes);

    }

    function loadMorePostProfile()
    {
        postProfile = '<div class="post-home" id="">' +
            '<div class="post-header-home">' +
            '<div class="avatar-post-home">' +
            '<img src="image/avatar/avatar.jpg" alt="avatar">' +
            '</div>' +
            '<div class="user-name-and-time-post-home">' +
            '<a href="">' +
            '<div><h5>nguyen nhat khang</h5></div>' +
            '</a>' +
            '<div>12/12/2022 12:12:12</div>' +
            '</div>' +
            '<div class="option-post-home dropstart">' +
            '<button type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
            '<div><i class="bi-three-dots"></i></div>' +
            '</button>' +
            '<ul class="dropdown-menu tab-option-post-home">' +
            '<li class="dropdown-item">Delete<i class="bi-trash3-fill"></i></li>' +
            '<li class="dropdown-item">Hiden<i class="bi-incognito"></i></li>' +
            '<li class="dropdown-item">Report<i class="bi-lightning-fill"></i></li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '<div class="caption-post-home">' +
            '<p>' +
            'Mọi người gửi xe trong hầm nếu lấy thẻ (nhất là ô tô) nhớ để ý khi nhân viên quẹt thẻ. Nhân viên' +
            'thường làm động tác giả, k quẹt thẻ và mở barrier, đến lúc ra sẽ là giá mồm. Nếu mọi người để ý thì ' +
            'khi quẹt thẻ để ra màn hình nhỏ phía trước sẽ hiện số tiền, còn nếu nhân viên không quẹt, màn hình' +
            'nhỏ phía trước chỉ hiện "Hẹn gặp lại" ' +
            '</p> ' +
            '</div>' +
            '<div class="post-body-home">' +
            '<div class="img-post-home">' +
            '<img src="image/post/test-post.jpg" alt="img-post">' +
            '</div>' +
            '</div>' +
            '<div class="post-footer-home">' +
            '<div class="tym-block-post-home"> ' +
            '<div class="tym-post-home"><i class="bi-heart icon-tym-post-home" id="tym_i" data-post_id="{{ i }}"></i></div>' +
            '<div class="count-tym-post-home">123k</div>' +
            '</div>' +
            '<div class="comment-block-post-home">' +
            '<div class="comment-post-home" id="comment_{{ i }}" data-comment_id="{{ i }}"><i class="bi-chat-right-dots"></i></div>' +
            '<div class="count-comments-post-home">123k</div>' +
            '</div>' +
            '</div>' +
            '<div class="user-comments-home" id="user_comments_{{ i }}">' +
            '<hr class="separator-comment-with-post-home"> ' +
            '<div class="comment-box-post-home">'+
            '<div class="avatar-post-home">'+
            '<img src="image/avatar/avatar.jpg" alt="avatar">'+
            '</div>'+
            '<input type="text" class="txt_comment_post_home" id="txt_comment_post_home_{{ i }}" placeholder="  comment...">'+
            '<div class="btn-send-comment-post"><i class="bi-send-fill"></i></div>'+
            '</div>'+
            '</div>'+
            '</div>';

        postProfiles = "";
        for (let i = 0; i < 10;i++)
        {
            postProfiles += postProfile;
        }

        $('.profile-main').append(postProfiles);
    }
})