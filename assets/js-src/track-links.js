export function isVisibleAboveTheFold( el ) {
	const rect = el.getBoundingClientRect();
	return rect.top >= 0 && rect.bottom <= window.innerHeight;
}

export function collectVisibleLinks() {
	const links = Array.from( document.querySelectorAll( 'a' ) );
	const visibleLinks = links
		.filter( ( link ) => isVisibleAboveTheFold( link ) )
		.map( ( link ) => ( {
			url: link.href,
			name: link.textContent.trim().substring( 0, 100 ),
		} ) );

	return {
		visible_links: visibleLinks,
		screen_size: `${ window.innerWidth }x${ window.innerHeight }`,
		date: new Date().toISOString(),
	};
}

if ( typeof window !== 'undefined' && window.addEventListener ) {
	window.addEventListener( 'load', () => {
		setTimeout( () => {
			if ( ! window.WPRocketLinker?.endpoint ) {
				return;
			}

			const payload = collectVisibleLinks();

			fetch( window.WPRocketLinker.endpoint, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Rocket-Linker-Token': window.WPRocketLinker.token,
				},
				body: JSON.stringify( payload ),
			} ).catch( console.error ); // eslint-disable-line no-console
		}, 1000 );
	} );
}
