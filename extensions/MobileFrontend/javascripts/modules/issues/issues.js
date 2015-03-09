( function( M, $ ) {

var module = (function() {
	var
		inBeta = M.isBetaGroupMember(),
		CleanupOverlay = M.require( 'modules/issues/CleanupOverlay' );

	function extractMessage( $box ) {
		var selector = '.mbox-text, .ambox-text',
			$container = $( '<div>' );

		$box.find( selector ).each( function() {
			var contents,
				$this = $( this );
			// Clean up talk page boxes
			$this.find( 'table, .noprint' ).remove();
			contents = $this.html();

			if ( contents ) {
				$( '<p>' ).html( contents ).appendTo( $container );
			}
		} );
		return $container.html();
	}

	function createBanner( $container, labelText, headingText ) {
		$container = $container || M.getLeadSection();
		var selector = 'table.ambox, table.tmbox',
			$metadata = $container.find( selector ),
			issues = [],
			$link;

		// clean it up a little
		$metadata.find( '.NavFrame' ).remove();

		$metadata.each( function() {
			var issue, content,
				$this = $( this );

			if ( $this.find( selector ).length === 0 ) {
				// FIXME: [templates] might be inconsistent
				content = inBeta ? extractMessage( $this ) :
						$this.find( '.mbox-text, .ambox-text' ).html();
				issue = {
					// .ambox- is used e.g. on eswiki
					text: content
				};
				if ( content ) {
					issues.push( issue );
				}
			}
		} );

		$link = $( '<a class="mw-mf-cleanup icon icon-text">' ).attr( 'href', '#/issues' );
		M.overlayManager.add( /^\/issues$/, function() {
			return new CleanupOverlay( { issues: issues, headingText: headingText } );
		} );

		$link.text( labelText ).insertBefore( $metadata.eq( 0 ) );
		$metadata.remove();
	}

	function initPageIssues( $container ) {
		var ns = mw.config.get( 'wgNamespaceNumber' );
		if ( ns === 0 ) {
			createBanner( $container, mw.msg( 'mobile-frontend-meta-data-issues' ),
			 mw.msg( 'mobile-frontend-meta-data-issues-header' ) );
		// Create a banner for talk pages (namespace 1) in beta mode to make them more readable.
		} else if ( ns === 1 && inBeta ) {
			createBanner( $container, mw.msg( 'mobile-frontend-meta-data-issues-talk' ),
			 mw.msg( 'mobile-frontend-meta-data-issues-header-talk' ) );
		}
	}

	initPageIssues();
	M.on( 'page-loaded', function() {
		initPageIssues();
	} );
	M.on( 'edit-preview', function( overlay ) {
		initPageIssues( overlay.$el );
	} );

	return {
		createBanner: createBanner,
		_extractMessage: extractMessage
	};
}() );

M.define( 'cleanuptemplates', module );

}( mw.mobileFrontend, jQuery ));
