<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="favicon.ico" type="image/x-icon" rel="shortcut icon">

	<link rel="stylesheet" href="{{ asset('vendor/kityminder/kityminder.css') }}" />
    <style>
		html, body {
			margin: 0;
			padding: 0;
			height: 100%;
			overflow: hidden;
		}
		.editor-title {
			background: #393F4F;
			color: white;
			height: 40px;
			padding: 0 20px;
		}
        .editor-title .doc-name, .editor-title .doc-share ,
        .editor-title .doc-return-up,
        .editor-title .doc-publish{
			margin: 0 0 0 10px;
			line-height: 40px;
			font-family: 'Hiragino Sans GB', 'Arial', 'Microsoft Yahei';
			font-weight: normal;
            display:inline-block;
            vertical-align: middle;
            cursor: pointer;
        }
        .editor-title .doc-share ,.editor-title.doc-return-up{
            color: #ccc;
            font-size: 12px;
        }
        
        .editor-title .doc-name{
            font-size: 14px;
            width: 60%;
            text-align: center;
            margin-left: 3rem;
        }
        .editor-title .doc-share {
            cursor: pointer;
        }
        .editor-title .fa{
            font-size:14px;
            margin-right:1rem;

        }
		div.minder-editor-container {
			position: absolute;
			top: 40px;
			bottom: 0;
			left: 0;
			right: 0;
        }
        #xyModal input{
            width: 80%;
            padding: 5px 10px;
            color: #777;
            margin-right: 10px;
        }
        
        
	</style>
</head>
<body ng-app="editDocApp" ng-controller="MainController">
@include('layouts.modal')
<div class="editor-title">
    <a class="doc-return-up" href="/home#/doc/list/{{ $docDraft['user_category_id'] ? $docDraft['user_category_id'] : '' }}">
    <i class="fa fa-reply" aria-hidden="true"></i>返回上级
    </a>
    <span class="doc-share"><i class="fa fa-share-alt" aria-hidden="true"></i>分享</span>
    <span class="doc-publish"><i class="fa fa-file-text" aria-hidden="true"></i>提交文档</span>
    <h1 class="doc-name">
        {{ $docDraft['title'] }}
    </h1>
</div>
<kityminder-editor on-init="initEditor(editor, minder)"></kityminder-editor>
</body>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/kityminder/kityminder.js') }}"></script>

<script>
    var oldMinderData = @json($docDraft['content']);

    $('.doc-share').click(function(){
        axios({
            method: 'post',
            url: '{{ route('docDraft.setShare', ['docDraft' => $docDraft['id']]) }}',
        }).then(function (res) {
            //TODO 弹框提示
            Modal.alert({
                title: '分享成功',
                msg: '<input value="{{ route('docDraft.share', ['docDraft' => $docDraft['id']]) }}" disabled="disabled" />点击复制',
            })
        });
    });

    $('.doc-publish').click(function(){
        Modal.confirm({
            title: '确认',
            msg: '<div class="text-muted" style="margin-bottom: 10px;">提交需要管理员审核，审核通过后即会公开文档</div>\
            <div class="form-group row">\
                <label for="docTitle" class="col-sm-2 col-form-label">标题</label>\
                <div class="col-sm-10">\
                    <input type="text" class="form-control" id="docTitle" name="docTitle" value="' + $('.doc-name').text().trim() + '" />\
                </div>\
            </div>\
            <div class="form-group row">\
                <label for="docDescription" class="col-sm-2 col-form-label">描述</label>\
                <div class="col-sm-10">\
                    <textarea class="form-control" id="docDescription" name="docDescription" rows="3"></textarea>\
                </div>\
            </div>',
        }).on(function (e) {
            e.stopPropagation();
            var docTitle = $('#docTitle').val().trim();
            var docDescription = $('#docDescription').val().trim();
            var hasError = false;
            if (docTitle == '') {
                $('#docTitle').parent('div').addClass('has-error');
                hasError = true;
            }
            if (docDescription == '') {
                $('#docDescription').parent('div').addClass('has-error');
                hasError = true;
            }
            if (hasError) {
                return false;
            }
            axios({
                method: 'post',
                url: '{{ route('docDraft.publish', ['docDraft' => $docDraft['id']]) }}',
                data: {
                    title: docTitle,
                    description: docDescription,
                }
            }).then(function (res) {
                toastr.success('提交成功，待管理员审核');
                Modal.close();
            });
        });
    });

	angular.module('editDocApp', ['kityminderEditor'])
        .config(function (configProvider) {
            configProvider.set('imageUpload', '{{ route('upload.docImage', ['docDraft' => $docDraft['id']]) }}');
        })
        .controller('MainController', function($scope) {
            $scope.initEditor = function(editor, minder) {
                window.editor = editor;
                window.minder = minder;

                if (typeof oldMinderData == 'object') {
                    minder.importJson(oldMinderData);
                    oldMinderData = JSON.stringify(oldMinderData);
                } else {
                    minder.select(minder.getRoot(), true);
                    minder.execCommand('text', '{{ $docDraft['title'] }}');
                }

                minder.on('contentchange', function() {
                    setTimeout(function() {
                        var newMinderData = minder.exportJson();
                        if (JSON.stringify(newMinderData) != oldMinderData) {
                            // save
                            axios({
                                method: 'put',
                                url: '{{ route('docDraft.save', ['docDraft' => $docDraft['id']]) }}',
                                data: {
                                    content: newMinderData
                                },
                            }).then(function (res) {
                                $('.doc-name').text(newMinderData.root.data.text);
                                oldMinderData = JSON.stringify(newMinderData);
                            });
                        }
                    }, 500);
                });
            };
        });

</script>

</html>
