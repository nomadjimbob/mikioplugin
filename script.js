

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
        let accordianBody = jQuery(this).siblings('.mikiop-accordian-body');
        if (!accordianBody.is(':visible')) {
            let accordian = jQuery(this).closest('.mikiop-accordian');
            if (accordian.hasClass('mikiop-autoclose')) {
                accordian.find('.mikiop-accordian-body:visible').slideUp();
            }
        }

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
        var parent = jQuery(this).parent();

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

        return (delay);
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

    // Quiz
    jQuery('.mikiop-quiz').each(function () {
        jQuery(this).find('.mikiop-quiz-button-prev').attr('disabled', true);
        jQuery(this).find('.mikiop-quiz-result').hide();

        var status = jQuery(this).attr('data-status');
        status = status.replace('$1', '1');
        status = status.replace('$2', jQuery(this).children('.mikiop-quiz-item').length);
        jQuery(this).find('.mikiop-quiz-status-text').html(status);

        if (jQuery(this).children('.mikiop-quiz-item').length == 1) {
            jQuery(this).find('.mikiop-quiz-button-next').attr('disabled', true);
        }

        jQuery(this).children('.mikiop-quiz-item').not(':first-child').hide();

    });

    jQuery('.mikiop-quiz-button-prev').on('click', function (event) {
        var parent = jQuery(this).closest('.mikiop-quiz');
        var questions = parent.children('.mikiop-quiz-item');
        parent.find('.mikiop-quiz-button-next').attr('disabled', false);

        for (var i = 0; i < questions.length; i++) {
            if (jQuery(questions[i]).is(':visible')) {
                i--;

                if (i <= 0) {
                    jQuery(this).attr('disabled', true);
                }

                jQuery(questions[i + 1]).hide();
                jQuery(questions[i]).show();
                parent.find('.mikiop-quiz-status-number').html(i + 1);

                var status = parent.attr('data-status');
                status = status.replace('$1', i + 1);
                status = status.replace('$2', parent.children('.mikiop-quiz-item').length);
                parent.find('.mikiop-quiz-status-text').html(status);

                break;
            }
        }
    });

    jQuery('.mikiop-quiz-button-next').on('click', function (event) {
        var parent = jQuery(this).closest('.mikiop-quiz');
        var questions = parent.children('.mikiop-quiz-item');
        parent.find('.mikiop-quiz-button-prev').attr('disabled', false);

        for (var i = 0; i < questions.length; i++) {
            if (jQuery(questions[i]).is(':visible')) {
                i++;

                if (i >= questions.length - 1) {
                    jQuery(this).attr('disabled', true);
                }

                jQuery(questions[i - 1]).hide();
                jQuery(questions[i]).show();

                var status = parent.attr('data-status');
                status = status.replace('$1', i + 1);
                status = status.replace('$2', parent.children('.mikiop-quiz-item').length);
                parent.find('.mikiop-quiz-status-text').html(status);

                break;
            }
        }
    });

    jQuery('.mikiop-quiz-button-submit').on('click', function (event) {
        var parent = jQuery(this).closest('.mikiop-quiz');
        var questions = parent.children('.mikiop-quiz-item');
        var correct = 0;
        var result = '<div class="mikiop-quiz-question">Result</div>';

        parent.find('.mikiop-quiz-button-prev').attr('disabled', true);
        parent.find('.mikiop-quiz-button-next').attr('disabled', true);
        parent.find('.mikiop-quiz-button-submit').attr('disabled', true);
        parent.find('.mikiop-quiz-status-text').html('');

        for (var i = 0; i < questions.length; i++) {
            var question = jQuery(questions[i]).attr('data-question');
            var answer = jQuery(questions[i]).attr('data-answer');

            result += '<p><strong>' + question + '</strong><br>';

            var value = jQuery(questions[i]).find("input:radio:checked").val();
            if (typeof value == 'undefined') {
                result += 'Not answered';
            } else {
                result += value + ' - ';

                if (answer.localeCompare(value) == 0) {
                    correct++;
                    result += 'Correct';
                } else {
                    result += 'Incorrect';
                }
            }

            result += '</p>';

            jQuery(questions[i]).hide();
        }

        var status = parent.attr('data-result');
        status = status.replace('$1', correct);
        status = status.replace('$2', questions.length);
        result += '<p>' + status + '</p>';

        parent.find('.mikiop-quiz-result').html(result).show();
    });

    // Pagenation
    var pages = jQuery('.mikiop-pagenation').find('li');
    if (pages.length > 0) {
        var active = -1;
        var found = -1;
        var location = window.location.pathname + window.location.search;

        if (window.location.search == '') {
            location += '?id=start';
        }

        for (i = 1; i < pages.length - 1; i++) {
            if (jQuery(pages[i]).hasClass('mikiop-active')) {
                if (active != -1) {
                    jQuery(pages[i]).removeClass('mikiop-active')
                } else {
                    active = i;
                }
            }

            var link = jQuery(pages[i]).find('a').attr('href');
            link = link.replace('id=:', 'id=');

            if (location.localeCompare(link) == 0) {
                found = i;
            }
        }

        if (active == -1 && found != -1) {
            active = found;
            jQuery(pages[found]).addClass('mikiop-active');
        }

        if (active != -1) {
            if (active == 1) {
                jQuery('.mikiop-pagenation').find('.mikiop-pagenation-prev').addClass('mikiop-disabled');
            } else {
                jQuery('.mikiop-pagenation').find('.mikiop-pagenation-prev').find('a').attr('href', jQuery(pages[active - 1]).find('a').attr('href'));
            }

            if (active == pages.length - 2) {
                jQuery('.mikiop-pagenation').find('.mikiop-pagenation-next').addClass('mikiop-disabled');
            } else {
                jQuery('.mikiop-pagenation').find('.mikiop-pagenation-next').find('a').attr('href', jQuery(pages[active + 1]).find('a').attr('href'));
            }
        } else {
            jQuery('.mikiop-pagenation').find('.mikiop-pagenation-prev').addClass('mikiop-disabled');
            jQuery('.mikiop-pagenation').find('.mikiop-pagenation-next').addClass('mikiop-disabled');
        }
    } else {
        jQuery('.mikiop-pagenation').find('.mikiop-pagenation-prev').addClass('mikiop-disabled');
        jQuery('.mikiop-pagenation').find('.mikiop-pagenation-next').addClass('mikiop-disabled');
    }

    // Reveal
    jQuery('.mikiop-box').on('mouseenter', function () {
        jQuery(this).children('.mikiop-reveal').fadeOut();
    });

    jQuery('.mikiop-box').on('mouseleave', function () {
        jQuery(this).children('.mikiop-reveal').fadeIn();
    });

    // Tooltip
    jQuery('.mikiop-tooltip').hover(function (event) {
        jQuery('<div class="mikiop-tooltip-banner">' + jQuery(this).attr('data-tooltip') + '</div>').appendTo('body');
    }, function () {
        jQuery('.mikiop-tooltip-banner').remove();
    });

    jQuery('.mikiop-tooltip').on('mousemove', function (event) {
        var moveLeft = 20;
        var moveDown = 10;
        jQuery('.mikiop-tooltip-banner').css('top', event.pageY + moveDown).css('left', event.pageX + moveLeft);
    });



    jQuery('.mikiop-collapse').hide();
});


// jQuery(function(){
//     jQuery('[data-toggle="tooltip"]').tooltip();
// });
