<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>

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
		h1.editor-title {
			background: #393F4F;
			color: white;
			margin: 0;
			height: 40px;
			font-size: 14px;
			line-height: 40px;
			font-family: 'Hiragino Sans GB', 'Arial', 'Microsoft Yahei';
			font-weight: normal;
			padding: 0 20px;
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
<body ng-app="kityminderDemo" ng-controller="MainController">
<h1 class="editor-title">
    @if (empty($docDraft))
        新建文档
    @else
        {{ $docDraft['title'] }}
    @endif
</h1>
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
<script src="{{ asset('vendor/layer/layer.js') }}"></script>

<script>
    @if (empty($docDraft))
        var oldMinderData = '';
        var saveUrl = '{{ route('docDraft.save') }}';
        var newDoc = true;
    @else
        var oldMinderData = @json($docDraft['content']);
        var saveUrl = '{{ route('docDraft.save', ['docDraft' => $docDraft['id']]) }}';
        var newDoc = false;
    @endif
	angular.module('kityminderDemo', ['kityminderEditor'])
        .config(function (configProvider) {
            configProvider.set('imageUpload', '../server/imageUpload.php');
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
                        $.post({
                            url: saveUrl,
                            data: {
                                content: newMinderData
                            },
                            success: function(res) {
                                if (res.status != 'success') {
                                    return;
                                }
                                if (newDoc) {
                                    if (window.history && 'pushState' in history) {
                                        history.replaceState(null, null, res.data.url);
                                        saveUrl = res.data.saveUrl;
                                    } else {
                                        location.href = res.data.url;
                                    }
                                }
                                $('.editor-title').text(newMinderData.root.data.text);
                                oldMinderData = JSON.stringify(newMinderData);
                            },
                            error : function (XMLHttpRequest) {
                                if (XMLHttpRequest.responseJSON.code == 422) {
                                    layer.msg(XMLHttpRequest.responseJSON.message);
                                }
                            },
                        });
                    }
                });
            };
        });
</script>

</html>
