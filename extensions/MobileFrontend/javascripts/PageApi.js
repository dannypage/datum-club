( function( M, $ ) {
	var Api = M.require( 'api' ).Api, PageApi;

	function assignToParent( listOfSections, child ) {
		var section;
		if ( listOfSections.length === 0 ) {
			listOfSections.push( child );
		} else {
			// take a look at the last child
			section = listOfSections[listOfSections.length - 1];
			// If the level is the same as another section in this list it is a sibling
			if ( parseInt( section.level, 10 ) === parseInt( child.level, 10 ) ) {
				listOfSections.push( child );
			} else {
				// Otherwise take a look at that sections children recursively
				assignToParent( section.children, child );
			}
		}
	}

	function transformSections( sections ) {
		var
			collapseLevel = Math.min.apply( this, $.map( sections, function( s ) { return s.level; } ) ) + '',
			lastSection,
			result = [], $tmpContainer = $( '<div>' );

		$.each( sections, function( i, section ) {
			if ( section.line !== undefined ) {
				section.line = section.line.replace( /<\/?a\b[^>]*>/g, '' );
			}
			section.children = [];
			if ( !section.level || section.level === collapseLevel ) {
				result.push( section );
				lastSection = section;
			} else {
				// FIXME: ugly, maintain structure returned by API and use templates instead
				$tmpContainer.html( section.text );
				$tmpContainer.prepend(
					$( '<h' + section.level + '>' ).attr( 'id', section.anchor ).html( section.line )
				);
				assignToParent( lastSection.children, section );
				lastSection.text += $tmpContainer.html();
			}
		} );

		return result;
	}

	/**
	 * @class PageApi
	 * @extends Api
	 */
	PageApi = Api.extend( {
		initialize: function() {
			Api.prototype.initialize.apply( this, arguments );
			this.cache = {};
		},

		/**
		 * Retrieve a page from the api
		 *
		 * @method
		 * @param {string} title the title of the page to be retrieved
		 * @param {string} endpoint an alternative api url to retreive the page from
		 * @param {boolean} leadOnly When set only the lead section content is returned
		 * @return {jQuery.Deferred} with parameter page data that can be passed to a Page view
		 */
		getPage: function( title, endpoint, leadOnly ) {
			var options = endpoint ? { url: endpoint, dataType: 'jsonp' } : {}, page, timestamp,
				protection = { edit:[ '*' ] };

			if ( !this.cache[title] ) {
				page = this.cache[title] = $.Deferred();
				this.get( {
					action: 'mobileview',
					page: title,
					variant: mw.config.get( 'wgPreferredVariant' ),
					redirect: 'yes',
					prop: 'id|sections|text|lastmodified|lastmodifiedby|languagecount|hasvariants|protection|displaytitle|revision',
					noheadings: 'yes',
					noimages: mw.config.get( 'wgImagesDisabled', false ) ? 1 : undefined,
					sectionprop: 'level|line|anchor',
					sections: leadOnly ? 0 : 'all'
				}, options ).done( function( resp ) {
					var sections, lastModified, resolveObj, mv;

					if ( resp.error || !resp.mobileview.sections ) {
						page.reject( resp );
					// FIXME: [LQT] remove when liquid threads is dead (see Bug 51586)
					} else if ( resp.mobileview.hasOwnProperty( 'liquidthreads' ) ) {
						page.reject( { error: { code: 'lqt' } } );
					} else {
						mv = resp.mobileview;
						sections = transformSections( mv.sections );
						// Assume the timestamp is in the form TS_ISO_8601 and we don't care about old browsers
						// change to seconds to be consistent with PHP
						timestamp = new Date( mv.lastmodified ).getTime() / 1000;
						lastModified = mv.lastmodifiedby;

						// FIXME: [API] the API sometimes returns an object and sometimes an array
						// There are various quirks with the format of protection level as returned by api.
						// Also it is usually incomplete - if something is missing this means that it has
						// no protection level. When an array this means there is no protection level set.
						// So to keep the data type consistent either use the predefined protection level, or
						// extend it with what is returned by API.
						protection = $.isArray( mv.protection ) ? protection : $.extend( protection, mv.protection );
						resolveObj = {
							title: title,
							id: mv.id,
							revId: mv.revId,
							protection: protection,
							lead: sections[0].text,
							sections: sections.slice( 1 ),
							isMainPage: mv.hasOwnProperty( 'mainpage' ) ? true : false,
							historyUrl: mw.util.getUrl( title, { action: 'history' } ),
							lastModifiedTimestamp: timestamp,
							languageCount: mv.languagecount,
							hasVariants: mv.hasOwnProperty( 'hasvariants' ),
							displayTitle: mv.displaytitle
						};
						// Add non-anonymous user information
						if ( lastModified ) {
							$.extend( resolveObj, {
								lastModifiedUserName: lastModified.name,
								lastModifiedUserGender: lastModified.gender
							} );
						}
						page.resolve( resolveObj );
					}
				} ).fail( $.proxy( page, 'reject' ) );
			}

			return this.cache[title];
		},

		/**
		 * Invalidate the internal cache for a given page
		 *
		 * @method
		 * @param {string} title the title of the page who's cache you want to invalidate
		 */
		invalidatePage: function( title ) {
			delete this.cache[title];
		},

		/**
		 * Gets language list for a page; helper function for getPageLanguages()
		 *
		 * @method
		 * @param  {Object} data Data from API
		 * @return {Array} List of language objects
		 */
		_getLanguagesFromApiResponse: function( data ) {
			// allAvailableLanguages is a mapping of all codes to language names
			var pages, langlinks, allAvailableLanguages = {};
			$.each( data.query.languages, function ( index, item ) {
				allAvailableLanguages[ item.code ] = item[ '*' ];
			} );

			// FIXME: API returns an object when a list makes much more sense
			pages = $.map( data.query.pages, function( v ) { return v; } );
			// FIXME: "|| []" wouldn't be needed if API was more consistent
			langlinks = pages[0] ? pages[0].langlinks || [] : [];

			$.each( langlinks, function ( index, item ) {
				item.langname = allAvailableLanguages[ item.lang ];
				item.title = item['*'] || false;
			} );

			return langlinks;
		},

		/**
		 * Gets language variant list for a page; helper function for getPageLanguages()
		 *
		 * @method
		 * @param  {string} title Name of the page to obtain variants for
		 * @param  {Object} data Data from API
		 * @return {Array} List of language variant objects
		 */
		_getLanguageVariantsFromApiResponse: function( title, data ) {
			var generalData = data.query.general,
				variantPath = generalData.variantarticlepath,
				variants = [];

			if ( !generalData.variants ) {
				return false;
			}

			// Create the data object for each variant and store it
			$.each( generalData.variants, function ( index, item ) {
				var variant = {
					langname: item.name,
					lang: item.code
				};
				if ( variantPath ) {
					variant.url = variantPath
						.replace( '$1', title )
						.replace( '$2', item.code );
				} else {
					variant.url = mw.util.getUrl( title, { 'variant' : item.code } );
				}
				variants.push( variant );
			} );

			return variants;
		},

		/**
		 * Retrieve available languages for a given title
		 *
		 * @method
		 * @param {string} title the title of the page languages should be retrieved for
		 * @return {jQuery.Deferred} which is called with an object containing langlinks and variant links
		 */
		getPageLanguages: function( title ) {
			var self = this, result = $.Deferred();

			self.get( {
					action: 'query',
					meta: 'siteinfo',
					siprop: 'general|languages',
					prop: 'langlinks',
					llurl: true,
					lllimit: 'max',
					titles: title
				} ).done( function( resp ) {
					result.resolve( {
						languages: self._getLanguagesFromApiResponse( resp ),
						variants: self._getLanguageVariantsFromApiResponse( title, resp )
					} );
				} ).fail( $.proxy( result, 'reject' ) );

			return result;
		},

		// FIXME: Where's a better place for these two functions to live?
		_getAPIResponseFromHTML: function( $el ) {
			var $headings = $el.find( 'h1,h2,h3,h4,h5,h6' ),
				sections = [];

			$headings.each( function() {
				var level = $( this )[0].tagName.substr( 1 ),
					$span = $( this ).find( 'span' );

				sections.push( { level: level, line: $span.html(), anchor: $span.attr( 'id' ) || '', text: '' } );
			} );
			return sections;
		},

		getSectionsFromHTML: function( $el ) {
			return transformSections( this._getAPIResponseFromHTML( $el ) );
		}
	} );

	M.define( 'PageApi', PageApi );
}( mw.mobileFrontend, jQuery ) );
