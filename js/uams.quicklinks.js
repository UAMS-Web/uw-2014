// This section builds and populates the quicklinks section (off-canvas right)

UAMS.QuickLinks = Backbone.View.extend({

    DELAY : 500,

    settings : {},

    // todo: the default list and these elements could be put into the php templates
    container: '#uams-container',

    template : '<nav id="quicklinks" role="navigation" aria-label="quick links" aria-hidden="true">' +
                        '<ul id="big-links">' +
                            '<% _.each( links, function( link ) { %> ' +
                                '<% if (link.classes.indexOf("big") !== -1 ) { %>' +
                                    '<li>' +
                                        '<span class="<%= link.classes.join(" ") %>"></span>' +
                                        '<a href="<%= link.url %>" tabindex="-1"><%= link.title %></a>' +
                                    '</li>' +
                                '<% } %>' +
                            '<% }) %>' +
                        '</ul>' +
                        '<h3>Helpful Links</h3>' +
                        '<ul id="little-links">' +
                            '<% _.each( links, function( link ) { %> '+
                                '<% if (( link.classes.indexOf("big") == -1) && ( link.classes.indexOf("social") == -1)) { %>' +
                                    '<li>' +
                                        '<span class="<%= link.classes.join(" ") %>"></span>' +
                                        '<a href="<%= link.url %>" tabindex="-1"><%= link.title %></a>' +
                                    '</li>' +
                                '<% } %>' +
                            '<% }) %>' +
                        '</ul>' +
                        '<h4>Social</h4>' +
                        '<ul id="social">' +
                            '<% _.each( links, function( link ) { %> '+
                                '<% if ( link.classes.indexOf("social") !== -1) { %>' +
                                    '<li>' +
                                        '<a href="<%= link.url %>" tabindex="-1"><span class="<%= link.classes.join(" ") %>"></span> <%= link.title %></a>' +
                                    '</li>' +
                                '<% } %>' +
                            '<% }) %>' +
                        '</ul>' +
                    '</nav>',

    events: {
       'click'           : 'animate',
       'touchstart'   : 'animate',
       'keyup'         : 'animate',
       'blur' : 'loop'
    },

    initialize: function ( options ) {
        _.bindAll( this, 'inner_keydown', 'render', 'renderDefault', 'animate', 'accessible', 'loop', 'transitionEnd' );

        this.options = _.extend( {}, this.settings , options )

        this.links = new UAMS.QuickLinks.Collection( this.options )

        this.links.on( 'sync', this.render )

        this.links.on( 'error', this.renderDefault )

        this.links.fetch()
    },

    renderDefault : function ()
    {
        this.defaultLinks =  this.links.defaults
        this.render()
    },

    render : function(  )
    {
        this.quicklinks = $( _.template( this.template )({ links : this.defaultLinks ? this.defaultLinks : this.links.toJSON() }) );
        this.$container = $(this.container);
        this.$container.prepend( this.quicklinks )
        this.$el.attr( 'aria-controls', 'quicklinks' ).attr( 'aria-owns', 'quicklinks' )
        UAMS.$body.on( 'keydown', '#quicklinks a:first', this.inner_keydown )
        UAMS.$body.on( 'keyup', '#quicklinks a', this.animate )
        this.quicklinks.on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', this.transitionEnd);
    },

    transitionEnd: function (event) {
        if (this.open && event.target == this.quicklinks[0]) {
            this.accessible();
        }
    },

    inner_keydown: function (e) {
        //may need event.prevent_default() here if screenreaders aren't acting right
        if ( e.keyCode == 9 && e.shiftKey) {
            this.$el.focus();
            return false;
        }
    },

    animate: function ( e ) {
        e.preventDefault();

        if ( e.keyCode && e.keyCode != 27 )
        {
            if ( e.keyCode && e.keyCode != 13 ||
                e.keyCode && e.keyCode != 32 )
            return false;
        }

        this.$container.toggleClass('open')
        this.quicklinks.toggleClass('open')

        this.open = this.quicklinks.hasClass( 'open' )

        if (!this.open) {
            this.accessible();
        }
    },

    // todo : cache the uams-container-inner and screen-reader
    accessible : function (argument)
    {
        this.$el.attr( 'aria-expanded', this.open )
        this.quicklinks.attr('aria-hidden',  ( ! this.open ).toString() )
        if ( this.open ) {
            this.$el.attr('aria-label', 'Close quick links');
            this.quicklinks.find('a').attr( 'tabindex', 0 ).first().focus()
           $('#uams-container-inner').attr('aria-hidden', true);
           $('.screen-reader-shortcut').attr('aria-hidden', true)
        } else {
            this.$el.attr('aria-label', 'Open quick links');
            this.quicklinks.find('a').attr( 'tabindex', -1 )
            this.$el.focus()
           $('#uams-container-inner').attr('aria-hidden', false);
           $('.screen-reader-shortcut').attr('aria-hidden', false);
        }
    },

    loop : function (event) {
        if( this.open ) {
            this.quicklinks.find('li a').first().focus();
        }
    }

});

UAMS.QuickLinks.Model = Backbone.Model.extend({});

UAMS.QuickLinks.Collection = Backbone.Collection.extend({

    model: UAMS.QuickLinks.Model,

    initialize: function ( options )
    {
        this.url = options.url;
    },

    defaults : [{
       "title": "GUS",
       "url": "http:\/\/gus.uams.edu\/",
       "classes": ["i-Student big"]
   }, {
       "title": "Library",
       "url": "http:\/\/library.uams.edu\/",
       "classes": ["ic-book big"]
   }, {
       "title": "UAMS Bookstore",
       "url": "http:\/\/library.uams.edu\/library-services\/bookstore\/",
       "classes": ["i-Globe big"]
   }, {
       "title": "Webmail",
       "url": "http:\/\/webmail.uams.edu\/",
       "classes": ["ic-mail"]
   }, {
       "title": "Employee Self Service",
       "url": "https:\/\/enterprise.uams.edu\/irj\/portal",
       "classes": ['i-Name-Plate-Female-1']
   }, {
       "title": "Computing \/ IT",
       "url": "http:\/\/www.uams.edu\/IT",
       "classes": ["ic-computer"]
   }, {
       "title": "Intranet",
       "url": "http:\/\/inside.uams.edu\/",
       "classes": ["i-Networking-2"]
   }, {
       "title": "UAMS Facebook",
       "url": "https:\/\/www.facebook.com\/UAMSHealth",
       "classes": ["facebook social"]
   }, {
       "title": "UAMS Twitter",
       "url": "https:\/\/twitter.com\/uamshealth",
       "classes": ["twitter social"]
   }]

});
