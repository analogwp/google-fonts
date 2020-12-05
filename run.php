<?php

date_default_timezone_set( 'UTC' );

$output = shell_exec( 'git log -1' );
echo shell_exec( 'git checkout -f master' );

$arrContextOptions = array(
	"ssl" => array(
		"verify_peer"      => false,
		"verify_peer_name" => false,
	),
);

$key    = getenv( 'GOOGLEKEY' );
$result = json_decode( file_get_contents( "https://webfonts.googleapis.com/v1/webfonts?sort=ALPHA&fields=items.family&key={$key}", false, stream_context_create( $arrContextOptions ) ) );
$fonts = [];
$gFile = dirname( __FILE__ ) . '/fonts.json';

foreach ( $result->items as $font ) {
    $fonts[] = $font->family;
}

$data = json_encode( $fonts );
file_put_contents( $gFile, $data );

echo "Saved new JSON\n\n";
