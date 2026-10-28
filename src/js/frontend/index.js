/* The Tankless — theme behaviour */
( function () {
	'use strict';

	/* ---- sticky nav shadow ---- */
	const nav = document.getElementById( 'nav' );
	const onScroll = function () {
		if ( nav ) {
			nav.classList.toggle( 'stuck', window.scrollY > 8 );
		}
	};
	onScroll();
	window.addEventListener( 'scroll', onScroll, { passive: true } );

	/* ---- mark the current page in the nav ---- */
	const here = window.location.pathname.replace( /\/+$/, '' ) || '/';
	document
		.querySelectorAll( '.menu-link, .mobile-menu a' )
		.forEach( function ( a ) {
			const path = a.pathname.replace( /\/+$/, '' ) || '/';
			if (
				path === here &&
				! a.hash &&
				! a.classList.contains( 'btn' )
			) {
				a.setAttribute( 'aria-current', 'page' );
			}
		} );

	/* ---- ticker: duplicate the track content for a seamless loop ---- */
	document
		.querySelectorAll( '.ticker .marquee-track' )
		.forEach( function ( track ) {
			const first = track.firstElementChild;
			if ( first && track.children.length === 1 ) {
				const copy = first.cloneNode( true );
				copy.setAttribute( 'aria-hidden', 'true' );
				track.appendChild( copy );
			}
		} );

	/* ---- mobile menu ---- */
	const burger = document.querySelector( '.burger' );
	const mobile = document.querySelector( '.mobile-menu' );
	if ( burger && mobile ) {
		burger.addEventListener( 'click', function () {
			const show = mobile.hasAttribute( 'hidden' );
			if ( show ) {
				mobile.removeAttribute( 'hidden' );
				mobile.style.display = 'flex';
			} else {
				mobile.setAttribute( 'hidden', '' );
				mobile.style.display = 'none';
			}
			burger.setAttribute( 'aria-expanded', String( show ) );
		} );
		mobile.addEventListener( 'click', function ( e ) {
			if ( e.target.tagName === 'A' ) {
				mobile.setAttribute( 'hidden', '' );
				mobile.style.display = 'none';
				burger.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	}

	/* ---- reveal on scroll ---- */
	const items = document.querySelectorAll( '.reveal' );
	if ( ! ( 'IntersectionObserver' in window ) ) {
		items.forEach( function ( el ) {
			el.classList.add( 'in' );
		} );
	} else {
		var io = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry, i ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					const el = entry.target;
					setTimeout(
						function () {
							el.classList.add( 'in' );
						},
						Math.min( i, 5 ) * 70
					);
					io.unobserve( el );
				} );
			},
			{ rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
		);
		items.forEach( function ( el ) {
			io.observe( el );
		} );
	}

	/* ---- footer email sign-up (lead endpoint) ---- */
	const form = document.getElementById( 'leadform' );
	if ( form ) {
		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			const note = document.getElementById( 'formnote' );
			let bad = false;
			form.querySelectorAll( '[required]' ).forEach( function ( f ) {
				const empty = ! f.value.trim() || ! f.checkValidity();
				f.classList.toggle( 'err', empty );
				if ( empty ) {
					bad = true;
				}
			} );
			if ( bad ) {
				note.textContent = 'Please enter a valid email address.';
				note.classList.remove( 'good' );
				return;
			}
			const cfg = window.TheTankless || {};
			if ( ! cfg.leadUrl ) {
				note.textContent = 'Thanks — you are on the list.';
				note.classList.add( 'good' );
				return;
			}
			const btn = form.querySelector( 'button[type=submit]' );
			const data = {};
			new FormData( form ).forEach( function ( v, k ) {
				data[ k ] = v;
			} );
			btn.disabled = true;
			fetch( cfg.leadUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify( data ),
			} )
				.then( function ( r ) {
					if ( ! r.ok ) {
						throw new Error( 'bad status' );
					}
					note.textContent = 'Thanks — you are on the list.';
					note.classList.add( 'good' );
					form.reset();
					btn.disabled = false;
				} )
				.catch( function () {
					btn.disabled = false;
					note.textContent =
						'Something went wrong. Please try again or email support@tankless.ca.';
					note.classList.remove( 'good' );
				} );
		} );
	}
} )();
