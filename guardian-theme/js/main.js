/**
 * Guardian News Theme — Main JS
 */
( function () {
    'use strict';

    // =========================================================
    // STICKY HEADER
    // =========================================================
    var siteHeader     = document.querySelector( '.site-header' );
    var siteNavWrapper = document.querySelector( '.site-nav-wrapper' );
    var headerHeight   = 0;

    function calcHeaderHeight() {
        headerHeight = siteHeader ? siteHeader.offsetHeight : 0;
    }
    calcHeaderHeight();

    // =========================================================
    // STICKY SIDEBAR
    // The outer .sidebar stays in the CSS grid (never repositioned).
    // Only the inner .sidebar-sticky div is moved, so the grid
    // column width is always preserved and nothing overlaps.
    // =========================================================
    var sidebarOuter  = null;   // <aside class="sidebar">  — stays in grid
    var sidebarInner  = null;   // <div class="sidebar-sticky"> — gets fixed
    var sidebarEnabled = false;

    function initStickySidebar() {
        sidebarOuter = document.querySelector( '.sidebar' );
        sidebarInner = document.querySelector( '.sidebar-sticky' );

        if ( ! sidebarOuter || ! sidebarInner ) return;

        // Reset inner to normal flow before measuring
        sidebarInner.style.position = '';
        sidebarInner.style.top      = '';
        sidebarInner.style.width    = '';
        sidebarInner.style.left     = '';

        // Only on desktop (matches the CSS 900px breakpoint)
        if ( window.innerWidth <= 900 ) {
            sidebarEnabled = false;
            return;
        }

        sidebarEnabled = true;
        tickSidebar( window.scrollY );
    }

    function tickSidebar( scrollY ) {
        if ( ! sidebarEnabled || ! sidebarOuter || ! sidebarInner ) return;

        var navHeight    = siteNavWrapper ? siteNavWrapper.offsetHeight : 0;
        var gap          = 16;                          // px gap from viewport top
        var offsetTop    = navHeight + gap;

        var outerRect    = sidebarOuter.getBoundingClientRect();
        var innerHeight  = sidebarInner.offsetHeight;
        var outerBottom  = outerRect.bottom + scrollY; // absolute doc position

        // When the bottom of the outer column would be above the inner widget bottom
        var stickStart   = outerRect.top + scrollY;    // abs doc top of sidebar column
        var stickEnd     = outerBottom - innerHeight;  // abs doc pos where we pin to bottom

        if ( scrollY + offsetTop < stickStart ) {
            // Above natural position — sit in normal flow
            sidebarInner.style.position = 'relative';
            sidebarInner.style.top      = '';
            sidebarInner.style.width    = '';
            sidebarInner.style.left     = '';

        } else if ( scrollY + offsetTop >= stickEnd ) {
            // Past bottom boundary — pin to bottom of outer column
            sidebarInner.style.position = 'absolute';
            sidebarInner.style.top      = ( stickEnd - stickStart ) + 'px';
            sidebarInner.style.width    = outerRect.width + 'px';
            sidebarInner.style.left     = '0';
            // Outer needs relative so absolute child is scoped to it
            sidebarOuter.style.position = 'relative';

        } else {
            // In sticky zone — fix to viewport
            sidebarInner.style.position = 'fixed';
            sidebarInner.style.top      = offsetTop + 'px';
            sidebarInner.style.width    = outerRect.width + 'px';
            sidebarInner.style.left     = outerRect.left + 'px';
            sidebarOuter.style.position = 'relative';
        }
    }

    // =========================================================
    // SCROLL HANDLER (single rAF loop for both nav + sidebar)
    // =========================================================
    var ticking = false;

    function onScroll() {
        var scrollY = window.scrollY;

        // Sticky nav
        if ( siteNavWrapper ) {
            if ( scrollY > headerHeight ) {
                siteNavWrapper.classList.add( 'nav-sticky' );
            } else {
                siteNavWrapper.classList.remove( 'nav-sticky' );
            }
        }

        // Sticky sidebar inner
        tickSidebar( scrollY );

        ticking = false;
    }

    window.addEventListener( 'scroll', function () {
        if ( ! ticking ) {
            window.requestAnimationFrame( onScroll );
            ticking = true;
        }
    }, { passive: true } );

    // Re-init on resize
    window.addEventListener( 'resize', function () {
        calcHeaderHeight();
        initStickySidebar();
    } );

    // Init after DOM ready then again after images load
    document.addEventListener( 'DOMContentLoaded', function () {
        calcHeaderHeight();
        setTimeout( initStickySidebar, 120 );
    } );

    window.addEventListener( 'load', initStickySidebar );

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
