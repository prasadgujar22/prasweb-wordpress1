/**
 * Guardian News Theme — Main JS
 */
( function () {
    'use strict';

    // ===== Sticky header on scroll =====
    var siteHeader    = document.querySelector( '.site-header' );
    var siteNavWrapper = document.querySelector( '.site-nav-wrapper' );

    var headerHeight = 0;
    function calcHeaderHeight() {
        headerHeight = ( siteHeader ? siteHeader.offsetHeight : 0 );
    }
    calcHeaderHeight();
    window.addEventListener( 'resize', function () {
        calcHeaderHeight();
        initStickySidebar();
    } );

    var ticking = false;

    function onScroll() {
        var currentY = window.scrollY;

        if ( siteNavWrapper ) {
            if ( currentY > headerHeight ) {
                siteNavWrapper.classList.add( 'nav-sticky' );
            } else {
                siteNavWrapper.classList.remove( 'nav-sticky' );
            }
        }

        tickSidebar( currentY );
        ticking = false;
    }

    window.addEventListener( 'scroll', function () {
        if ( ! ticking ) {
            window.requestAnimationFrame( onScroll );
            ticking = true;
        }
    }, { passive: true } );

    // =========================================================
    // STICKY SIDEBAR — JS-driven to bypass any ancestor
    // overflow:hidden / overflow:auto that breaks CSS sticky
    // =========================================================
    var sidebar        = null;
    var sidebarInner   = null;
    var contentArea    = null;
    var sidebarTop     = 0;   // offset from document top to sidebar start
    var sidebarGap     = 20;  // gap from viewport top when stuck (px)
    var lastSidebarY   = -1;
    var sidebarEnabled = false;

    function initStickySidebar() {
        sidebar      = document.querySelector( '.sidebar' );
        contentArea  = document.querySelector( '.content-area' );

        if ( ! sidebar || ! contentArea ) return;

        // Only activate on wide enough screens (matches the CSS 900px breakpoint)
        if ( window.innerWidth <= 900 ) {
            sidebar.style.position = '';
            sidebar.style.top      = '';
            sidebar.style.width    = '';
            sidebarEnabled = false;
            return;
        }

        sidebarEnabled = true;

        // Reset so we can re-measure
        sidebar.style.position = 'relative';
        sidebar.style.top      = '';
        sidebar.style.width    = '';

        // Measure the natural top position of the sidebar relative to the document
        var rect     = sidebar.getBoundingClientRect();
        sidebarTop   = rect.top + window.scrollY;

        // Force the sidebar to keep its width when position:fixed is applied
        sidebar.style.width = sidebar.offsetWidth + 'px';

        // Run once immediately
        tickSidebar( window.scrollY );
    }

    function tickSidebar( scrollY ) {
        if ( ! sidebarEnabled || ! sidebar || ! contentArea ) return;
        if ( scrollY === lastSidebarY ) return;
        lastSidebarY = scrollY;

        var navHeight        = siteNavWrapper ? siteNavWrapper.offsetHeight : 0;
        var offsetTop        = sidebarGap + navHeight;
        var sidebarHeight    = sidebar.offsetHeight;
        var viewportHeight   = window.innerHeight;

        // Bottom boundary: bottom of the .content-area
        var areaRect         = contentArea.getBoundingClientRect();
        var areaBottom       = areaRect.bottom + scrollY;  // absolute document position
        var sidebarMaxTop    = areaBottom - sidebarHeight;

        if ( scrollY + offsetTop < sidebarTop ) {
            // Above the sidebar's natural position — sit in normal flow
            sidebar.style.position = 'absolute';
            sidebar.style.top      = ( sidebarTop - getSidebarParentTop() ) + 'px';

        } else if ( scrollY + offsetTop >= sidebarMaxTop ) {
            // Would go past the bottom of the content area — pin to bottom
            sidebar.style.position = 'absolute';
            sidebar.style.top      = ( sidebarMaxTop - getSidebarParentTop() ) + 'px';

        } else {
            // In the "sticky" zone — fix to viewport
            sidebar.style.position = 'fixed';
            sidebar.style.top      = offsetTop + 'px';
        }
    }

    // Get the offsetTop of the sidebar's closest positioned ancestor
    // (the .content-area which we'll set to position:relative)
    function getSidebarParentTop() {
        if ( ! contentArea ) return 0;
        var r = contentArea.getBoundingClientRect();
        return r.top + window.scrollY;
    }

    // Ensure .content-area is position:relative so absolute children work
    function prepareContentArea() {
        if ( contentArea ) {
            var pos = window.getComputedStyle( contentArea ).position;
            if ( pos === 'static' ) {
                contentArea.style.position = 'relative';
            }
        }
    }

    // Init on DOMContentLoaded + after images load (heights change)
    document.addEventListener( 'DOMContentLoaded', function () {
        contentArea = document.querySelector( '.content-area' );
        prepareContentArea();
        // Small delay lets WP widgets/images start rendering
        setTimeout( initStickySidebar, 100 );
    } );

    window.addEventListener( 'load', function () {
        // Re-init after all images loaded — heights are now accurate
        initStickySidebar();
    } );

    // =========================================================
    // RELATIVE TIMESTAMPS — refresh every 60 s
    // =========================================================
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
                return;
            }
            el.textContent = label;
        } );
    }

    refreshTimestamps();
    setInterval( refreshTimestamps, 60000 );

} )();
