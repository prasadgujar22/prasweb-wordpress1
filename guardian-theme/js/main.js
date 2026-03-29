/**
 * Guardian News Theme — Main JS
 */
( function () {
    'use strict';

    // =========================================================
    // SET --sticky-top CSS VARIABLE
    // The sidebar-sticky CSS uses:  top: calc(var(--sticky-top) + 16px)
    // We measure the sticky header wrapper height and write it to :root
    // so the sidebar sticks right below the header.
    // =========================================================
    function updateStickyTop() {
        var wrapper = document.querySelector( '.site-header-wrapper' );
        var h       = wrapper ? wrapper.offsetHeight : 0;
        document.documentElement.style.setProperty( '--sticky-top', h + 'px' );
    }

    // =========================================================
    // HAMBURGER MENU TOGGLE
    // =========================================================
    function initHamburger() {
        var toggle  = document.querySelector( '.menu-toggle' );
        var navMenu = document.getElementById( 'primary-navigation' );
        if ( ! toggle || ! navMenu ) return;

        toggle.addEventListener( 'click', function () {
            var isOpen = navMenu.classList.toggle( 'nav-open' );
            toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
            toggle.setAttribute( 'aria-label', isOpen ? 'Close menu' : 'Open menu' );
        } );

        navMenu.querySelectorAll( 'a' ).forEach( function ( link ) {
            link.addEventListener( 'click', function () {
                navMenu.classList.remove( 'nav-open' );
                toggle.setAttribute( 'aria-expanded', 'false' );
                toggle.setAttribute( 'aria-label', 'Open menu' );
            } );
        } );
    }

    // =========================================================
    // SEARCH PANEL TOGGLE
    // =========================================================
    function initSearch() {
        var searchToggle = document.querySelector( '.search-toggle' );
        var searchPanel  = document.getElementById( 'site-search-panel' );
        var searchInput  = document.getElementById( 'site-search-input' );
        var searchClose  = document.querySelector( '.site-search-close' );
        if ( ! searchToggle || ! searchPanel ) return;

        function openSearch() {
            searchPanel.classList.add( 'search-open' );
            searchPanel.setAttribute( 'aria-hidden', 'false' );
            searchToggle.setAttribute( 'aria-expanded', 'true' );
            searchToggle.setAttribute( 'aria-label', 'Close search' );
            if ( searchInput ) {
                setTimeout( function () { searchInput.focus(); }, 50 );
            }
            updateStickyTop();
        }

        function closeSearch() {
            searchPanel.classList.remove( 'search-open' );
            searchPanel.setAttribute( 'aria-hidden', 'true' );
            searchToggle.setAttribute( 'aria-expanded', 'false' );
            searchToggle.setAttribute( 'aria-label', 'Open search' );
            updateStickyTop();
        }

        searchToggle.addEventListener( 'click', function () {
            if ( searchPanel.classList.contains( 'search-open' ) ) {
                closeSearch();
            } else {
                openSearch();
            }
        } );

        if ( searchClose ) {
            searchClose.addEventListener( 'click', closeSearch );
        }

        // Close on Escape key
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && searchPanel.classList.contains( 'search-open' ) ) {
                closeSearch();
                searchToggle.focus();
            }
        } );

        // Close when clicking outside the header wrapper
        document.addEventListener( 'click', function ( e ) {
            if ( searchPanel.classList.contains( 'search-open' ) &&
                 ! e.target.closest( '.site-header-wrapper' ) ) {
                closeSearch();
            }
        } );
    }

    // =========================================================
    // STRIP DARK-MODE PLUGIN BORDERS
    // The dark mode plugin injects border-left/right/bottom via inline
    // styles on sidebar widgets and article cards. CSS !important cannot
    // override JS inline styles, so we remove them here after load.
    // =========================================================
    var BORDER_SELECTORS = [
        '.article-card',
        '.sidebar',
        '.sidebar-sticky',
        '.sidebar-widget',
        '.widget',
        '.sidebar *'
    ].join( ',' );

    function stripPluginBorders() {
        document.querySelectorAll( BORDER_SELECTORS ).forEach( function ( el ) {
            el.style.removeProperty( 'border-left' );
            el.style.removeProperty( 'border-right' );
            el.style.removeProperty( 'border-bottom' );
            el.style.removeProperty( 'border' );
            // Re-apply only our top border for widgets
            if ( el.classList.contains( 'sidebar-widget' ) ) {
                el.style.setProperty( 'border-top', '3px solid #052962', 'important' );
            }
        } );
    }

    // Run once on load, then watch for the dark-mode plugin toggling
    function initBorderStrip() {
        stripPluginBorders();
        // MutationObserver catches when the plugin re-adds borders on toggle
        var observer = new MutationObserver( function ( mutations ) {
            var relevant = mutations.some( function ( m ) {
                return m.type === 'attributes' && m.attributeName === 'style' &&
                    ( m.target.matches( '.sidebar-widget' ) ||
                      m.target.matches( '.article-card' ) ||
                      m.target.matches( '.sidebar' ) );
            } );
            if ( relevant ) { stripPluginBorders(); }
        } );
        observer.observe( document.body, {
            attributes: true,
            attributeFilter: [ 'style' ],
            subtree: true
        } );
    }

    // =========================================================
    // INIT
    // =========================================================
    document.addEventListener( 'DOMContentLoaded', function () {
        updateStickyTop();
        initHamburger();
        initSearch();
        initBorderStrip();
    } );

    // Re-measure after all images/fonts load (header height may change)
    window.addEventListener( 'load', function () {
        updateStickyTop();
        stripPluginBorders(); // run again after everything settles
    } );

    // Re-measure on resize (e.g. orientation change on mobile)
    window.addEventListener( 'resize', updateStickyTop );

    // =========================================================
    // RELATIVE TIMESTAMPS — refresh every 60 s
    // =========================================================
    function refreshTimestamps() {
        document.querySelectorAll( 'time[datetime]' ).forEach( function ( el ) {
            var date = new Date( el.getAttribute( 'datetime' ) );
            if ( isNaN( date ) ) return;
            var diff = Math.floor( ( Date.now() - date.getTime() ) / 1000 );
            if ( diff < 60 ) {
                el.textContent = 'Just now';
            } else if ( diff < 3600 ) {
                var m = Math.round( diff / 60 );
                el.textContent = m + ' min' + ( m > 1 ? 's' : '' ) + ' ago';
            } else if ( diff < 86400 ) {
                var h = Math.round( diff / 3600 );
                el.textContent = h + ' hour' + ( h > 1 ? 's' : '' ) + ' ago';
            }
        } );
    }

    refreshTimestamps();
    setInterval( refreshTimestamps, 60000 );

} )();
