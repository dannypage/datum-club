<?php
/**
 * Definition of MobileFrontend's ResourceLoader modules.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules = array_merge( $wgResourceModules, array(
	'mobile.templates' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'ext.mantle.hogan',
		),
		'scripts' => array(
			'javascripts/template.js',
		),
		'targets' => array( 'mobile', 'desktop' ),
	),

	'mobile.pagelist.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/pagelist.less',
		),
		'position' => 'top',
	),

	'mobile.pagelist.scripts' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.watchstar',
		),
		'scripts' => array(
			'javascripts/modules/PageList.js',
		),
	),

	'skins.minerva.tablet.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/tablet/common.less',
			'less/tablet/hacks.less',
		),
		'position' => 'top',
	),

	'mobile.toc' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.startup',
			'mobile.templates',
			'mobile.loggingSchemas',
			'mobile.toggling',
		),
		'scripts' => array(
			'javascripts/modules/toc/toc.js',
		),
		'styles' => array(
			'less/modules/toc/toc.less',
		),
		'templates' => array(
			'modules/toc/toc.hogan',
			'modules/toc/tocHeading.hogan'
		),
		'messages' => array(
			'toc'
		),
	),

	'tablet.scripts' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.toc',
		),
	),

	'skins.minerva.chrome.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/reset.less',
			'less/ui.less',
			'less/pageactions.less',
			'less/footer.less',
			'less/common.less',
			'less/icons.less',
			'less/mainpage.less',
		),
		'position' => 'top',
	),

	'skins.minerva.content.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/content/main.less',
			'less/content/hacks.less',
		),
		'position' => 'top',
	),

	'skins.minerva.drawers.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/drawer.less',
		),
		'position' => 'top',
	),

	// Important: This module is loaded on both mobile and desktop skin
	'mobile.head' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mediawiki.language',
			'mediawiki.jqueryMsg',
			'mobile.templates',
			'ext.mantle.modules',
			'ext.mantle.oo',
		),
		'scripts' => array(
			'javascripts/modes.js',
			'javascripts/mainmenu.js',
			'javascripts/modules/lastEdited/time.js',
			'javascripts/modules/lastEdited/lastEdited.js',
		),
		'messages' => array(
			// lastEdited.js
			'mobile-frontend-last-modified-with-user-seconds',
			'mobile-frontend-last-modified-with-user-minutes',
			'mobile-frontend-last-modified-with-user-hours',
			'mobile-frontend-last-modified-with-user-days',
			'mobile-frontend-last-modified-with-user-months',
			'mobile-frontend-last-modified-with-user-years',
			'mobile-frontend-last-modified-with-user-just-now',
		),
		'position' => 'top',
	),

	'mobile.startup' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.head',
			'mobile.templates',
			'mobile.user',
			'mediawiki.api',
			'jquery.cookie',
			'mobile.redlinks',
			'ext.mantle.views',
		),
		'templates' => array(
			'page.hogan',
			'section.hogan',
		),
		'messages' => array(
			'mobile-frontend-language-article-heading',
		),
		'scripts' => array(
			'javascripts/Router.js',
			'javascripts/OverlayManager.js',
			'javascripts/api.js',
			'javascripts/PageApi.js',
			'javascripts/Panel.js',
			'javascripts/Section.js',
			'javascripts/Page.js',
			'javascripts/application.js',
			'javascripts/settings.js',
		),
		'position' => 'bottom',
	),

	'mobile.redlinks' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.head',
			'mediawiki.user',
		),
		'scripts' => array(
			'javascripts/modules/redlinks/redlinks.js',
		),
	),

	'mobile.user' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mediawiki.user',
			// Ensure M.define exists
			'mobile.head',
		),
		'scripts' => array(
			'javascripts/user.js',
		),
	),

	'mobile.editor' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable.common',
			'mobile.overlays',
		),
		'scripts' => array(
			'javascripts/modules/editor/editor.js',
		),
	),

	'mobile.editor.api' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable',
		),
		'scripts' => array(
			'javascripts/modules/editor/EditorApi.js',
			'javascripts/modules/editor/AbuseFilterOverlay.js',
			'javascripts/modules/editor/AbuseFilterPanel.js',
		),
		'templates' => array(
			'modules/editor/AbuseFilterOverlay.hogan',
			'modules/editor/AbuseFilterPanel.hogan',
		),
		'messages' => array(
			// AbuseFilterOverlay
			'mobile-frontend-photo-ownership-confirm',
			// AbuseFilterPanel
			'mobile-frontend-editor-abusefilter-warning',
			'mobile-frontend-editor-abusefilter-disallow',
			'mobile-frontend-editor-abusefilter-read-more',
		),
	),

	'mobile.editor.common' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable',
			'mobile.templates',
			'mobile.editor.api',
			'jquery.cookie',
		),
		'scripts' => array(
			'javascripts/modules/editor/EditorOverlayBase.js',
		),
		'styles' => array(
			'less/modules/editor/editor.less',
		),
		'templates' => array(
			'modules/editor/EditorOverlayBase.hogan',
		),
		'messages' => array(
			// modules/editor/EditorOverlay.js
			'mobile-frontend-editor-continue',
			'mobile-frontend-editor-cancel',
			'mobile-frontend-editor-keep-editing',
			'mobile-frontend-editor-licensing',
			'mobile-frontend-editor-licensing-with-terms',
			'mobile-frontend-editor-placeholder',
			'mobile-frontend-editor-placeholder-new-page',
			'mobile-frontend-editor-summary',
			'mobile-frontend-editor-summary-request',
			'mobile-frontend-editor-summary-placeholder',
			'mobile-frontend-editor-cancel-confirm',
			'mobile-frontend-editor-new-page-confirm',
			'mobile-frontend-editor-wait',
			'mobile-frontend-editor-success',
			'mobile-frontend-editor-success-landmark-1' => array( 'parse' ),
			'mobile-frontend-editor-success-new-page',
			'mobile-frontend-editor-refresh',
			'mobile-frontend-editor-error',
			'mobile-frontend-editor-error-conflict',
			'mobile-frontend-editor-error-loading',
			'mobile-frontend-editor-error-preview',
			'mobile-frontend-account-create-captcha-placeholder',
			'mobile-frontend-editor-captcha-try-again',
			'mobile-frontend-editor-editing-page',
			'mobile-frontend-editor-previewing-page',
			'mobile-frontend-editor-switch-confirm',
			'mobile-frontend-editor-visual-editor',
			'mobile-frontend-editor-source-editor',
			'mobile-frontend-editor-switch-editor',
			'mobile-frontend-editor-anoneditwarning',
		),
	),

	'mobile.editor.ve' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'ext.visualEditor.mobileViewTarget',
			'mobile.stable',
			'mobile.editor.common',
			'mobile.stable.common',
		),
		'styles' => array(
			'less/modules/editor/VisualEditorOverlay.less',
		),
		'scripts' => array(
			'javascripts/modules/editor/VisualEditorOverlay.js',
		),
		'templates' => array(
			'modules/editor/VisualEditorOverlayHeader.hogan',
			'modules/editor/VisualEditorOverlay.hogan',
		),
		'messages' => array(
			'mobile-frontend-page-edit-summary',
			'mobile-frontend-editor-editing',
		),
	),

	'mobile.editor.overlay' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.editor.common',
			'mobile.loggingSchemas',
		),
		'scripts' => array(
			'javascripts/modules/editor/EditorOverlay.js',
		),
		'templates' => array(
			'modules/editor/EditorOverlayHeader.hogan',
			'modules/editor/EditorOverlay.hogan',
		),
		'messages' => array(
			'mobile-frontend-editor-viewing-source-page',
		),
	),

	'mobile.uploads' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable',
			'mobile.templates',
			'mobile.editor.api',
		),
		'scripts' => array(
			'javascripts/modules/uploads/PhotoApi.js',
			'javascripts/modules/uploads/LeadPhoto.js',
			'javascripts/modules/uploads/UploadTutorial.js',
			'javascripts/modules/uploads/PhotoUploadProgress.js',
			'javascripts/modules/uploads/PhotoUploadOverlay.js',
			'javascripts/externals/exif-js/binaryajax.js',
			'javascripts/externals/exif-js/exif.js',
		),
		'styles' => array(
			'less/modules/uploads/UploadTutorial.less',
			'less/modules/uploads/PhotoUploadOverlay.less',
		),
		'templates' => array(
			'uploads/LeadPhoto.hogan',
			'uploads/UploadTutorial.hogan',
			'uploads/PhotoUploadOverlay.hogan',
			'uploads/PhotoUploadProgress.hogan',
		),
		'messages' => array(
			'mobile-frontend-photo-upload-success-article',
			'mobile-frontend-photo-upload-error',

			// PhotoApi.js
			'mobile-frontend-photo-article-edit-comment',
			'mobile-frontend-photo-article-donate-comment',
			'mobile-frontend-photo-upload-error-filename',
			'mobile-frontend-photo-upload-comment',

			// UploadTutorial.js
			'mobile-frontend-first-upload-wizard-new-page-1-header',
			'mobile-frontend-first-upload-wizard-new-page-1',
			'mobile-frontend-first-upload-wizard-new-page-2-header',
			'mobile-frontend-first-upload-wizard-new-page-2',
			'mobile-frontend-first-upload-wizard-new-page-3-header',
			'mobile-frontend-first-upload-wizard-new-page-3',
			'mobile-frontend-first-upload-wizard-new-page-3-ok',

			// PhotoUploadOverlay.js
			'mobile-frontend-image-heading-describe' => array( 'parse' ),
			'mobile-frontend-photo-ownership',
			'mobile-frontend-photo-ownership-help',
			'mobile-frontend-photo-caption-placeholder',
			'mobile-frontend-photo-submit',
			'mobile-frontend-photo-upload-error-file-type',
			'mobile-frontend-photo-licensing',
			'mobile-frontend-photo-licensing-with-terms',
			'mobile-frontend-photo-upload-copyvio',

			// PhotoUploadProgress.js
			'mobile-frontend-image-uploading' => array( 'parse' ),
			'mobile-frontend-image-cancel-confirm' => array( 'parse' ),
		),
	),

	'mobile.beta.common' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable.common',
			'mobile.loggingSchemas',
			'mobile.templates',
		),
	),

	'mobile.talk' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable',
			'mobile.beta.common',
			'mobile.overlays',
		),
		'styles' => array(
			'less/modules/talk.less',
		),
		'scripts' => array(
			'javascripts/modules/talk/talk.js',
		),
		'messages' => array(
			// for talk.js
			'mobile-frontend-talk-overlay-header',
		),
	),

	'mobile.beta' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable',
			'mobile.beta.common',
			'mobile.overlays',
			'mobile.wikigrok',
		),
		'scripts' => array(
			'javascripts/externals/micro.tap.js',
			'javascripts/modules/languages/preferred.js',
		),
		'position' => 'bottom',
	),

	'mobile.search' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.pagelist.scripts',
			'mobile.overlays'
		),
		'styles' => array(
			'less/modules/search/SearchOverlay.less',
		),
		'scripts' => array(
			'javascripts/modules/search/SearchApi.js',
			'javascripts/modules/search/SearchOverlay.js',
			'javascripts/modules/search/search.js',
			'javascripts/modules/search/pageImages.js',
		),
		'templates' => array(
			'modules/search/SearchOverlay.hogan',
		),
		'messages' => array(
			// for search.js
			'mobile-frontend-clear-search',
			'mobile-frontend-search-content',
			'mobile-frontend-search-no-results',
			'mobile-frontend-search-content-no-results' => array( 'parse' ),
		),
	),

	'mobile.talk.common' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.talk',
			'mobile.templates',
		),
		'scripts' => array(
			'javascripts/modules/talk/TalkSectionOverlay.js',
			'javascripts/modules/talk/TalkSectionAddOverlay.js',
			'javascripts/modules/talk/TalkOverlay.js',
		),
		'templates' => array(
			// talk.js
			'modules/talk/talk.hogan',
			'modules/talk/talkSectionAdd.hogan',
			'modules/talk/talkSectionAddHeader.hogan',
			'modules/talk/talkSection.hogan',
			'modules/talk/talkSectionHeader.hogan',
		),
		'messages' => array(
			'mobile-frontend-talk-fullpage',
			'mobile-frontend-talk-explained',
			'mobile-frontend-talk-explained-empty',
			'mobile-frontend-talk-overlay-lead-header',
			'mobile-frontend-talk-add-overlay-subject-placeholder',
			'mobile-frontend-talk-add-overlay-content-placeholder',
			'mobile-frontend-talk-edit-summary',
			'mobile-frontend-talk-add-overlay-submit',
			'mobile-frontend-talk-reply-success',
			'mobile-frontend-talk-reply',
			'mobile-frontend-talk-reply-info',
			'mobile-frontend-talk-topic-feedback',
			'mobile-frontend-talk-topic-error',
			'mobile-frontend-talk-topic-error-protected',
			'mobile-frontend-talk-topic-error-permission',
			'mobile-frontend-talk-topic-error-spam',
			'mobile-frontend-talk-topic-error-badtoken',
			// @todo FIXME: Gets loaded twice if editor and talk both loaded.
			'mobile-frontend-editor-cancel',
			'mobile-frontend-editor-cancel-confirm',
			'mobile-frontend-editor-licensing',
			'mobile-frontend-editor-licensing-with-terms',
		),
	),

	// FIXME: Remove this module and associated code unless it is going to be used by the
	// Firefox app.
	'mobile.ajaxpages' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			// Requires the Page.js JavaScript file
			'mobile.startup',
		),
		'scripts' => array(
			'javascripts/externals/epoch.js',
			'javascripts/history-alpha.js',
			'javascripts/modules/lazyload.js',
		),
	),

	'mobile.mediaViewer' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.overlays',
			// for Api.js
			'mobile.startup',
			'mobile.templates',
		),
		'styles' => array(
			'less/modules/mediaViewer.less',
		),
		'scripts' => array(
			'javascripts/modules/mediaViewer/ImageApi.js',
			'javascripts/modules/mediaViewer/ImageOverlay.js',
		),
		'templates' => array(
			'modules/ImageOverlay.hogan',
		),
		'messages' => array(
			// mediaViewer.js
			'mobile-frontend-media-details',
			'mobile-frontend-media-license-link',
		),
	),

	'mobile.alpha' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.beta',
		),
		'scripts' => array(
			'javascripts/modules/mf-translator.js',
		),
	),

	'mobile.wikigrok' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.startup',
			'mobile.user',
		),
		'scripts' => array(
			'javascripts/modules/wikigrok/wikigrok.js',
		),
	),

	'mobile.toast.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/toast.less',
		),
		'position' => 'top',
	),

	'mobile.stable.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/common-js.less',
			'less/modules/watchstar.less',
			'less/modules/tutorials.less',
		),
		'position' => 'top',
	),

	'mobile.overlays' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.templates',
			'mobile.startup',
		),
		'scripts' => array(
			'javascripts/Overlay.js',
			'javascripts/LoadingOverlay.js',
		),
		'messages' => array(
			'mobile-frontend-overlay-close',
			'mobile-frontend-overlay-continue',
		),
		'templates' => array(
			'backButton.hogan',
			'cancelButton.hogan',
			'Overlay.hogan',
			'LoadingOverlay.hogan',
		),
		'styles' => array(
			'less/Overlay.less',
		)
	),

	// Important: This module is loaded on both mobile and desktop skin
	'mobile.stable.common' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.startup',
			'mobile.toast.styles',
			'mediawiki.jqueryMsg',
			'mediawiki.util',
			'mobile.templates',
			'mobile.overlays',
			'jquery.cookie',
		),
		'templates' => array(
			'wikitext/commons-upload.hogan',
			// SearchOverlay.js and Nearby.js
			'articleList.hogan',
			// PhotoUploaderButton.js
			// For new page action menu
			'uploads/LeadPhotoUploaderButton.hogan',
			// @todo FIXME: this should be in special.uploads (need to split
			// code in PhotoUploaderButton.js into separate files too)
			'uploads/PhotoUploaderButton.hogan',

			'ctaDrawer.hogan',
		),
		'scripts' => array(
			'javascripts/modules/routes.js',
			'javascripts/Drawer.js',
			'javascripts/CtaDrawer.js',
			'javascripts/widgets/progress-bar.js',
			'javascripts/toast.js',
			'javascripts/modules/uploads/PhotoUploaderButton.js',
			'javascripts/modules/uploads/LeadPhotoUploaderButton.js',
			'javascripts/modules/mf-stop-mobile-redirect.js',
		),
		'messages' => array(
			// mf-navigation.js
			'mobile-frontend-watchlist-cta-button-signup',
			'mobile-frontend-watchlist-cta-button-login',
			'mobile-frontend-drawer-cancel',

			// newbie.js
			'cancel',

			// page.js
			'mobile-frontend-talk-overlay-header',
			// editor.js
			'mobile-frontend-editor-disabled',
			'mobile-frontend-editor-unavailable',
			'mobile-frontend-editor-uploadenable',
			'mobile-frontend-editor-blocked',
			'mobile-frontend-editor-cta',
			'mobile-frontend-editor-anon',
			'mobile-frontend-editor-edit',
			'mobile-frontend-editor-undo-unsupported',
			// modules/editor/EditorOverlay.js
			// modules/talk.js
			// modules/uploads/PhotoUploadProgress.js
			'mobile-frontend-editor-save',
			// PageApi.js
			'mobile-frontend-last-modified-with-user-date',
			// mf-stop-mobile-redirect.js
			'mobile-frontend-cookies-required',
			// LeadPhotoUploaderButton.js
			'mobile-frontend-photo-upload',
		),
	),

	'mobile.references' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.templates',
			'mobile.startup',
			'mobile.stable.common',
		),
		'styles' => array(
			'less/modules/references.less',
		),
		'templates' => array(
			// references.js
			'ReferencesDrawer.hogan',
		),
		'scripts' => array(
			'javascripts/modules/references/references.js',
		),
	),

	'mobile.toggling' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.startup',
		),
		'styles' => array(
			'less/modules/toggle.less',
		),
		'scripts' => array(
			'javascripts/modules/toggling/toggle.js',
		),
	),

	'mobile.contentOverlays' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.overlays',
		),
		'scripts' => array(
			'javascripts/modules/tutorials/ContentOverlay.js',
			'javascripts/modules/tutorials/PageActionOverlay.js',
		),
		'templates' => array(
			'modules/tutorials/PageActionOverlay.hogan',
		),
	),

	'mobile.newusers' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.templates',
			'mobile.editor',
			'mobile.contentOverlays',
			'mobile.loggingSchemas',
		),
		'scripts' => array(
			'javascripts/modules/tutorials/newbieEditor.js',
		),
		'messages' => array(
			// newbieEditor.js
			'mobile-frontend-editor-tutorial-summary',
			'mobile-frontend-editor-tutorial-confirm',
			'mobile-frontend-editor-tutorial-cancel',
		),
	),

	'mobile.watchstar' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.startup',
			// Needs Drawer
			'mobile.stable.common',
		),
		'scripts' => array(
			'javascripts/modules/watchstar/WatchstarApi.js',
			'javascripts/modules/watchstar/Watchstar.js',
			'javascripts/modules/watchstar/init.js',
		),
		'messages' => array(
			'watchthispage',
			'unwatchthispage',
			// mf-watchstar.js
			'mobile-frontend-watchlist-add',
			'mobile-frontend-watchlist-removed',
			'mobile-frontend-watchlist-cta',
		),
	),

	'mobile.stable' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.startup',
			'mobile.user',
			'mobile.stable.common',
			'mediawiki.util',
			'mobile.stable.styles',
			'mobile.templates',
			'mobile.references',
			'mediawiki.language',
			'mobile.loggingSchemas',
			'mobile.watchstar',
			'mobile.pagelist.scripts',
		),
		'scripts' => array(
			'javascripts/externals/micro.autosize.js',
			'javascripts/modules/uploads/init.js',
			'javascripts/modules/mainmenutweaks.js',
			'javascripts/modules/mediaViewer/init.js',
		),
		'messages' => array(
			// lastEdited.js
			'mobile-frontend-last-modified-seconds',
			'mobile-frontend-last-modified-hours',
			'mobile-frontend-last-modified-minutes',
			'mobile-frontend-last-modified-hours',
			'mobile-frontend-last-modified-days',
			'mobile-frontend-last-modified-months',
			'mobile-frontend-last-modified-years',
			'mobile-frontend-last-modified-just-now',

			// leadphoto.js
			'mobile-frontend-photo-upload-disabled',
			'mobile-frontend-photo-upload-protected',
			'mobile-frontend-photo-upload-anon',
			'mobile-frontend-photo-upload-unavailable',
		),
	),

	'mobile.languages' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.overlays',
		),
		'scripts' => array(
			'javascripts/modules/languages/LanguageOverlay.js',
			'javascripts/modules/languages/languages.js',
		),
		'templates' => array(
			'modules/languages/LanguageOverlay.hogan',
		),
		'messages' => array(
			'mobile-frontend-language-heading',
			'mobile-frontend-language-header',
			'mobile-frontend-language-variant-header' => array( 'parse' ),
			'mobile-frontend-language-site-choose',
		),
	),

	'mobile.issues' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.overlays',
		),
		'templates' => array(
			'overlays/cleanup.hogan',
		),
		'styles' => array(
			'less/modules/issues.less',
		),
		'scripts' => array(
			'javascripts/modules/issues/CleanupOverlay.js',
			'javascripts/modules/issues/issues.js',
		),
		'messages' => array(
			// issues.js
			'mobile-frontend-meta-data-issues',
			'mobile-frontend-meta-data-issues-talk',
			'mobile-frontend-meta-data-issues-header',
			'mobile-frontend-meta-data-issues-header-talk',
		),
	),

	'mobile.nearby' => $wgMFMobileResourceBoilerplate + array(
		'templates' => array(
			'overlays/pagePreview.hogan',
		),
		'dependencies' => array(
			'mobile.stable.common',
			// @todo FIXME: Kill this dependency!
			'mobile.special.nearby.styles',
			'mediawiki.language',
			'mobile.templates',
			'mobile.loggingSchemas',
			'mobile.pagelist.scripts',
		),
		'messages' => array(
			// NearbyApi.js
			'mobile-frontend-nearby-distance',
			'mobile-frontend-nearby-distance-meters',
			// Nearby.js
			'mobile-frontend-nearby-requirements',
			'mobile-frontend-nearby-requirements-guidance',
			'mobile-frontend-nearby-error',
			'mobile-frontend-nearby-error-guidance',
			'mobile-frontend-nearby-loading',
			'mobile-frontend-nearby-noresults',
			'mobile-frontend-nearby-noresults-guidance',
			'mobile-frontend-nearby-lookup-ui-error',
			'mobile-frontend-nearby-lookup-ui-error-guidance',
			'mobile-frontend-nearby-permission',
			'mobile-frontend-nearby-permission-guidance',
		),
		'scripts' => array(
			'javascripts/modules/nearby/NearbyApi.js',
			'javascripts/modules/nearby/Nearby.js',
		),
	),

	'mobile.notifications' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.overlays',
			'mediawiki.ui.anchor',
		),
		'scripts' => array(
			'javascripts/modules/notifications/notifications.js',
		),
	),

	'mobile.notifications.overlay' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable',
			'ext.echo.base',
		),
		'scripts' => array(
			'javascripts/modules/notifications/NotificationsOverlay.js',
		),
		'styles' => array(
			'less/modules/NotificationsOverlay.less',
		),
		'templates' => array(
			'modules/notifications/NotificationsOverlayContent.hogan',
			'modules/notifications/NotificationsOverlayFooter.hogan',
		),
		'messages' => array(
			// defined in Echo
			'echo-none',
			'notifications',
			'echo-overlay-link',
			'echo-notification-count',
		),
	),

	'mobile.wikigrok.dialog.b' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.wikigrok.dialog',
			'mediawiki.ui.checkbox',
		),
		'styles' => array(
			'less/modules/wikigrok/checkboxButton.less',
		),
		'templates' => array(
			'modules/wikigrok/WikiGrokDialogB.hogan',
		),
		'scripts' => array(
			'javascripts/modules/wikigrok/WikiGrokDialogB.js',
		),
	),

	// See https://www.mediawiki.org/wiki/Extension:MobileFrontend/WikiGrok
	'mobile.wikigrok.dialog' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.alpha',
		),
		'templates' => array(
			'modules/wikigrok/WikiGrokDialog.hogan',
			'modules/wikigrok/WikiGrokMoreInfo.hogan',
		),
		'scripts' => array(
			'javascripts/modules/wikigrok/WikiDataApi.js',
			'javascripts/modules/wikigrok/WikiGrokApi.js',
			'javascripts/modules/wikigrok/WikiGrokDialog.js',
			'javascripts/modules/wikigrok/WikiGrokMoreInfo.js',
			'javascripts/modules/wikigrok/wikigrokeval.js',
		),
		'styles' => array(
			'less/modules/wikigrok/WikiGrokDialog.less',
		),
	),

	'mobile.site' => array(
		'dependencies' => array( 'mobile.startup' ),
		'class' => 'MobileSiteModule',
	),
) );

/**
 * Special page modules
 * @todo FIXME: Remove the need for these by making more reusable CSS
 *
 * Note: Use correct names to ensure modules load on pages
 * Name must be the name of the special page lowercased prefixed by
 * 'mobile.special.' or 'skins.minerva.special.'
 * depending on where the module is used.
 * suffixed by '.styles' or '.scripts'
 */
$wgMobileSpecialPageModules = array(
	// For mobile web apps (e.g. Firefox OS). See SkinMinervaApp and SpecialMobileWebApp.
	'mobile.special.app.scripts' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.ajaxpages',
			'mobile.startup',
			'mobile.search',
			// Make sure loader styles etc are present
			'mobile.stable.styles',
		),
		'scripts' => array(
			'javascripts/app/startup.js',
		),
	),

	// For mobile web apps (e.g. Firefox OS). See SkinMinervaApp and SpecialMobileWebApp.
	'mobile.special.app.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/app/common.less',
		),
	),

	'mobile.special.mobilemenu.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/mobilemenu.less',
		),
		'skinStyles' => array(
			'vector' => 'less/desktop/special/mobilemenu.less',
		)
	),
	'mobile.special.mobileoptions.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/mobileoptions.less',
		),
	),
	'mobile.special.mobileoptions.scripts' => $wgMFMobileResourceBoilerplate + array(
		'position' => 'top',
		'dependencies' => array(
			'mobile.startup',
			'mobile.templates',
		),
		'scripts' => array(
			'javascripts/specials/mobileoptions.js',
		),
		'templates' => array(
			'specials/mobileoptions/checkbox.hogan',
		),
		'messages' => array(
			'mobile-frontend-expand-sections-description',
			'mobile-frontend-expand-sections-status',
		),
	),
	'mobile.special.mobileeditor.scripts' => $wgMFMobileSpecialPageResourceBoilerplate + array(
			'scripts' => array(
					'javascripts/specials/redirectmobileeditor.js',
			),
	),

	'mobile.special.nearby.styles' => $wgMFMobileResourceBoilerplate + array(
		'styles' => array(
			'less/specials/nearby.less',
		),
		'skinStyles' => array(
			'vector' => 'less/desktop/special/nearby.less',
			'monobook' => 'less/desktop/special/nearby.less',
		),
	),

	'mobile.special.nearby.scripts' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.nearby',
		),
		'messages' => array(
			'mobile-frontend-nearby-refresh',
		),
		'scripts' => array(
			'javascripts/specials/nearby.js',
		),
		// stop flash of unstyled content when loading from cache
		'position' => 'top',
	),

	'mobile.special.notifications.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/notifications.less',
		),
		'position' => 'top',
	),

	'mobile.special.notifications.scripts' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable'
		),
		'scripts' => array(
			'javascripts/specials/notifications.js',
		),
		'messages' => array(
			// defined in Echo
			'echo-load-more-error',
		),
	),

	'mobile.special.userprofile.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/userprofile.less',
		),
	),

	'mobile.special.uploads.scripts' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.stable'
		),
		'templates' => array(
			'specials/uploads/photo.hogan',
			'specials/uploads/userGallery.hogan',
		),
		'messages' => array(
			'mobile-frontend-donate-image-nouploads',
			'mobile-frontend-photo-upload-generic',
			'mobile-frontend-donate-photo-upload-success',
			'mobile-frontend-donate-photo-first-upload-success',
			'mobile-frontend-listed-image-no-description',
			'mobile-frontend-photo-upload-user-count',
		),
		'scripts' => array(
			'javascripts/specials/uploads.js',
		),
		'position' => 'top',
	),

	'mobile.special.uploads.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/uploads.less',
			'less/modules/uploads/PhotoUploaderButton.less',
		),
	),

	'mobile.special.pagefeed.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/pagefeed.less',
		),
	),

	'mobile.special.mobilediff.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/mobilediff.less',
		),
	),

	// Note that this module is declared as a dependency in the Thanks extension (for the
	// mobile diff thanks button code). Keep the module name there in sync with this one.
	'mobile.special.mobilediff.scripts' => $wgMFMobileResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.loggingSchemas',
			'mobile.stable.common',
		),
		'scripts' => array(
			'javascripts/specials/mobilediff.js',
		),
	),
);

/**
	* Special page modules  that are specific to minerva.
	* @todo FIXME: With the exception of skins.minerva.special.styles these should not exist.
	*/
$wgMinervaSpecialPageModules = array(
	'skins.minerva.special.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/common.less',
		),
	),

	'skins.minerva.special.preferences.scripts' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'scripts' => array(
			'javascripts/specials/preferences.js',
		),
	),

	'skins.minerva.special.search.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/search.less',
		),
	),

	'skins.minerva.special.watchlist.scripts' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'dependencies' => array(
			'mobile.loggingSchemas',
			'mobile.startup',
			'mobile.pagelist.scripts',
		),
		'scripts' => array(
			'javascripts/specials/watchlist.js',
		),
	),

	'skins.minerva.special.userlogin.styles' => $wgMFMobileSpecialPageResourceBoilerplate + array(
		'styles' => array(
			'less/specials/userlogin.less',
		),
	),
);

$wgResourceModules = array_merge( $wgResourceModules, $wgMobileSpecialPageModules );
$wgResourceModules = array_merge( $wgResourceModules, $wgMinervaSpecialPageModules );

// Module customizations
$wgResourceModuleSkinStyles['minerva'] = $wgMFResourceBoilerplate + array(
	'mediawiki.skinning.content.parsoid' => array(),
);
