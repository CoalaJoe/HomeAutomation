/**
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 */

"use strict";

var app = {
    init: function() {
        $.material.init();
        $('body').tooltip({'trigger': 'hover', 'selector': '[data-toggle="tooltip"]'});
        app.boot();
        app.setEventListeners();
        app.applyFancyTransitions();
    },
    boot: function() {
        $('.bootable.boot-start').each(function(index) {
            var that = this;
            setTimeout(function() {
                $(that).addClass('boot').addClass('booted');
            }, 200 * index);
        });

        $('.slideDown').delay(1000).slideDown(600);
    },

    applyFancyTransitions: function() {
        $('body').on('click', '.link', function() {
            var address = this.href;
            if (address === window.location.href) {
                return false;
            }
            app.unboot();
            $('.navbar-collapse.collapse').slideUp(200);
            history.pushState(null, "Heimautomation", address);
            $.ajax(
                {
                    'url':      address,
                    'method':   'get',
                    'complete': function(data) {
                        $('main').html(data.responseText);
                        app.init(false);
                    }
                }
            );

            return false;
        })
    },

    unboot: function() {
        $('.booted').removeClass('boot');
        $('.open').removeClass('open');
    },

    setEventListeners: function() {
        app.removeEventListeners();

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
                console.log(data);
            });
        })
    },

    removeEventListeners: function() {
        var $body = $('body');
        $body.unbind('click');
        $body.unbind('change');
    }
};

app.init();
