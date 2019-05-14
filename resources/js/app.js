
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

(function($){
    $.fn.sms = function(options) {
        var self = this;
        var btnOriginContent, timeId;
        var opts = $.extend(true, {}, $.fn.sms.defaults, options);
        self.on('click', function (e) {
            if (valid()) {
                btnOriginContent = self.html() || self.val() || '';
                changeBtn(opts.language.sending, true);
                send();
            }
        });

        function valid() {
            var requestData = getRequestData();
            if (!/^1[0-9]{10}$/.test(requestData.mobile)) {
                layer.msg('手机号格式错误', {icon: 2});
                return false;
            }
            return true;
        }

        function send() {
            var url = getUrl();
            var requestData = getRequestData();

            axios({
                method: 'post',
                url: url,
                data: requestData,
            }).then(function (res) {
                timer(opts.interval);
            }).catch(function (error) {
                changeBtn(btnOriginContent, false);
            });
        }

        function getUrl() {
            return opts.requestUrl ||
              '/sms/' + (opts.voice ? 'voice' : 'code')
        }

        function getRequestData() {
            var requestData = { _token: opts.token || '' };
            var data = $.isPlainObject(opts.requestData) ? opts.requestData : {};
            $.each(data, function (key) {
                if (typeof data[key] === 'function') {
                    requestData[key] = data[key].call(requestData);
                } else {
                    requestData[key] = data[key];
                }
            });

            return requestData;
        }

        function timer(seconds) {
            var btnText = opts.language.resendable;
            btnText = typeof btnText === 'string' ? btnText : '';
            if (seconds < 0) {
                clearTimeout(timeId);
                changeBtn(btnOriginContent, false);
            } else {
                timeId = setTimeout(function() {
                    clearTimeout(timeId);
                    changeBtn(btnText.replace('{{seconds}}', (seconds--) + ''), true);
                    timer(seconds);
                }, 1000);
            }
        }

        function changeBtn(content, disabled) {
            self.html(content);
            self.val(content);
            self.prop('disabled', !!disabled);
        }
    };

    $.fn.sms.defaults = {
        token       : null,
        interval    : 60,
        voice       : false,
        requestUrl  : null,
        requestData : null,
        language    : {
            sending    : '短信发送中...',
            failed     : '请求失败，请重试',
            resendable : '{{seconds}} 秒后再次发送'
        }
    };
})(window.jQuery);

