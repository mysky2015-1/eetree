window.xyComment = function(options) {
    var defaults = {
        btn: '#xyCommentBtn',
        input: '#xyCommentInput',
        url: '',
        callback: null,
    }
    var opts = $.extend(true, {}, defaults, options)
    $(opts.btn).click(function() {
        var content = $(opts.input).val().trim()
        if (content == '') {
            toastr.error('请输入评论内容')
            return false
        }
        axios({
            method: 'post',
            url: opts.url,
            data: {content: content}
        }).then(function (res) {
            toastr.success('评论成功')
            if (opts.callback && opts.callback instanceof Function) {
                opts.callback(res);
            }
        });
    });
}