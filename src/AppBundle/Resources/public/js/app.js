/**
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 */

'use strict';

/**
 * app module with immediately invoked function.
 */
var app = (function(object) {
    // Public functions

    object.cache = {};

    /**
     * Function to initialize the application.
     */
    object.init = function() {
        $.material.init();
        $('body').tooltip({'trigger': 'hover', 'selector': '[data-toggle="tooltip"]'});
        this.boot();
        window.addEventListener('popstate', function(e) {
            this.unboot();
            if (e.state === null) {
                window.location.reload();
            }
            $('main').html(e.state);
            app.boot();
        });
        $(window).ready(function() {
            app.setEventListeners();
        });
    };

    object.requestVoiceInput = function() {
        var voiceText         = document.querySelector('.modal-body span');
        voiceText.textContent = '';
        $('#voiceInput').modal();
        setTimeout(function() {
            writeText(voiceText, '<- Klick mich wenn du bereit bist.');
        }, 500);
    };

    object.boot = function() {
        $('.bootable.boot-start').each(function(index) {
            var that = this;
            setTimeout(function() {
                $(that).addClass('boot').addClass('booted');
            }, 200 * index);
        });

        $('.slideDown').delay(1000).slideDown(600);
    };

    object.unboot = function() {
        $('.booted').removeClass('boot');
        $('.open').removeClass('open');
    };

    object.init();

    return object;
})(module.clone());

app.setEventListeners = function(){
    var $body = $('body');

    $('window').on('unload', function() {
        app.unboot();
    });

    $body.on('change', '#chooseDevice', function() {
        var $selected = $(this).find('option:selected');
        if ($selected.attr('value') !== '') {
            $('#chooseDeviceButton').removeAttr('disabled')
        } else {
            $('#chooseDeviceButton').attr('disabled', 'disabled');
        }
    });

    $body.on('change', '#chooseLevel', function() {
        var $selected   = $(this).find('option:selected');
        var $chooseRoom = $('#chooseRoom');
        $('.btn-primary.form-submit').attr('disabled', 'disabled');
        $chooseRoom.children().each(function() {
            if ($(this).val() !== '') $(this).remove();
        });
        if ($selected.attr('value') !== '') {
            $chooseRoom.parent().parent().slideDown();
            $.getJSON(Routing.generate('app_get_rooms_route', {'level': $selected.attr('value')}), function(data) {
                data = JSON.parse(data);
                for (var i in data) {
                    var room = data[i];
                    $chooseRoom.append('<option value="' + room.id + '">' + room.name + '</option>');
                }
                $chooseRoom.removeAttr('disabled');
            });
        } else {
            $chooseRoom.attr('disabled', 'disabled');
            $chooseRoom.parent().parent().slideUp();
        }
    });

    $body.on('change', '#chooseRoom', function() {
        var $selected = $(this).find('option:selected');
        if ($selected.attr('value') !== '') {
            $('.btn-primary.form-submit').removeAttr('disabled');
        } else {
            $('.btn-primary.form-submit').attr('disabled', 'disabled');
        }
    });

    $body.on('click', '.btn-command', function() {
        var command  = $(this).data('command');
        var deviceId = $('.device-header').data('id');

        $.getJSON(Routing.generate('app_device_control_receiver_route', {'id': deviceId, 'command': command}), function(data) {
            // TODO: Maybe give feedback.
        });
    });

    $body.on('click', '.btn-float', function() {
        var route = $(this).data('route');
        if (!route) {
            return false;
        }
        var address = Routing.generate(route);
        $.ajax(
            {
                'url':      address,
                'method':   'get',
                'complete': function(data) {
                    data = JSON.parse(data.responseText);
                    $('.modal-empty').find('.modal-dialog').find('.modal-content').find('.modal-body').html(data.content).siblings('.modal-header').html(data.title).parent().parent().parent().modal();
                }
            }
        );
    });

    $body.on('submit', '.form-modal-ajax', function() {
        var action = $(this).attr('action');
        var method = $(this).attr('method');
        var data   = $(this).serialize();
        var form   = this;
        $.ajax(
            {
                'url':     action,
                'method':  method,
                'data':    data,
                'complete': function(data) {
                    if (data.readyState === 4) {
                        if (data.status === 201) {
                            $(form).closest('.modal').modal('hide');
                        } else if (data.status === 200) {
                            data = JSON.parse(data.responseText);
                            $('.modal-empty').find('.modal-dialog').find('.modal-content').find('.modal-body').html(data.content).siblings('.modal-header').html(data.title).parent().parent().parent().modal();
                        }
                    }
                }
            }
        );

        return false;
    });

    $body.on('click', '.btn-voice', function() {
        var voiceText = document.querySelector('.modal-body span');

        var recognition = new webkitSpeechRecognition();

        recognition.onstart = function() {
            writeText(voiceText, 'Ich höre . . .');
        };

        recognition.onend = function() {
            writeText(voiceText, 'Berechne . . .');
        };

        recognition.onresult = function(event) {
            recognition.onend = null;
            var command = event.results[0][0].transcript;
            $.ajax(
                {
                    'url': Routing.generate('app_do_command_route'),
                    'data': "command=" + command,
                    'complete': function(data) {
                        var answer = data.responseText;
                        writeText(voiceText, answer);
                        var speaker = new SpeechSynthesisUtterance(answer);
                        speaker.lang = "de-DE";
                        window.speechSynthesis.speak(speaker);
                    }
                }
            );
        };

        recognition.start();
    });
};

function writeText(node, text, cacheTicket, i) {
    i           = i || 0;
    var length  = text.length;
    if (typeof cacheTicket === 'undefined') {
        cacheTicket = guid();
        app.cache.writing = cacheTicket;
    }
    if (typeof app.cache.writing === 'undefined') {
        app.cache.writing = cacheTicket;
    }
    if (app.cache.writing !== cacheTicket) {
        return false;
    }
    setTimeout(function() {
        node.textContent = text.substring(0, i);
        if (i !== length) {
            ++i;
            writeText(node, text, cacheTicket, i);
        }
    }, 30 + (Math.random() * 50) + 1);
}

function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
        s4() + '-' + s4() + s4() + s4();
}
