const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/home.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
   // .scripts([
   //    // 'resources/vendor/kityminder-editor/bower_components/jquery/dist/jquery.js',
   //    'resources/vendor/kityminder-editor/bower_components/bootstrap/dist/js/bootstrap.js',
   //    'resources/vendor/kityminder-editor/bower_components/angular/angular.js',
   //    'resources/vendor/kityminder-editor/bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
   //    'resources/vendor/kityminder-editor/bower_components/codemirror/lib/codemirror.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/mode/xml/xml.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/mode/javascript/javascript.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/mode/css/css.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/mode/htmlmixed/htmlmixed.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/mode/markdown/markdown.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/addon/mode/overlay.js',
   //    // 'resources/vendor/kityminder-editor/bower_components/codemirror/mode/gfm/gfm.js',
   //    'resources/vendor/kityminder-editor/bower_components/angular-ui-codemirror/ui-codemirror.js',
   //    'resources/vendor/kityminder-editor/bower_components/marked/lib/marked.js',
   //    'resources/vendor/kityminder-editor/bower_components/kity/dist/kity.min.js',
   //    'resources/vendor/kityminder-editor/bower_components/hotbox/hotbox.js',
   //    'resources/vendor/kityminder-editor/bower_components/json-diff/json-diff.js',
   //    // 'resources/vendor/kityminder-editor/node_modules/kityminder-core/dist/kityminder.core.min.js',
   //    'resources/vendor/kityminder-editor/bower_components/color-picker/dist/color-picker.min.js',
   //    'resources/vendor/kityminder-editor/dist/kityminder.editor.min.js',
   // ], 'public/vendor/kityminder/kityminder.js')
   // .styles([
   //    'resources/vendor/kityminder-editor/bower_components/bootstrap/dist/css/bootstrap.css',
   //    'resources/vendor/kityminder-editor/bower_components/codemirror/lib/codemirror.css',
   //    'resources/vendor/kityminder-editor/bower_components/hotbox/hotbox.css',
   //    'resources/vendor/kityminder-editor/node_modules/kityminder-core/dist/kityminder.core.css',
   //    'resources/vendor/kityminder-editor/bower_components/color-picker/dist/color-picker.min.css',
   //    'resources/vendor/kityminder-editor/dist/kityminder.editor.min.css',
   //    'resources/font-awesome-4.7.0/css/font-awesome.min.css',
   // ], 'public/vendor/kityminder/kityminder.css')
   // .options({
   //    processCssUrls: false
   // })
   // .copyDirectory('resources/vendor/kityminder-editor/dist/images', 'public/vendor/kityminder/images')
   // .copy('resources/vendor/kityminder-editor/bower_components/bootstrap/dist/fonts/*', 'public/vendor/fonts/')
   // .copy('resources/font-awesome-4.7.0/fonts/*', 'public/vendor/fonts/')
