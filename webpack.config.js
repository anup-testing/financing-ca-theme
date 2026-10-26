/**
 * Webpack config: extends @wordpress/scripts.
 * Every file in src/js/{frontend,admin,editor} and src/css/{frontend,admin,editor}
 * (not starting with `_`) becomes an entry, written to assets/build/{js,css}/....
 */
const path = require( 'path' );
const fs = require( 'fs' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );

const AREAS = [ 'frontend', 'admin', 'editor' ];

const entries = ( type, exts ) => {
	const result = {};
	AREAS.forEach( ( area ) => {
		const dir = path.resolve( __dirname, 'src', type, area );
		if ( ! fs.existsSync( dir ) ) {
			return;
		}
		fs.readdirSync( dir )
			.filter( ( f ) => exts.includes( path.extname( f ) ) && ! f.startsWith( '_' ) )
			.forEach( ( f ) => {
				const name = path.basename( f, path.extname( f ) );
				result[ `${ type }/${ area }/${ name }` ] = path.join( dir, f );
			} );
	} );
	return result;
};

module.exports = {
	...defaultConfig,
	entry: {
		...entries( 'js', [ '.js' ] ),
		...entries( 'css', [ '.scss', '.css' ] ),
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, 'assets/build' ),
	},
	plugins: [
		...defaultConfig.plugins.filter(
			( p ) => p.constructor.name !== 'MiniCssExtractPlugin'
		),
		new MiniCssExtractPlugin( { filename: '[name].css' } ),
	],
};
