var event_type, isSP = false,
    isIE = false,
    ie_version = false,
    os = '',
    blowser = '',
    img_src_ary = [],
    loaded_img_len = 0;
var $loader = $('#loader'),
    $wrapper = $('#wrap'),
    $intro = $('#intro');
var transformProp, slideX = 0,
    _depth = 3000,
    _perspective = 700;
var isEND = false;

function initContent(_sp, _e, _ie, _os, _blowser) {
    trace('func', 'initContent');
    event_type = _e;
    isSP = _sp;
    isIE = _ie;
    os = _os;
    blowser = _blowser;
    if (isIE) {
        showAlert();
        return
    } else {
        initLoad()
    }
}

function showAlert() {
    $('#alert').css({
        display: 'block'
    });
    $('#loader').css({
        display: 'none'
    })
}

function initLoad() {
    trace('func', 'initLoad');
    var img_len = $('img').length;
    for (var i = 0; i < img_len; i++) {
        var _src = $('img:eq(' + i + ')').attr('src');
        img_src_ary.push(_src)
    }
    $(document).smartpreload({
        images: img_src_ary,
        oneachimageload: function(src) {
            loaded_img_len++;
            onLoadUpdate()
        },
        onloadall: function() {
            trace('load', 'complete');
            hideLoader()
        }
    })
}

function onLoadUpdate() {
    var _per = Math.floor(loaded_img_len / img_src_ary.length * 100);
    trace(loaded_img_len + '/' + img_src_ary.length, ' Loaded');
    $loader.find('span').text(_per);
    if (loaded_img_len == img_src_ary.length) {
        trace('load', 'all loaded')
    }
}

function hideLoader() {
    $loader.css({
        display: 'none'
    });
    onResize();
    showIntro()
}

function showIntro() {
    var _introh = 867;
    if ($('#intro').attr('class') == 'min') {
        trace('INTRO', 'min');
        _introh = 800
    }
    $intro.css({
        display: 'block'
    });
    $('.intro_frame').css({
        transform: 'scale(0.01)',
        opacity: 1
    }).transition({
        duration: 1500,
        scale: 1.0,
        opacity: 1,
        easing: 'easeInOutQuint'
    }, function() {
        $intro.find('h1').stop(true, false).css({
            display: 'block'
        }).animate({
            width: 164
        }, 700, 'easeOutQuart');
        $intro.find('.intro_scroll').stop(true, false).css({
            display: 'block',
            width: 0
        }).delay(200).animate({
            width: 160
        }, 700, 'easeOutQuart', function() {
            $intro.css({
                display: 'none'
            });
            setup();
            init();
        })
    })
}

function setup() {
    trace('func', 'setup');
    $wrapper.css({
        display: 'block'
    });
    $('#scroll-proxy').css({
        display: 'block'
    });
    transformProp = Modernizr.prefixed('transform');
    trace('transform', transformProp);
    $('body').addClass('scene1');
    buttonSettings();
    setResize();
    onResize()
}

function buttonSettings() {
    $('.btn_view_tw, .btn_close').on(event_type, function(e) {
        e.preventDefault();
        $('.tw_wijet').toggle();
        return false
    });
    $('.btn_tokyo').on(event_type, function(e) {
        e.preventDefault();
        return false
    })
}

function init() {
    trace('func', 'init');
    $('body').scrollTop(0);
    $(window).scrollTop(0);
    $(document).bind("contextmenu", function(e) {
        return false
    });
    var BCXI = new madogatari();
    BCXI.$content = $('#content');
    var $body = $('body');
    if (Modernizr.csstransforms) {}
    setEasieScroll()
}

function madogatari() {
    trace('func', 'madogatari');
    this.scrolled = 0;
    this.currentLevel = 0;
    this.levels = 8;
    this.distance3d = _depth;
    this.levelGuide = {
        '#scene0': 0,
        '#scene1': 1,
        '#scene2': 2,
        '#scene3': 3,
        '#scene4': 4,
        '#scene5': 5,
        '#scene6': 6,
        '#blank': 7
    };
    this.$window = $(window);
    this.$document = $(document);
    this.getScrollTransform = Modernizr.csstransforms3d ? this.getScroll3DTransform : this.getScroll2DTransform;
    if (Modernizr.csstransforms) {
        window.addEventListener('scroll', this, false)
    }
}
madogatari.prototype.handleEvent = function(event) {
    if (this[event.type]) {
        this[event.type](event)
    }
};
madogatari.prototype.getScroll2DTransform = function(scroll) {
    var scale = Math.pow(3, scroll * (this.levels - 1));
    return 'scale(' + scale + ')'
};
var scene_name = '';
madogatari.prototype.getScroll3DTransform = function(scroll) {
    var z = (scroll * (this.levels - 1) * this.distance3d),
        leveledZ = this.distance3d / 2 - Math.abs((z % this.distance3d) - this.distance3d / 2),
        style, x = 0;
    var _PI = 3.14159265,
        _dist = 0;
    var _s0_dist = 0,
        _s1_dist = 1000,
        _s2_dist = 1000,
        _s3_dist = 800,
        _s4_dist = 900,
        _s5_dist = 1000,
        _s6_dist = 0;
    if (z <= 700) {
        _dist = 0;
        slideX = 0;
        scene_name = 'scene0'
    } else if (z > _perspective && z <= (_perspective + _depth * 1)) {
        _dist = _s1_dist;
        slideX = _s0_dist - Math.sin((_dist / _depth) * (z - (_perspective + _depth * 0)) / _depth * _PI * 2) * _dist;
        scene_name = 'scene1';
        $('.title1, .title2, .title3, .title4, .title5, .sub_set, .footer').removeClass('block')
    } else if (z > (_perspective + _depth * 1) && z <= (_perspective + _depth * 2)) {
        _dist = _s1_dist + _s2_dist;
        slideX = -_s1_dist + Math.sin((_dist / _depth) * (z - (_perspective + _depth * 1)) / _depth * _PI) * _dist;
        scene_name = 'scene2';
        $('.title2, .title3, .title4, .title5, .sub_set, .footer').removeClass('block');
        $('.title1').addClass('block')
    } else if (z > (_perspective + _depth * 2) && z <= (_perspective + _depth * 3)) {
        _dist = _s2_dist + _s3_dist;
        slideX = _s2_dist - Math.sin((_dist / _depth) * (z - (_perspective + _depth * 2)) / _depth * _PI) * _dist;
        scene_name = 'scene3';
        $('.title3, .title4, .title5, .sub_set, .footer').removeClass('block');
        $('.title2').addClass('block')
    } else if (z > (_perspective + _depth * 3) && z <= (_perspective + _depth * 4)) {
        _dist = _s3_dist + _s4_dist;
        slideX = -_s3_dist + Math.sin((_dist / _depth) * (z - (_perspective + _depth * 3)) / _depth * _PI) * _dist;
        scene_name = 'scene4';
        $('.title4, .title5, .sub_set, .footer').removeClass('block');
        $('.title3').addClass('block')
    } else if (z > (_perspective + _depth * 4) && z <= (_perspective + _depth * 5)) {
        _dist = _s4_dist + _s5_dist;
        slideX = _s4_dist - Math.sin((_dist / _depth) * (z - (_perspective + _depth * 4)) / _depth * _PI) * _dist;
        scene_name = 'scene5';
        $('.title5, .sub_set, .footer').removeClass('block');
        $('.title4').addClass('block')
    } else if (z > (_perspective + _depth * 5) && z <= (_perspective + _depth * 6)) {
        _dist = _s5_dist + _s6_dist;
        slideX = -_s5_dist + Math.sin(((_dist - 200) / _depth) * (z - (_perspective + _depth * 5)) / _depth * _PI * 2) * _dist;
        scene_name = 'scene6';
        $('.title5').addClass('block')
    } else if (z > (_perspective + _depth * 6)) {
        slideX = 0;
        scene_name = 'scene6'
    }
    if (z >= 21000) {
        isEND = true;
        showEnding();
        $('.sub_set, .footer').addClass('block')
    } else {
        if (isEND) hideEnding()
    }
    $('#wrap').removeClass('scene0 scene1 scene2 scene3 scene4 scene5 scene6');
    $('#wrap').addClass(scene_name);
    trace('levelZ', slideX + ' / ' + z);
    return 'translate3d( ' + slideX + 'px , 0, ' + z + 'px )'
};
madogatari.prototype.scroll = function(event) {
    this.scrolled = this.$window.scrollTop() / (this.$document.height() - this.$window.height());
    this.transformScroll(this.scrolled);
    this.currentLevel = Math.round(this.scrolled * (this.levels - 1));
    if (this.currentLevel !== this.previousLevel && this.$nav) {
        this.$nav.find('.current').removeClass('current');
        if (this.currentLevel < 5) {
            this.$nav.children().eq(this.currentLevel).addClass('current')
        }
        this.previousLevel = this.currentLevel
    }
};

function checkScrollPosition(_value) {};
madogatari.prototype.transformScroll = function(scroll) {
    if (!this.$content) {
        return
    }
    var style = {};
    style[transformProp] = this.getScrollTransform(scroll);
    this.$content.css(style)
};
madogatari.prototype.click = function(event) {
    var hash = event.target.hash || event.target.parentNode.hash,
        targetLevel = this.levelGuide[hash],
        scroll = targetLevel / (this.levels - 1);
    var _cr = this;
    moveScroll();

    function moveScroll() {
        if (Modernizr.csstransitions) {
            trace('intro?: ' + is_intro);
            if (is_intro) _cr.$content.addClass('transitions-intro');
            else _cr.$content.addClass('transitions-on');
            _cr.$content[0].addEventListener('webkitTransitionEnd', _cr, false);
            _cr.$content[0].addEventListener('oTransitionEnd', _cr, false);
            _cr.$content[0].addEventListener('transitionend', _cr, false);
            is_intro = false
        }
        _cr.$window.scrollTop(scroll * (_cr.$document.height() - _cr.$window.height()));
        if (isIOS) {
            _cr.transformScroll(scroll)
        }
        event.preventDefault()
    }
};
madogatari.prototype.webkitTransitionEnd = function(event) {
    this.transitionEnded(event)
};
madogatari.prototype.transitionend = function(event) {
    this.transitionEnded(event)
};
madogatari.prototype.oTransitionEnd = function(event) {
    this.transitionEnded(event)
};
madogatari.prototype.transitionEnded = function(event) {
    this.$content.removeClass('transitions-on');
    this.$content.removeClass('transitions-intro');
    this.$content[0].removeEventListener('webkitTransitionEnd', this, false);
    this.$content[0].removeEventListener('transitionend', this, false);
    this.$content[0].removeEventListener('oTransitionEnd', this, false)
};

function setEasieScroll() {
    var scrolly = 0;
    var speed = 300;
    $('html').mousewheel(function(event, mov) {
        if (jQuery.browser.webkit) {
            if (mov > 0) scrolly = $('body').scrollTop() - speed;
            else if (mov < 0) scrolly = $('body').scrollTop() + speed
        } else {
            if (mov > 0) scrolly = $('html').scrollTop() - speed;
            else if (mov < 0) scrolly = $('html').scrollTop() + speed
        }
        $('html,body').stop(true, false).animate({
            scrollTop: scrolly
        }, 1000, 'easeOutCirc');
        return false
    })
}

function showEnding() {
    trace('scroll', 'end!!!');
    if (isEND) {
        trace('func', 'showEnding');
        $('#scene6 .item2, #scene6 .item3, #scene6 .item4, #scene6 .item5, #scene6 .item6').css({
            display: 'none'
        });
        $('#scene6 .item2').stop(true, false).delay(300).css({
            display: 'block',
            opacity: 0
        }).animate({
            opacity: 1
        }, 500, 'linear', showEndingChara)
    }
}

function showEndingChara() {
    $('#scene6 .item3').stop(true, false).css({
        display: 'block',
        opacity: 0
    }).animate({
        opacity: 1
    }, 500, 'easeInQuart', showEndingTitle1)
}

function showEndingTitle1() {
    $('#scene6 .item4').stop(true, false).css({
        display: 'block',
        width: 1
    }).animate({
        width: 944
    }, 1000, 'easeInQuart', showEndingTitle2)
}

function showEndingTitle2() {
    $('#scene6 .item5').stop(true, false).css({
        display: 'block',
        height: 1
    }).animate({
        height: 1365
    }, 1000, 'easeOutQuart', showEndingBg)
}

function showEndingBg() {
    $('#scene6 .item6').stop(true, false).css({
        display: 'block',
        opacity: 0
    }).animate({
        opacity: 1
    }, 500, 'easeOutQuart')
}

function hideEnding() {
    trace('scroll', 'hide!!!');
    $('#scene6 .item2, #scene6 .item3, #scene6 .item4, #scene6 .item5').stop(true, false).css({
        display: 'none'
    });
    $('#scene6 .item6').stop(true, false).animate({
        opacity: 0
    }, 300, 'linear');
    isEND = false
}

function setResize() {
    var timer = false;
    $(window).resize(function() {
        if (timer !== false) {
            clearTimeout(timer)
        }
        timer = setTimeout(function() {
            onResize()
        }, 10)
    })
}

function onResize() {
    var _winh = $(window).height();
    if (_winh < 700) {
        $('#wrap, #intro').removeClass('max');
        $('#wrap, #intro').addClass('min')
    } else {
        $('#wrap, #intro').removeClass('max');
        $('#wrap, #intro').removeClass('min');
        if (_winh > 900) {
            $('#wrap, #intro').addClass('max')
        }
    }
}