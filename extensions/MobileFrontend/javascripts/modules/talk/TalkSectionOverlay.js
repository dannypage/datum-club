( function( M, $ ) {
var
	Overlay = M.require( 'Overlay' ),
	popup = M.require( 'toast' ),
	api = M.require( 'api' ),
	user = M.require( 'user' ),
	TalkSectionOverlay = Overlay.extend( {
		template: M.template.get( 'modules/talk/talkSection.hogan' ),
		templatePartials: {
			header: M.template.get( 'modules/talk/talkSectionHeader.hogan' ),
		},
		defaults: {
			reply: mw.msg( 'mobile-frontend-talk-reply' ),
			confirmMsg: mw.msg( 'mobile-frontend-editor-save' ),
			info: mw.msg( 'mobile-frontend-talk-reply-info' )
		},
		// FIXME: Use Router for TalkSectionOverlay
		hide: function() {
			if ( this.$board ) {
				this.$board.show();
			}
			this.remove();
		},
		initialize: function( options ) {
			// If terms of use is enabled, include it in the licensing message
			if ( $( '#footer-places-terms-use' ).length > 0 ) {
				options.licenseMsg = mw.msg(
					'mobile-frontend-editor-licensing-with-terms',
					$( '#footer-places-terms-use' ).html(),
					mw.config.get( 'wgMFLicenseLink' )
				);
			} else {
				options.licenseMsg = mw.msg(
					'mobile-frontend-editor-licensing',
					mw.config.get( 'wgMFLicenseLink' )
				);
			}
			this.$board = options.parent.$board;
			Overlay.prototype.initialize.apply( this, arguments );
		},
		postRender: function( options ) {
			var self = this, $comment = this.$( '.comment' ),
				$textarea = $comment.find( 'textarea' );
			Overlay.prototype.postRender.apply( this, arguments );
			this.$( '.back' ).on( M.tapEvent( 'click' ), $.proxy( self, 'hide' ) );
			this.$( '.loading' ).remove();
			if ( user.isAnon() || !M.isAlphaGroupMember() ) {
				$comment.remove();
			} else {
				$textarea.on( 'focus', function() {
					$textarea.removeClass( 'error' );
				} );
				$comment.find( 'button' ).on( 'click', function() {
					var val = $textarea.val();
					if ( val ) {
						$comment.hide();
						self.$( '.loading' ).show();
						// sign and add newline to front
						val = '\n\n' + val + ' ~~~~';
						api.getTokenWithEndpoint().done( function( token ) {
							api.post( {
								action: 'edit',
								title: options.title,
								section: options.section.id,
								token: token,
								appendtext: val
							} ).done( function( data ) {
								self.$( '.loading' ).hide();
								$comment.show();
								if ( data.error ) {
									$textarea.addClass( 'error' );
								} else {
									self.hide();
									options.parent.hide();
									popup.show( mw.msg( 'mobile-frontend-talk-reply-success' ), 'toast' );
									// invalidate the cache
									M.pageApi.invalidatePage( options.title );
								}
							} );
						} );
					} else {
						$textarea.addClass( 'error' );
					}
				} );
			}
		}
	} );

	M.define( 'modules/talk/TalkSectionOverlay', TalkSectionOverlay );
}( mw.mobileFrontend, jQuery ) );
