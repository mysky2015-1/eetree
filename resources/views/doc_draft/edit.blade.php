<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="favicon.ico" type="image/x-icon" rel="shortcut icon">

	<!-- bower:css -->
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.css') }}" />
	<link rel="stylesheet" href="{{ asset('bower_components/codemirror/lib/codemirror.css') }}" />
	<link rel="stylesheet" href="{{ asset('bower_components/hotbox/hotbox.css') }}" />
	<link rel="stylesheet" href="{{ asset('bower_components/kityminder-core/dist/kityminder.core.css') }}" />
	<link rel="stylesheet" href="{{ asset('bower_components/color-picker/dist/color-picker.min.css') }}" />
	<!-- endbower -->

	<link rel="stylesheet" href="{{ asset('bower_components/kityminder-editor/dist/kityminder.editor.min.css') }}">

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
        .editor-title .doc-name, .editor-title .doc-share {
			margin: 0 0 0 10px;
			font-size: 14px;
			line-height: 40px;
			font-family: 'Hiragino Sans GB', 'Arial', 'Microsoft Yahei';
			font-weight: normal;
            float:left;
        }
        .editor-title .doc-share {
            cursor: pointer;
        }
		div.minder-editor-container {
			position: absolute;
			top: 40px;
			bottom: 0;
			left: 0;
			right: 0;
		}
	</style>
</head>
<body ng-app="editDocApp" ng-controller="MainController">
<div class="editor-title">
    <h1 class="doc-name">
        @if (empty($docDraft['title']))
            新建文档
        @else
            {{ $docDraft['title'] }}
        @endif
    </h1>
    <span class="doc-share">分享</span>
</div>
<kityminder-editor on-init="initEditor(editor, minder)"></kityminder-editor>
</body>

<!-- bower:js -->
<script src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('bower_components/angular/angular.js') }}"></script>
<script src="{{ asset('bower_components/angular-bootstrap/ui-bootstrap-tpls.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/lib/codemirror.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/mode/xml/xml.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/mode/javascript/javascript.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/mode/css/css.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/mode/markdown/markdown.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/addon/mode/overlay.js') }}"></script>
<script src="{{ asset('bower_components/codemirror/mode/gfm/gfm.js') }}"></script>
<script src="{{ asset('bower_components/angular-ui-codemirror/ui-codemirror.js') }}"></script>
<script src="{{ asset('bower_components/marked/lib/marked.js') }}"></script>
<script src="{{ asset('bower_components/kity/dist/kity.min.js') }}"></script>
<script src="{{ asset('bower_components/hotbox/hotbox.js') }}"></script>
<script src="{{ asset('bower_components/json-diff/json-diff.js') }}"></script>
<script src="{{ asset('bower_components/kityminder-core/dist/kityminder.core.min.js') }}"></script>
<script src="{{ asset('bower_components/color-picker/dist/color-picker.min.js') }}"></script>
<!-- endbower -->

<script src="{{ asset('bower_components/kityminder-editor/dist/kityminder.editor.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    @if (empty($docDraft['title']))
        var oldMinderData = '';
        var newDoc = true;
    @else
        var oldMinderData = @json($docDraft['content']);
        var newDoc = false;

        $('.doc-share').click(function(){
            axios({
                method: 'get',
                url: '{{ route('docDraft.share', ['docDraft' => $docDraft['id']]) }}',
            }).then(function (res) {
                layer.msg('分享成功，待管理员审核', {icon: 1}, function() {
                    location.href = '{{ route('home') }}#/doc/list/{{ $docDraft['user_category_id'] ?: '' }}'
                });
            });
        });
    @endif
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
                }

                minder.on('contentchange', function() {
                    var newMinderData = minder.exportJson();
                    if (JSON.stringify(newMinderData) != oldMinderData) {
                        // save
                        axios({
                            method: 'post',
                            url: '{{ route('docDraft.save', ['docDraft' => $docDraft['id']]) }}',
                            data: {
                                content: newMinderData
                            },
                        }).then(function (res) {
                            if (newDoc) {
                                location.href = res.data.data.url;
                            }
                            $('.doc-name').text(newMinderData.root.data.text);
                            oldMinderData = JSON.stringify(newMinderData);
                        });
                    }
                });
            };
        });

</script>

</html>
