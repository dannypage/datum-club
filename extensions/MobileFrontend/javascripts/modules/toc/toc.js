( function( M ) {
	var View = M.require( 'View' ), TableOfContents,
		MobileWebClickTracking = M.require( 'loggingSchemas/MobileWebClickTracking' ),
		toggle = M.require( 'toggle' );

	TableOfContents = View.extend( {
		templatePartials: {
			tocHeading: M.template.get( 'modules/toc/tocHeading.hogan' )
		},
		defaults: {
			contentsMsg: mw.msg( 'toc' )
		},
		tagName: 'div',
		className: 'toc-mobile',
		template: M.template.get( 'modules/toc/toc.hogan' ),
		postRender: function() {
			var log = MobileWebClickTracking.log;
			View.prototype.postRender.apply( this, arguments );
			// Click tracking for table of contents so we can see if people interact with it
			this.$( 'h2' ).on( toggle.eventName, function() {
				log( 'page-toc-toggle' );
			} );
			this.$( 'a' ).on( 'click', function() {
				log( 'page-toc-link' );
			} );
		}
	} );
	M.define( 'modules/toc/TableOfContents', TableOfContents );

	function init( page ) {
		var toc, sections = page.getSubSections(), enableToc = mw.config.get( 'wgTOC' );
		if ( enableToc ||
			// Fallback for old cached HTML, added 26 June, 2014
			( enableToc === null && sections.length > 0 && !page.isMainPage() ) )
		{
			toc = new TableOfContents( {
				sections: sections
			} );
			if ( mw.config.get( 'wgMFPageSections' ) ) {
				toc.appendTo( M.getLeadSection() );
			} else {
				// don't show toc at end of page, when no sections there
				toc.insertAfter( '#toc' );
				// remove the original parser toc
				this.$( '#toc' ).remove();
				// prevent to float text right of toc
				this.$( '.toc-mobile' ).after( '<div style="clear:both;"></div>' );
			}
			toggle.enable( toc.$el );
		}
	}

	init( M.getCurrentPage() );
	M.on( 'page-loaded', init );

}( mw.mobileFrontend ) );
