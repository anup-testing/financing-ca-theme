/* Financing.ca — concept site behaviour */
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

	/* ---- industries dropdown ---- */
	const drop = document.querySelector( '.has-drop' );
	if ( drop ) {
		const trigger = drop.querySelector( '.menu-link' );
		const open = function ( state ) {
			drop.classList.toggle( 'open', state );
			trigger.setAttribute( 'aria-expanded', String( state ) );
		};
		trigger.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
			open( ! drop.classList.contains( 'open' ) );
		} );
		drop.addEventListener( 'mouseenter', function () {
			open( true );
		} );
		drop.addEventListener( 'mouseleave', function () {
			open( false );
		} );
		document.addEventListener( 'click', function () {
			open( false );
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) {
				open( false );
			}
		} );
	}

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

	/* ---- payment calculator ---- */
	const amt = document.getElementById( 'amt' );
	if ( amt ) {
		const amtOut = document.getElementById( 'amtOut' );
		const payOut = document.getElementById( 'pay' );
		const cobOut = document.getElementById( 'cob' );
		const termSeg = document.getElementById( 'term' );
		const promoSeg = document.getElementById( 'promo' );
		let term = 180;
		let rate = 9.99;

		const money = function ( n, dp ) {
			return (
				'$' +
				n.toLocaleString( 'en-CA', {
					minimumFractionDigits: dp || 0,
					maximumFractionDigits: dp || 0,
				} )
			);
		};

		const paint = function () {
			const pct =
				( ( amt.value - amt.min ) / ( amt.max - amt.min ) ) * 100;
			amt.style.background =
				'linear-gradient(90deg,var(--brand) 0%,var(--brand) ' +
				pct +
				'%,#e6ecf4 ' +
				pct +
				'%)';
		};

		const calc = function () {
			const p = Number( amt.value );
			let t = term;
			const r = rate;
			let monthly, total;

			if ( r === 0 ) {
				// 0% promotional offers run over a 24-month equal-payment term
				t = 24;
				monthly = p / t;
				total = p;
			} else {
				const i = r / 100 / 12;
				monthly = ( p * i ) / ( 1 - Math.pow( 1 + i, -t ) );
				total = monthly * t;
			}

			amtOut.textContent = money( p );
			payOut.innerHTML =
				money( Math.round( monthly ) ) + '<small>/mo</small>';
			cobOut.textContent = money(
				Math.max( 0, Math.round( total - p ) )
			);
			paint();
		};

		const wireSeg = function ( seg, apply ) {
			if ( ! seg ) {
				return;
			}
			seg.addEventListener( 'click', function ( e ) {
				const b = e.target.closest( 'button' );
				if ( ! b ) {
					return;
				}
				seg.querySelectorAll( 'button' ).forEach( function ( x ) {
					x.classList.toggle( 'on', x === b );
					x.setAttribute( 'aria-checked', String( x === b ) );
				} );
				apply( Number( b.dataset.v ) );
				calc();
			} );
		};

		wireSeg( termSeg, function ( v ) {
			term = v;
		} );
		wireSeg( promoSeg, function ( v ) {
			rate = v;
		} );
		amt.addEventListener( 'input', calc );
		calc();
	}

	/* ---- animated stat counters ---- */
	const stats = document.querySelectorAll( '[data-count]' );
	if ( stats.length && 'IntersectionObserver' in window ) {
		var so = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					const el = entry.target;
					so.unobserve( el );
					const target = Number( el.dataset.count );
					const prefix = el.dataset.prefix || '';
					const suffix = el.dataset.suffix || '';
					const start = performance.now();
					const tick = function ( now ) {
						const k = Math.min( 1, ( now - start ) / 1100 );
						const eased = 1 - Math.pow( 1 - k, 3 );
						const v = Math.round( target * eased );
						el.textContent =
							prefix + v.toLocaleString( 'en-CA' ) + suffix;
						if ( k < 1 ) {
							requestAnimationFrame( tick );
						}
					};
					requestAnimationFrame( tick );
				} );
			},
			{ threshold: 0.4 }
		);
		stats.forEach( function ( el ) {
			so.observe( el );
		} );
	} else {
		stats.forEach( function ( el ) {
			el.textContent =
				( el.dataset.prefix || '' ) +
				el.dataset.count +
				( el.dataset.suffix || '' );
		} );
	}

	/* ---- demo lead form ---- */
	const form = document.getElementById( 'leadform' );
	if ( form ) {
		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			const note = document.getElementById( 'formnote' );
			let bad = false;
			form.querySelectorAll( '[required]' ).forEach( function ( f ) {
				const empty = ! f.value.trim();
				f.classList.toggle( 'err', empty );
				if ( empty ) {
					bad = true;
				}
			} );
			if ( bad ) {
				note.textContent = 'Please complete the highlighted fields.';
				note.classList.remove( 'good' );
				return;
			}
			const btn = form.querySelector( 'button[type=submit]' );
			const cfg = window.FinancingCA || {};
			if ( ! cfg.leadUrl ) {
				note.textContent = 'Thanks — we will be in touch shortly.';
				note.classList.add( 'good' );
				btn.textContent = 'Request received';
				return;
			}
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
					note.textContent =
						'Thanks — a Financing.ca specialist will be in touch shortly.';
					note.classList.add( 'good' );
					btn.textContent = 'Request received';
				} )
				.catch( function () {
					btn.disabled = false;
					note.textContent =
						'Something went wrong. Please try again or email partners@financing.ca.';
					note.classList.remove( 'good' );
				} );
		} );
	}
} )();
