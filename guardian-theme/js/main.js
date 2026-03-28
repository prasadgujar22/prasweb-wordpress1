/**
 * Guardian News Theme — Main JS
 */
( function () {
    'use strict';

    // ===== Sticky header on scroll =====
    var siteTopbar    = document.querySelector( '.site-topbar' );
    var siteHeader    = document.querySelector( '.site-header' );
    var siteNavWrapper = document.querySelector( '.site-nav-wrapper' );

    var headerHeight = 0;
    function calcHeaderHeight() {
        headerHeight = ( siteTopbar ? siteTopbar.offsetHeight : 0 )
                     + ( siteHeader ? siteHeader.offsetHeight : 0 );
    }
    calcHeaderHeight();
    window.addEventListener( 'resize', calcHeaderHeight );

    var lastScrollY = 0;
    var ticking     = false;

    function onScroll() {
        var currentY = window.scrollY;

        if ( siteNavWrapper ) {
            if ( currentY > headerHeight ) {
                siteNavWrapper.classList.add( 'nav-sticky' );
            } else {
                siteNavWrapper.classList.remove( 'nav-sticky' );
            }
        }

        lastScrollY = currentY;
        ticking     = false;
    }

    window.addEventListener( 'scroll', function () {
        if ( ! ticking ) {
            window.requestAnimationFrame( onScroll );
            ticking = true;
        }
    }, { passive: true } );

    // ===== Relative timestamps refresh every 60 s =====
    function refreshTimestamps() {
        var times = document.querySelectorAll( 'time[datetime]' );
        times.forEach( function ( el ) {
            var dt   = el.getAttribute( 'datetime' );
            var date = new Date( dt );
            if ( isNaN( date ) ) return;

            var diff = Math.floor( ( Date.now() - date.getTime() ) / 1000 );
            var label;

            if ( diff < 60 ) {
                label = 'Just now';
            } else if ( diff < 3600 ) {
                var m = Math.round( diff / 60 );
                label = m + ' min' + ( m > 1 ? 's' : '' ) + ' ago';
            } else if ( diff < 86400 ) {
                var h = Math.round( diff / 3600 );
                label = h + ' hour' + ( h > 1 ? 's' : '' ) + ' ago';
            } else {
                // keep existing text for older posts
                return;
            }
            el.textContent = label;
        } );
    }

    refreshTimestamps();
    setInterval( refreshTimestamps, 60000 );

} )();
