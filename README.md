#### 部署
* composer install
* php artisan key:generate
* php artisan jwt:secret

#### 编辑器开发
* cd resources/vendor/kityminder-editor
* npm run init

#### 构建
* 前端构建
    * npm run build:prod
* 脑图编辑器构建
    * cd resources/vendor/kityminder-editor，运行 grunt build，完成后 dist 目录里就是可用运行的 kityminder-editor, 双击 index.html 即可打开运行示例

#### TODO
* 后台分类转换
* 图片验证码
* layer