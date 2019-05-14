
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
                toastr.error('手机号格式错误');
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

    window.Modal = function() {
        var reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
        var alr = $("#xyModal");
        var ahtml = alr.html();

        var _tip = function(options, sec) {
            alr.html(ahtml); // 复原  
            alr.find('.ok').hide();
            alr.find('.cancel').hide();
            alr.find('.modal-content').width(500);
            _dialog(options, sec);
    
            return {
                on: function(callback) {}
            };
        };

        var _alert = function(options) {
            alr.html(ahtml); // 复原  
            alr.find('.ok').removeClass('btn-success').addClass('btn-primary');
            alr.find('.cancel').hide();
            _dialog(options);
    
            return {
                on: function(callback) {
                    if (callback && callback instanceof Function) {
                        alr.find('.ok').click(function() {
                            callback(true)
                        });
                    }
                }
            };
        };
    
        var _confirm = function(options) {
            alr.html(ahtml); // 复原  
            alr.find('.ok').removeClass('btn-primary').addClass('btn-success');
            alr.find('.cancel').show();
            _dialog(options);
    
            return {
                on: function(callback) {
                    if (callback && callback instanceof Function) {
                        alr.find('.ok').click(function() {
                            callback(true)
                        });
                        alr.find('.cancel').click(function() {
                            return;
                        });
                    }
                }
            };
        };
    
        var _dialog = function(options) {
            var ops = {
                msg: "提示内容",
                title: "操作提示",
                btnok: "确定",
                btncl: "取消"
            };
    
            $.extend(ops, options);

            var html = alr.html().replace(reg, function(node, key) {
                return {
                    Title: ops.title,
                    Message: ops.msg,
                    BtnOk: ops.btnok,
                    BtnCancel: ops.btncl
                } [key];
            });
    
            alr.html(html);
            alr.modal({
                width: 250,
                backdrop: 'static'
            });
        }
    
        return {
            tip: _tip,
            alert: _alert,
            confirm: _confirm
        }
    
    } ();
})(window.jQuery);

