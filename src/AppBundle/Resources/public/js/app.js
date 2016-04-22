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
            $.ajax(
                {
                    'url':      address,
                    'method':   'get',
                    'complete': function(data) {
                        $('main').html(data.responseText);
                        app.init(false);
                        history.pushState(null, "Heimautomation", address);
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

        $('window').on('unload', function() {
            app.unboot();
        });

        $('body').on('change', '#chooseDevice', function() {
            var $selected = $(this).find('option:selected');
            if ($selected.attr('value') !== '') {
                $('#chooseDeviceButton').removeAttr('disabled')
            } else {
                $('#chooseDeviceButton').attr('disabled', 'disabled');
            }
        });
    },

    removeEventListeners: function() {
        var $body = $('body');
        $body.unbind('click');
    }
};

app.init();
