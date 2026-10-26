const monthly = ( p, rate, t ) => {
	const i = rate / 100 / 12;
	return ( p * i ) / ( 1 - Math.pow( 1 + i, -t ) );
};

describe( 'payment calculator formula', () => {
	it( 'matches the documented default ($12,000 / 180 mo / 9.99% ≈ $129)', () => {
		expect( Math.round( monthly( 12000, 9.99, 180 ) ) ).toBe( 129 );
	} );
} );
