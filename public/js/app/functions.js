//提示消息框
function tip(options) {
    var conf = {
        html: "<div class=\"wj-tips\" id=\"__ID__\"><div class=\"box\"><div class=\"shade\"><\/div><p>__TEXT__<\/p><\/div><\/div>",
        text: '提示',
        url: '',
        reload: false,
        time: 3000,
        id: new Date().valueOf()
    };
    if (typeof options == "string") {
        conf.text = options;
    } else {
        conf = $.extend(conf, options);
    }

    $('body').append(conf.html.replace('__TEXT__', conf.text).replace('__ID__', conf.id));
    $('#' + conf.id).fadeIn(500);
    if (conf.url) {
        $.URL.url(conf.url);
        conf.reload = true;
    }
    setTimeout(function () {
        if (conf.reload) {
            $.URL.reload();
        } else {
            $('#' + conf.id).fadeOut(1000, null, function () {
                $(this).remove();
            });
        }
    }, conf.time);
}

//对浮点数格式化，防止出现0.99999998的现象(f为浮点数，size中保留小数位数)
function formatfloat(f, size) {
    var tf = f * Math.pow(10, size);
    tf = Math.round(tf + 0.000000001);
    tf = tf / Math.pow(10, size);
    return tf;
}

$.extend({
    loading: {
        imgsrc: "<div class=\"spinner\"><div class=\"rect1\"><\/div><div class=\"rect2\"><\/div><div class=\"rect3\"><\/div><div class=\"rect4\"><\/div><div class=\"rect5\"><\/div><\/div>",
        html: "<div id=\"jquery-loading\"><div class=\"shade\"><\/div><div class=\"loading-img\">__IMG_SRC__<\/div><p class=\"loading-text\"><\/p><\/div>",
        selector: '#jquery-loading',
        init: function () {
            this.hide();
            $('body').append(this.html.replace('__IMG_SRC__', this.imgsrc));
        },
        hide: function () {
            $(this.selector).length > 0 && $(this.selector).remove();
        },
        shade: function (timeout) {
            this.init();
            timeout = parseInt(timeout) || 0;
            if (timeout > 0) {
                setTimeout(function () {
                    $.loading.hide();
                }, timeout);
            }
        },
        text: function (loading_text, timeout) {
            this.shade(timeout);
            $(this.selector).children('.loading-img').show();
            $(this.selector).children('.loading-text').show().html(loading_text);
        }
    },
    tip: tip,
    formatfloat: formatfloat
});

$(function () {
    $(document).scroll(function () {
        var h = $(this).scrollTop(), selector = '#to-top', header = $('.column', '.header');
        if (h > 200) {
            header.slideUp('fast');
            if ($(selector).length == 0) {
                $('.container').append('<a id="to-top" class="to-top" href="javascript:;"></a>');
                $(selector).click(function () {
                    $("html,body").animate({scrollTop: 0}, 500);
                });
            }
            $(selector).show();
        } else {
            $(selector).hide();
            if (h == 0) {
                header.slideDown();
            }
        }
    });
    if (typeof $.fn.lazyload == 'function') {
        $("img.lazy").lazyload({
            effect: "show",
            threshold: 200
        });
    }
    //查看当前网速
    (function () {
        function getSpeed() {
            $('#fresh-net-speed').addClass('animate');
            var arr = [
                {
                    class_name: '',
                    text: '流畅(>__SPEED__K/秒)'
                },
                {
                    class_name: 'good',
                    text: '良好(>__SPEED__K/秒)'
                },
                {
                    class_name: 'common',
                    text: '普通(>__SPEED__K/秒)'
                },
                {
                    class_name: 'bad',
                    text: '拥挤(<__SPEED__K/秒)'
                },
                {
                    class_name: 'none',
                    text: '无网络'
                }
            ];
            var speedSum = 0;
            var index = 0;
            var total_count = 3;
            var loadImg = function () {
                var st = new Date(), img = new Image();
                img.src = 'https://ss3.bdstatic.com/iPoZeXSm1A5BphGlnYG/skin/54.jpg?' + Math.random();
                img.onload = function () {
                    var et = new Date();
                    speedSum += Math.round(200 * 1000 / (et - st));
                    index++;
                    total_count == index && calculate();
                };
                img.onerror = function () {
                    index++;
                    total_count == index && calculate();
                }
            };
            var calculate = function () {
                speedSum = parseInt(speedSum / total_count);
                var i = speedSum > 500 ? 0 : (speedSum > 200 ? 1 : (speedSum > 50 ? 2 : (speedSum > 0) ? 3 : 4));
                $('#net-speed').attr('class', arr[i]['class_name']).text(arr[i]['text'].replace('__SPEED__', speedSum));
                $('#fresh-net-speed').removeClass('animate');
            };
            for (var i = 0; i < total_count; i++) {
                loadImg();
            }
        }

        $('#fresh-net-speed').click(getSpeed);
        setTimeout(function () {
            getSpeed();
        }, 5000);
        setInterval(getSpeed, 600000);
    })();
    //动态显示时间
    (function () {
        function CurentTime() {
            if (typeof  current_serve_time == "undefined") {
                current_serve_time = undefined;
            }
            var now = new Date(current_serve_time);

            var year = now.getFullYear();       //年
            var month = now.getMonth() + 1;     //月
            var day = now.getDate();            //日

            var hh = now.getHours();            //时
            var mm = now.getMinutes();          //分
            var ss = now.getSeconds();//秒

            var clock = year + "-";

            month < 10 && (clock += "0");
            clock += month + "-";

            day < 10 && (clock += "0");
            clock += day + " <span id='clock-hour'>";

            hh < 10 && (clock += "0");
            clock += hh + "</span>:<span id='clock-min'>";

            mm < 10 && (clock += '0');
            clock += mm + "</span>:<span id='clock-second'>";

            ss < 10 && (clock += '0');
            clock += ss + "</span>";
            $('#now-clock').html(clock);
        }

        CurentTime();

        function timeRun() {
            var h, m, s, hh, mm, ss;
            h = $('#clock-hour');
            m = $('#clock-min');
            s = $('#clock-second');

            hh = parseInt(h.text());
            mm = parseInt(m.text());
            ss = parseInt(s.text());
            var parse = function () {
                hh < 10 && (hh = "0" + hh);
                mm < 10 && (mm = "0" + mm);
                ss < 10 && (ss = "0" + ss);
                h.text(hh);
                m.text(mm);
                s.text(ss);
            };

            if (ss < 59) {
                ss++;
                parse();
                return false;
            }
            ss = 0;
            if (mm < 59) {
                mm++;
                parse();
                return false;
            }
            mm = 0;
            if (hh < 23) {
                hh++;
                parse();
            } else {
                CurentTime();
            }
        }

        setInterval(timeRun, 1000);
    })();
});



