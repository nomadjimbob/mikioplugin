

jQuery().ready(function () {
    jQuery('.mikiop-button').on('click', function (event) {
        if (jQuery(this).hasClass('mikiop-disabled')) {
            event.preventDefault();
        }

        if (jQuery(this).attr('data-toggle') == 'collapse') {
            event.preventDefault();
            jQuery(jQuery(this).attr('data-target')).slideToggle();
        }
    });

    jQuery('.mikiop-accordian-title').on('click', function (event) {
        event.preventDefault();

        jQuery(this).siblings('.mikiop-accordian-body').slideToggle();
    });

    jQuery('.mikiop-alert-close').on('click', function (event) {
        event.preventDefault();
        jQuery(this).closest('.mikiop-alert').hide();
    });

    jQuery('.mikiop-carousel').each(function () {
        var items = jQuery(this).find('.mikiop-carousel-item');
        var indicators = '';
        var active = false;

        for (var i = 0; i < items.length; i++) {
            if (jQuery(items[i]).hasClass('mikiop-active')) {
                active = true;
                indicators += '<li class="mikiop mikiop-carousel-indicator mikiop-active"></li>';
            } else {
                indicators += '<li class="mikiop mikiop-carousel-indicator"></li>';
            }
        };

        jQuery(this).find('.mikiop-carousel-indicators').html(indicators);

        if (!active) {
            jQuery(this).find('.mikiop-carousel-item').first().addClass('mikiop-active');
            jQuery(this).find('.mikiop-carousel-indicator').first().addClass('mikiop-active');
        }

        if (jQuery(this).attr('data-auto-start') == 'true') {
            var carousel = jQuery(this);
            timeout = carousel.find('.mikiop-carousel-item.mikiop-active').attr('data-interval');

            if (timeout == 0) {
                timeout = 3;
            }

            var nextSlide = function () {
                var timeout = carouselNext(carousel);

                if (timeout == 0) {
                    timeout = 3;
                }

                window.setTimeout(nextSlide, (timeout * 1000) + 500);
            };

            window.setTimeout(nextSlide, (timeout * 1000) + 500);
        }
    });

    jQuery('.mikiop-carousel-control-prev').on('click', function (event) {
        event.preventDefault();

        var parent = jQuery(this).parent();
        carouselPrev(parent);
    });

    function carouselPrev(parent) {
        
        var slides = parent.find('.mikiop-carousel-item');

        for (var i = 0; i < slides.length; i++) {
            if (jQuery(slides[i]).hasClass('mikiop-active')) {
                var target = null;
                var next = 0;

                if (i == 0) {
                    next = slides.length - 1;
                } else {
                    next = i - 1;
                }
                target = jQuery(slides[next]);

                if (jQuery(parent).hasClass('mikiop-transition-fade')) {
                    target.css('z-index', 0).addClass('mikiop-active');
                    jQuery(slides[i]).fadeOut(function () {
                        jQuery(this).removeClass('mikiop-active').css('display', '');
                        target.css('z-index', '');
                    });
                } else if (jQuery(parent).hasClass('mikiop-transition-slide')) {
                    target.css('left', '-100%').addClass('mikiop-active');
                    target.animate({ left: '0' }, 500);
                    jQuery(slides[i]).animate({ left: '100%' }, 500, function () {
                        jQuery(this).removeClass('mikiop-active').css('left', '');
                        target.css('left', '');
                    })
                } else {
                    target.addClass('mikiop-active');
                    jQuery(slides[i]).removeClass('mikiop-active');
                }

                parent.find('.mikiop-carousel-indicator').removeClass('mikiop-active');
                parent.find('.mikiop-carousel-indicator:nth-child(' + (next + 1) + ')').addClass('mikiop-active');

                break;
            }
        }
    };

    jQuery('.mikiop-carousel-control-next').on('click', function (event) {
        event.preventDefault();
        var parent = elem.parent();

        carouselNext(parent);
    });

    function carouselNext(parent) {
        var slides = parent.find('.mikiop-carousel-item');
        var delay = 0;

        for (var i = 0; i < slides.length; i++) {
            

            if (jQuery(slides[i]).hasClass('mikiop-active')) {
                var target = null;
                var next = 0;
                

                if (i == slides.length - 1) {
                    next = 0;
                } else {
                    next = i + 1;
                }
                target = jQuery(slides[next]);

                delay = target.attr('data-interval');
                if (typeof delay == 'undefined') {
                    delay = 0;
                }

                if (jQuery(parent).hasClass('mikiop-transition-fade')) {
                    target.css('z-index', 0).addClass('mikiop-active');
                    jQuery(slides[i]).fadeOut(function () {
                        jQuery(this).removeClass('mikiop-active').css('display', '');
                        target.css('z-index', '');
                    });
                } else if (jQuery(parent).hasClass('mikiop-transition-slide')) {
                    target.css('left', '100%').addClass('mikiop-active');
                    target.animate({ left: '0' }, 500);
                    jQuery(slides[i]).animate({ left: '-100%' }, 500, function () {
                        jQuery(this).removeClass('mikiop-active').css('left', '');
                        target.css('left', '');
                    })
                } else {
                    target.addClass('mikiop-active');
                    jQuery(slides[i]).removeClass('mikiop-active');
                }

                parent.find('.mikiop-carousel-indicator').removeClass('mikiop-active');
                parent.find('.mikiop-carousel-indicator:nth-child(' + (next + 1) + ')').addClass('mikiop-active');

                break;
            }
        }

        return(delay);
    };

    jQuery('.mikiop-carousel-indicator').on('click', function (event) {
        event.preventDefault();
        
        var parent = jQuery(this).closest('.mikiop-carousel-indicators');
        if (parent) {
            var group = jQuery(this).closest('.mikiop-carousel');
            if (group) {
                var items = jQuery(group).find('.mikiop-carousel-indicator');

                var item = -1;
                var active = 0;
                for (var i = 0; i < items.length; i++) {
                    if (jQuery(items[i]).hasClass('mikiop-active')) {
                        active = i;
                    }

                    if (items[i] == jQuery(this)[0]) {
                        item = i;
                    }
                }

                if (item != active) {
                    if (jQuery(group).hasClass('mikiop-transition-fade')) {
                        var target = jQuery(group).find('.mikiop-carousel-item:nth-child(' + (item + 1) + ')');

                        target.css('z-index', 0).addClass('mikiop-active');
                        jQuery(group).find('.mikiop-carousel-item:nth-child(' + (active + 1) + ')').fadeOut(function () {
                            jQuery(this).removeClass('mikiop-active').css('display', '');
                            target.css('z-index', '');
                        });

                        jQuery(group).find('.mikiop-carousel-indicator:nth-child(' + (item + 1) + ')').addClass('mikiop-active');
                        jQuery(group).find('.mikiop-carousel-indicator:nth-child(' + (active + 1) + ')').removeClass('mikiop-active');
                    } else if (jQuery(group).hasClass('mikiop-transition-slide')) {
                        var target = jQuery(group).find('.mikiop-carousel-item:nth-child(' + (item + 1) + ')');

                        if (item < active) {
                            target.css('left', '-100%').addClass('mikiop-active');
                            target.animate({ left: '0' }, 500);
                            jQuery(group).find('.mikiop-carousel-item:nth-child(' + (active + 1) + ')').animate({ left: '100%' }, 500, function () {
                                jQuery(this).removeClass('mikiop-active').css('left', '');
                                target.css('left', '');
                            });
                        } else {
                            target.css('left', '100%').addClass('mikiop-active');
                            target.animate({ left: '0' }, 500);
                            jQuery(group).find('.mikiop-carousel-item:nth-child(' + (active + 1) + ')').animate({ left: '-100%' }, 500, function () {
                                jQuery(this).removeClass('mikiop-active').css('left', '');
                                target.css('left', '');
                            });
                        }

                        jQuery(group).find('.mikiop-carousel-indicator:nth-child(' + (item + 1) + ')').addClass('mikiop-active');
                        jQuery(group).find('.mikiop-carousel-indicator:nth-child(' + (active + 1) + ')').removeClass('mikiop-active');
                    } else {
                        jQuery(group).find('.mikiop-carousel-item:nth-child(' + (item + 1) + ')').addClass('mikiop-active');
                        jQuery(group).find('.mikiop-carousel-indicator:nth-child(' + (item + 1) + ')').addClass('mikiop-active');
                        jQuery(group).find('.mikiop-carousel-item:nth-child(' + (active + 1) + ')').removeClass('mikiop-active');
                        jQuery(group).find('.mikiop-carousel-indicator:nth-child(' + (active + 1) + ')').removeClass('mikiop-active');
                    }                        
                }
            }
        }
    });

    jQuery('.mikiop-tab-item a').on('click', function (event) {
        event.preventDefault();

        var parent = jQuery(this).closest('.mikiop-tab-item');
        if (parent) {
            var group = jQuery(parent).closest('.mikiop-tab-group');
            if (group) {
                var items = jQuery(group).find('.mikiop-tab-item');

                var item = -1;
                for (var i = 0; i < items.length; i++) {
                    if (items[i] == parent[0]) {
                        item = i;
                        break;
                    }
                }

                if (item != -1) {
                    var panes = jQuery(group).siblings('.mikiop-tab-content').find('.mikiop-tab-pane');

                    if (panes.length > item) {
                        if (!jQuery(panes[item]).hasClass('mikiop-show')) {
                            jQuery(panes).removeClass('mikiop-show');
                            jQuery(panes[item]).addClass('mikiop-show');

                            jQuery(items).find('a').removeClass('mikiop-active');
                            jQuery(items[item]).find('a').addClass('mikiop-active');
                        }
                    }
                }
            }
        }
    });

    jQuery('.mikiop-box').on('mouseenter', function () {
        jQuery(this).children('.mikiop-reveal').fadeOut();
    });

    jQuery('.mikiop-box').on('mouseleave', function () {
        jQuery(this).children('.mikiop-reveal').fadeIn();
    });

    jQuery('.mikiop-collapse').hide();

});


// jQuery(function(){
//     jQuery('[data-toggle="tooltip"]').tooltip();
// });
