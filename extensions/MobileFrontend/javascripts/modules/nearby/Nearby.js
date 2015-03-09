( function( M, $ ) {
	var NearbyApi = M.require( 'modules/nearby/NearbyApi' ),
		PageList = M.require( 'modules/PageList' ),
		Nearby;

	/**
	 * @extends View
	 * @class Nearby
	 */
	Nearby = PageList.extend( {
		errorMessages: {
			empty: {
				heading: mw.msg( 'mobile-frontend-nearby-noresults' ),
				guidance: mw.msg( 'mobile-frontend-nearby-noresults-guidance' )
			},
			location: {
				heading: mw.msg( 'mobile-frontend-nearby-lookup-ui-error' ),
				guidance: mw.msg( 'mobile-frontend-nearby-lookup-ui-error-guidance' )
			},
			permission: {
				heading: mw.msg( 'mobile-frontend-nearby-permission' ),
				guidance: mw.msg( 'mobile-frontend-nearby-permission-guidance' )
			},
			server: {
				heading: mw.msg( 'mobile-frontend-nearby-error' ),
				guidance: mw.msg( 'mobile-frontend-nearby-error-guidance' )
			},
			incompatible: {
				heading: mw.msg( 'mobile-frontend-nearby-requirements' ),
				guidance: mw.msg( 'mobile-frontend-nearby-requirements-guidance' )
			}
		},
		getCurrentPosition: function() {
			var result = $.Deferred();
			if ( M.supportsGeoLocation() ) {
			navigator.geolocation.getCurrentPosition(
				function( geo ) {
					result.resolve( { latitude: geo.coords.latitude, longitude: geo.coords.longitude } );
				},
				function( err ) {
					// see https://developer.mozilla.org/en-US/docs/Web/API/PositionError
					if ( err.code === 1 ) {
						err = 'permission';
					} else {
						err = 'location';
					}
					result.reject( err );
				},
				{
					timeout: 10000,
					enableHighAccuracy: true
				} );
			} else {
				result.reject( 'incompatible' );
			}
			return result;
		},
		initialize: function( options ) {
			var self = this,
				_super = PageList.prototype.initialize;

			options.loadingMessage = mw.msg( 'mobile-frontend-nearby-loading' );

			this.range = options.range || mw.config.get( 'wgMFNearbyRange' ) || 1000;
			this.source = options.source || 'nearby';
			this.nearbyApi = new NearbyApi();

			if ( options.errorType ) {
				options.error = this.errorMessages[ options.errorType ];
			}

			// Re-run after api/geolocation request
			if ( options.useCurrentLocation ) {
				// Flush any existing list of pages
				options.pages = [];

				// Get some new pages
				this.getCurrentPosition().done( function( coordOptions ) {
					$.extend( options, coordOptions );
					self._find( options ).done( function( options ) {
						_super.call( self, options );
					} );
				} ).fail( function( errorType ) {
					options.errorType = errorType;
					_super.call( self, options );
				} );
			} else if ( options.latitude && options.longitude ) {
				// Flush any existing list of pages
				options.pages = [];

				// Get some new pages
				this._find( options ).done( function( options ) {
					_super.call( self, options );
				} );
			}

			// Run it once for loader etc
			this._isLoading = true;
			_super.apply( this, arguments );
		},
		_find: function( options ) {
			var result = $.Deferred(), self = this;
			if ( options.latitude && options.longitude ) {
				this.nearbyApi.getPages( { latitude: options.latitude, longitude: options.longitude },
					this.range, options.exclude ).done( function( pages ) {
						options.pages = pages;
						if ( pages && pages.length === 0 ) {
							options.error = self.errorMessages.empty;
						}
						self._isLoading = false;
						result.resolve( options );
				} ).fail( function() {
					self._isLoading = false;
					options.error = self.errorMessages.server;
					result.resolve( options );
				} );
			} else {
				if ( options.errorType ) {
					options.error = this.errorMessages[ options.errorType ];
				}
				result.resolve( options );
			}
			return result;
		},
		postRender: function() {
			if ( !this._isLoading ) {
				this.$( '.loading' ).hide();
			}
			PageList.prototype.postRender.apply( this, arguments );
			this._postRenderLinks();
		},
		_postRenderLinks: function() {
			this.$( 'a' ).on( 'click', function( ev ) {
				// name funnel for watchlists to catch subsequent uploads
				$.cookie( 'mwUploadsFunnel', 'nearby', { expires: new Date( new Date().getTime() + 60000) } );
				window.location.hash = '#' + $( ev.currentTarget ).attr( 'name' );
			} );
		}
	} );

	M.define( 'modules/nearby/Nearby', Nearby );

}( mw.mobileFrontend, jQuery ) );
