/**
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 */

'use strict';

/**
 * loader module with immediately invoked function.
 *
 * @param object   Loader-Object representation in the inner scope.
 * @param settings Settings provided.
 */
var loader = (function(object, settings) {
    // Public functions

    /**
     * Function to initialize the loader.
     */
    object.init = function(settings) {
        $(window).ready(function() {
            loader.applySettings(settings);
            loader.setEventListeners();
        });
    };

    object.status = {'isLoading': false, 'pendingRequests': []};

    object.init(settings);

    return object;
})(module.clone(), typeof loaderConf === 'undefined' ? {} : loaderConf); /** @global loaderConf */

loader.progressThemes = {'bootstrap': 'bootstrap'};

loader.applySettings = function(settings) {
    // Private functions
    var mapSetting = function(settings, key, defaultValue) {
        settings[key] = settings ? settings[key] ? settings[key] : defaultValue : defaultValue;
        return settings;
    };

    /**
     * Apply settings.
     *
     * @type {string}
     */
    this.settings = mapSetting(settings, 'linkSelector', '.link');
    this.settings = mapSetting(settings, 'progressBar', false);
    this.settings = mapSetting(settings, 'historyContainerSelector', 'main');

    if (this.settings.progressBar) {
        this.settings.progressBar = this.settings.progressBar === true ? {} : this.settings.progressBar;
        this.settings.progressBar = mapSetting(settings.progressBar, 'color', '#ff000');
        this.settings.progressBar = mapSetting(settings.progressBar, 'theme', this.progressThemes.bootstrap);
    }
};

/**
 * Sets popstate
 */
loader.setHistoryEvent = function() {
    window.addEventListener('popstate', function(e) {
        if (e.state === null) {window.location.reload();}

        $(loader.settings.historyContainerSelector).html(e.state);
    }, false);
};

/** Set AJAX events */
loader.setEventListeners = function() {
    loader.setHistoryEvent();
    $('body').on('click', this.settings.linkSelector, function() {
        var address = this.href;
        if (address === window.location.href) {return false;} // Don't load if the requested page is the page you are currently on.

        var uuid = 'id' + (new Date()).getTime();

        if (loader.settings.progressBar) {
            switch (loader.settings.progressBar.theme) {
                case loader.progressThemes.bootstrap:
                    if (loader.status.isLoading) { // Remove pending requests.
                        $('.progress').remove();
                        for (var i in loader.status.pendingRequests) {
                            if (!loader.status.pendingRequests.hasOwnProperty(i)) {
                                continue;
                            }
                            var request = loader.status.pendingRequests[i];
                            request.abort();
                        }
                    }
                    // Append progressbar
                    $('body').prepend('<div id="' + uuid + '" class="progress"><div class="progress-bar" style="background-color: ' + loader.settings.progressBar.color + '; width: 0"></div></div>');
                    setTimeout(function() {
                        $('#'+uuid).find('.progress-bar').css({'width': '0'});
                    }, 50);
                    break;
                default:
                    break;
            }
        }

        loader.status.pendingRequests[uuid] = loader.sendAjax(uuid, address);

        return false;
    });
};

loader.sendAjax = function(uuid, address) {
    return $.ajax(
        {
            'beforeSend': function() {
                // Set state to loading.
                app.unboot();
                loader.status.isLoading = true;
            },
            'url':        address,
            'dataType':   'json',
            'progress':   function(e) {
                if (loader.settings.progressBar === false) {
                    return;
                }

                if (e.lengthComputable) {
                    var pct = (e.loaded / e.total) * 100;
                    $('#' + uuid).find('.progress-bar').css({'width': pct + '%'});
                } else {
                    if (loader.DEBUG()) {console.warn('Content Length not reported or request canceled!');}
                }
            },
            'complete':   function(data) {
                delete loader.status.pendingRequests[uuid]; // Remove request from pending list.
                loader.status.isLoading = false;
                if (data.statusText === 'abort') { return false; } // Do not change DOM when canceled.

                if (loader.settings.progressBar) {
                    setTimeout(function() {
                        $('#' + uuid).fadeOut(function() {
                            $(this).remove();
                        })
                    }, 1000)
                }

                loader.applyUpdate(data.responseJSON, address);
                app.boot();

                return false;
            }
        });
};

/**
 * Updates website
 *
 * @param update
 * @param address
 */
loader.applyUpdate = function(update, address) {
    if (typeof update === 'object') {
        if (update.title !== '') {
            document.title = update.title;
        }
        $(loader.settings.historyContainerSelector).html(update.content);
        /** @global history */
        history.pushState(update.content, document.title, address);
    }
};

/** Removes events from body */
loader.removeEventListeners = function() {
    $('body').unbind('click');
};
