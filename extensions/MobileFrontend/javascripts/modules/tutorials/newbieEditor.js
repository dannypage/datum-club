/* This code currently handles two different editing tutorials/CTAs:

EditTutorial - When an editor registers via the edit page action, upon returning to the
page, show a blue guider prompting them to continue editing. You can replicate this by
appending article_action=signup-edit to the URL of an editable page whilst logged in.

LeftNavEditTutorial - When an editor registers via the left navigation menu, upon
returning to the page, show a blue tutorial in 50% of cases prompting them to try
editing. You can replicate this by appending campaign=leftNavSignup to the URL of an
editable page whilst logged in, although you must be in test group A to see the CTA.
*/

( function( M, $ ) {
	var PageActionOverlay = M.require( 'modules/tutorials/PageActionOverlay' ),
		user = M.require( 'user' ),
		escapeHash = M.escapeHash,
		inEditor = window.location.hash.indexOf( '#editor/' ) > - 1,
		hash = window.location.hash,
		// Whether or not the user should see the leftNav guider
		shouldShowLeftNavEditTutorial = !user.isAnon() &&
			M.query.campaign === 'leftNavSignup' &&
			mw.config.get( 'wgNamespaceNumber' ) === 0 &&
			!inEditor &&
			mw.config.get( 'wgIsPageEditable' ),
		// If the user came from an edit button signup, show guider.
		shouldShowEditTutorial = M.query.article_action === 'signup-edit' && !inEditor &&
			!user.isAnon() && mw.config.get( 'wgIsPageEditable' ),
		showTutorial = shouldShowEditTutorial || shouldShowLeftNavEditTutorial,
		editOverlay, target, $target, href;

	if ( hash && hash.indexOf( '/' ) === -1 ) {
		target = escapeHash( hash ) + ' ~ .edit-page';
	} else {
		target = '#ca-edit .edit-page';
	}

	// Note the element might have a new ID if the wikitext was changed so check it exists
	if ( $( target ).length > 0 && showTutorial ) {

		if ( shouldShowLeftNavEditTutorial ) {
			// Append the funnel name to the edit link's url
			$target = $( target );
			href = $target.attr( 'href' );
			$target.attr( 'href', href + '/leftNavSignup' );
		}

		editOverlay = new PageActionOverlay( {
			target: target,
			className: 'slide active editing',
			summary: mw.msg( 'mobile-frontend-editor-tutorial-summary', mw.config.get( 'wgTitle' ) ),
			confirmMsg: mw.msg( 'mobile-frontend-editor-tutorial-confirm' ),
			cancelMsg: mw.msg( 'mobile-frontend-editor-tutorial-cancel' )
		} );
		editOverlay.show();
		$( '#ca-edit' ).on( 'mousedown', $.proxy( editOverlay, 'hide' ) );
		// Initialize the 'Start editing' button
		editOverlay.$( '.actionable' ).on( M.tapEvent( 'click' ), function() {
			// Hide the tutorial
			editOverlay.hide();
			// Load the editing interface by changing the URL hash
			window.location.href = $( target ).attr( 'href' );
		} );
	}

}( mw.mobileFrontend, jQuery ) );