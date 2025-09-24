

jQuery().ready(function () {
    var stripHtml = function(htmlString) {
        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = htmlString;
        return tempDiv.textContent || tempDiv.innerText || "";
    };

    var urlMatches = function(url, start = 'start') {
        const windowURL = new URL(window.location);
        const urlObject = new URL(url.startsWith('http') ? url : window.origin + url);
        let match = true;

        // remove trailing slashes
        let windowPath = windowURL.pathname.replace(/\/$/, '');;
        let urlPath = urlObject.pathname.replace(/\/$/, '');;

        // add in start page if missing
        if(windowURL.searchParams.has('id') || urlObject.searchParams.has('id')) {
            // using search params
            if(windowURL.searchParams.has('id') === false) {
                windowURL.searchParams.append('id', start);
            }

            if(urlObject.searchParams.has('id') === false) {
                urlObject.searchParams.append('id', start);
            }
        } else {
            // dont seem to be using search params
            if (windowPath.endsWith('/doku.php')) {
                windowPath = windowPath + '/' + start;
            }
            if (urlPath.endsWith('/doku.php')) {
                urlPath = urlPath + '/' + start;
            }
        }
        
        if(windowURL.origin !== urlObject.origin || windowPath !== urlPath) {
            return false;
        }

        urlObject.searchParams.forEach((val, key) => {
            if(!windowURL.searchParams.has(key) || windowURL.searchParams.get(key) !== val) {
                match = false;
            }
        });

        return match;
    };

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
    var quizReset = function(quizRef) {
        quizRef.find('.mikiop-quiz-button-prev').attr('disabled', true);
        quizRef.find('.mikiop-quiz-result').hide();
        quizRef.find('.mikiop-quiz-button-submit').show().attr('disabled', false);
        quizRef.find('.mikiop-quiz-button-reset').hide();

        var status = quizRef.attr('data-status');
        status = status.replace('$1', '1');
        status = status.replace('$2', quizRef.children('.mikiop-quiz-item').length);
        quizRef.find('.mikiop-quiz-status-text').html(status);

        if (quizRef.children('.mikiop-quiz-item').length == 1) {
            quizRef.find('.mikiop-quiz-button-next').attr('disabled', true);
        } else {
            quizRef.find('.mikiop-quiz-button-next').attr('disabled', false);
        }

        quizRef.children('.mikiop-quiz-item').find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
        
        var full = quizRef.attr('data-full');
        if(!full) {
            quizRef.children('.mikiop-quiz-item').not(':first-child').hide();
            quizRef.children('.mikiop-quiz-item:first-child').show();
        } else {
            quizRef.children('.mikiop-quiz-item').show();
        }
    };
    
    jQuery('.mikiop-quiz').each(function () {
        quizReset(jQuery(this));
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
        var totalScore = 0;
        var result = '<div class="mikiop-quiz-question">Result</div>';

        var usingScoring = false;
        var usingCorrect = false;
        var questionCount = 0;

        parent.find('.mikiop-quiz-button-prev').attr('disabled', true);
        parent.find('.mikiop-quiz-button-next').attr('disabled', true);
        parent.find('.mikiop-quiz-button-submit').attr('disabled', true);
        parent.find('.mikiop-quiz-status-text').html('');

        var resetButton = parent.find('.mikiop-quiz-button-reset');
        if(resetButton.length > 0) {
            parent.find('.mikiop-quiz-button-submit').hide();
            resetButton.show();
        }


        for (var i = 0; i < questions.length; i++) {
            var showNewLine = true;
            var question = stripHtml(jQuery(questions[i]).attr('data-question'));
            var regex = /^((\w+ ?)*[):])/;

            if (regex.test(question)) {
                question = question.match(regex)[1];
                showNewLine = false;
            }

            result += '<p class="mikiop-quiz-result-question"><strong>' + question + '</strong>' + (showNewLine ? '<br>' : ' ');
            
            var checked = jQuery(questions[i]).find("input:checked");
            var answer = jQuery(questions[i]).attr('data-answer');
            var value = checked.val();

            if(answer != undefined) {
                usingCorrect = true;
                questionCount++;
            }

            if (typeof value == 'undefined') {
                result += 'Not answered';
            } else {
                // check that input radio groups with the same name have at least 1 answer
                let radioPass = true;
                let radioGroups = {};
                const radios = jQuery(questions[i]).find('input[type="radio"]');

                radios.each(function () {
                    const groupName = jQuery(this).attr('name');

                    if (!radioGroups[groupName]) {
                        radioGroups[groupName] = [];
                    }

                    radioGroups[groupName].push(jQuery(this));
                });

                for (const key in radioGroups) {
                    if (radioGroups.hasOwnProperty(key)) {
                        const group = radioGroups[key];
                        const anySelected = group.some(function (radio) {
                            return radio.prop('checked');
                        });

                        if (!anySelected) {
                            result += 'An option was not answered';
                            radioPass = false;
                            break;
                        }
                    }
                }

                if(radioPass) {
                    var totalItemScore = 0;
                    var selectedItems = [];
                    var itemIsScored = false;

                    checked.each(function() {
                        var item = jQuery(this);

                        var score = item.attr('data-score');
                    
                        if(score != undefined && score.length > 0) {
                            usingScoring = true;
                            itemIsScored = true;
                            totalItemScore += parseInt(score, 10);
                        } else if(answer != undefined) {
                            usingCorrect = true;
                            selectedItems.push(item.val());
                        }
                    });

                    if(itemIsScored) {
                        var scorePlaceholder = parent.attr('data-result-score');
                        result += scorePlaceholder.replace('$1', totalItemScore);
                        totalScore += totalItemScore;
                    } else {
                        var correctText = parent.attr('data-correct');
                        var incorrectText = parent.attr('data-incorrect');
                        
                        result += selectedItems.join(", ") + ' - ';
        
                        if(answer == undefined) {
                            result += "No answer set for question";
                        } else if(answer.indexOf('|') !== -1) {
                            var answerArray = answer.split('|');
                            if(answerArray.length == selectedItems.length) {
                                var totalMatch = true;
                                answerArray.forEach(function(answerItem) {
                                    var matching = selectedItems.some(function(selectedItem) {
                                        return answerItem.localeCompare(selectedItem) === 0;
                                    });

                                    if(!matching) {
                                        totalMatch = false;
                                    }
                                });

                                if(totalMatch) {
                                    correct++;
                                    result += correctText;
                                } else {
                                    result += incorrectText;
                                }
                            } else {
                                result += incorrectText;
                            }
                        } else {
                            if (selectedItems.length > 0 && answer.localeCompare(selectedItems[0]) == 0) {
                                correct++;
                                result += correctText;
                            } else {
                                result += incorrectText;
                            }
                        }
                    }
                }
            }

            result += '</p>';

            jQuery(questions[i]).hide();
        }

        var status = [];
        
        if(usingScoring) {
            status.push(parent.attr('data-result-score-total').replace('$1', totalScore));
        }
        
        if(usingCorrect) {
            status.push(parent.attr('data-result-correct').replace('$1', correct).replace('$2', questionCount));
        }

        result += '<p class="mikiop-quiz-result-total">' + status.join('<br>') + '</p>';

        parent.find('.mikiop-quiz-result').html(result).show();
    });

    jQuery('.mikiop-quiz-button-reset').on('click', function (event) {
        quizReset(jQuery(this).closest('.mikiop-quiz'));
    });

    // `Pagination
    jQuery('.mikiop-pagination').each(function() {
        var pagination = jQuery(this);
        var startId = pagination.attr('data-start') || 'start';
        var pages = pagination.find('li:not(.mikiop-pagination-prev,.mikiop-pagination-next)');
        if (pages.length > 0) {
            var active = -1;
            var found = -1;

            for (i = 0; i < pages.length; i++) {
                if (jQuery(pages[i]).hasClass('mikiop-active')) {
                    if (active != -1) {
                        jQuery(pages[i]).removeClass('mikiop-active')
                    } else {
                        active = i;
                    }
                }

                var link = jQuery(pages[i]).find('a').attr('href');
                if(urlMatches(link, startId)) {
                    found = i;
                }
            }

            if (active == -1 && found != -1) {
                active = found;
                jQuery(pages[found]).addClass('mikiop-active');
            }

            if (active != -1) {
                if (active == 0) {
                    jQuery('.mikiop-pagination').find('.mikiop-pagination-prev').addClass('mikiop-disabled');
                } else {
                    jQuery('.mikiop-pagination').find('.mikiop-pagination-prev').find('a').attr('href', jQuery(pages[active - 1]).find('a').attr('href'));
                }

                if (active == pages.length - 1) {
                    jQuery('.mikiop-pagination').find('.mikiop-pagination-next').addClass('mikiop-disabled');
                } else {
                    jQuery('.mikiop-pagination').find('.mikiop-pagination-next').find('a').attr('href', jQuery(pages[active + 1]).find('a').attr('href'));
                }
            } else {
                jQuery('.mikiop-pagination').find('.mikiop-pagination-prev').addClass('mikiop-disabled');
                jQuery('.mikiop-pagination').find('.mikiop-pagination-next').addClass('mikiop-disabled');
            }
        } else {
            jQuery('.mikiop-pagination').find('.mikiop-pagination-prev').addClass('mikiop-disabled');
            jQuery('.mikiop-pagination').find('.mikiop-pagination-next').addClass('mikiop-disabled');
        }
    });

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

    // Nav
    jQuery('.mikiop-nav').on('click', function (event) {
        jQuery('.mikiop-nav').not(this).removeClass('mikiop-nav-open');
        jQuery(this).toggleClass('mikiop-nav-open');
    });
    jQuery(document).on('click', function (event) {
        if (!jQuery(event.target).closest('.mikiop-nav').length) {
            // Hide the dropdown if clicked outside
            jQuery('.mikiop-nav').removeClass('mikiop-nav-open');
        }
    });

    jQuery('.mikiop-collapse').hide();
});
