window.DustPressStarter = (function(window, document, $) {

    var app = {
        currentPage: 1
    };

    app.cache = function () {
        app.$mainContainer              = $("#main-content");
        app.$allallEventsListArea       = $(".all-events-list-area");
        app.$upcomingallEventsListArea  = $(".upcoming-events-list-area");
        app.$loadAllEvents              = app.$mainContainer.find("#load-all-events");
        app.$loadUpcomingEvents         = app.$mainContainer.find("#load-upcoming-events");
        app.$back                       = app.$mainContainer.find("#back");
    };

    app.init = function() {
        app.cache();

        app.$loadAllEvents.on("click", app.loadAllEvents);
        app.$loadUpcomingEvents.on("click", app.loadUpcomingEvents);
        app.$back.on("click", app.back);
    };

    app.loadAllEvents = function (e) {
        if ( e.preventDefault ) {
            e.preventDefault;
        }
        dp( 'PageEvents/All', {
            tidy: true,
            args: {},
            partial: "post-list"
        }).then( ( data ) => {
            app.$upcomingallEventsListArea.addClass('hide');
            app.$upcomingallEventsListArea.append(data);
            app.$allallEventsListArea.removeClass('hide');
        }).catch( ( error ) => {
            console.log(error);
        });

        app.$loadUpcomingEvents.prop('disabled', false);
        app.$loadAllEvents.prop('disabled', true);

        return false;
    };

    app.loadUpcomingEvents = function (e) {
        if ( e.preventDefault ) {
            e.preventDefault;
        }
        dp( 'PageEvents/Upcoming', {
            tidy: true,
            args: {},
            partial: "post-list"
        }).then( ( data ) => {
            app.$allallEventsListArea.addClass('hide');
            app.$upcomingallEventsListArea.append(data);
            app.$upcomingallEventsListArea.removeClass('hide');
        }).catch( ( error ) => {
            console.log(error);
        });

        app.$loadAllEvents.prop('disabled', false);
        app.$loadUpcomingEvents.prop('disabled', true);

        return false;
    };

    app.back = function (e) {
        window.history.back()
    };

    app.init();

    return app;

}(window, document, jQuery));