<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>KityMinder Editor - Powered By FEX</title>

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
<h1 class="editor-title">KityMinder Editor - Powered By FEX</h1>
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

@yield('scripts')

</html>
