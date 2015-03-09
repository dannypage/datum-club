( function( M, $ ) {

	var View = M.require( 'View' ),
		PageList,
		Watchstar = M.require( 'modules/watchstar/Watchstar' ),
		WatchstarApi = M.require( 'modules/watchstar/WatchstarApi' ),
		user = M.require( 'user' ),
		Page = M.require( 'Page' );

	PageList = View.extend( {
		defaults: {
			pages: [],
			enhance: false
		},
		initialize: function( options ) {
			// FIXME: Find more elegant standard way to allow enhancement of views already in DOM
			if ( options.enhance ) {
				this.template = false;
			}

			this.api = new WatchstarApi( options );
			View.prototype.initialize.apply( this, arguments );
		},
		template: M.template.get( 'articleList.hogan' ),
		postRender: function( options ) {
			View.prototype.postRender.apply( this, arguments );
			var pages = [], $li = this.$( 'li' ),
				api = this.api;

			// Check what we have in the page list
			$li.each( function() {
				pages.push( $( this ).data( 'id' ) );
			} );

			// Create watch stars for each entry in list
			if ( !user.isAnon() && pages.length > 0 ) {
				api.load( pages, options.isWatchList ).done( function() {
					$li.each( function() {
						var page = new Page( {
							// FIXME: Set sections so we don't hit the api (hacky)
							sections: [],
							title: $( this ).attr( 'title' ),
							id: $( this ).data( 'id' )
						} );

						new Watchstar( {
							isAnon: false,
							isWatched: api.isWatchedPage( page ),
							page: page,
							el: $( '<div>' ).appendTo( this )
						} );
					} );
				} );
			}
		}
	} );

	M.define( 'modules/PageList', PageList );

}( mw.mobileFrontend, jQuery ) );
