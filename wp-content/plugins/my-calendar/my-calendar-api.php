<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function my_calendar_api() {
	if ( isset( $_REQUEST['my-calendar-api'] ) ) {
		if ( get_option( 'mc_api_enabled' ) == 'true' ) {
			// use this filter to add custom scripting handling API keys
			$api_key = apply_filters( 'mc_api_key', true );
			if ( $api_key ) {
				$format = ( isset( $_REQUEST['my-calendar-api'] ) ) ? $_REQUEST['my-calendar-api'] : 'json';
				$from   = ( isset( $_REQUEST['from'] ) ) ? $_REQUEST['from'] : date( 'Y-m-d', current_time( 'timestamp' ) );
				$to     = ( isset( $_REQUEST['to'] ) ) ? $_REQUEST['to'] : date( 'Y-m-d', strtotime( current_time( 'timestamp' ) . apply_filters( 'mc_api_auto_date', '+ 7 days' ) ) );
				// sanitization is handled elsewhere.
				$category = ( isset( $_REQUEST['mcat'] ) ) ? $_REQUEST['mcat'] : '';
				$ltype    = ( isset( $_REQUEST['ltype'] ) ) ? $_REQUEST['ltype'] : '';
				$lvalue   = ( isset( $_REQUEST['lvalue'] ) ) ? $_REQUEST['lvalue'] : '';
				$author   = ( isset( $_REQUEST['author'] ) ) ? $_REQUEST['author'] : '';
				$host     = ( isset( $_REQUEST['host'] ) ) ? $_REQUEST['host'] : '';
				$data     = my_calendar_events( $from, $to, $category, $ltype, $lvalue, 'api', $author, $host );
				$output   = mc_format_api( $data, $format );
				echo $output;
			}
			die;
		} else {
			_e( 'The My Calendar API is not enabled.', 'my-calendar' );
		}
	}
}

function mc_format_api( $data, $format ) {
	switch ( $format ) {
		case 'json' :
			mc_format_json( $data );
			break;
		case 'rss' :
			mc_api_format_rss( $data );
			break;
		case 'csv' :
			mc_format_csv( $data );
			break;
	}
}

function mc_format_json( $data ) {
	echo json_encode( $data );
}

function mc_format_csv( $data ) {
	$keyed = false;
	// Create a stream opening it with read / write mode
	$stream = fopen( 'data://text/plain,' . "", 'w+' );
	// Iterate over the data, writing each line to the text stream
	foreach ( $data as $key => $val ) {
		foreach ( $val as $v ) {
			$values = get_object_vars( $v );
			if ( ! $keyed ) {
				$keys = array_keys( $values );
				fputcsv( $stream, $keys );
				$keyed = true;
			}
			fputcsv( $stream, $values );
		}
	}
	// Rewind the stream
	rewind( $stream );
	// You can now echo its content
	header( "Content-type: text/csv" );
	header( "Content-Disposition: attachment; filename=my-calendar.csv" );
	header( "Pragma: no-cache" );
	header( "Expires: 0" );

	echo stream_get_contents( $stream );
	// Close the stream
	fclose( $stream );
	die;
}

function mc_api_format_rss( $data ) {
	$output = mc_format_rss( $data );
	header( 'Content-type: application/rss+xml' );
	header( "Pragma: no-cache" );
	header( "Expires: 0" );
	echo $output;
}

// Export single event as iCal file
function mc_export_vcal() {
	if ( isset( $_GET['vcal'] ) ) {
		$vcal = $_GET['vcal'];
		print my_calendar_send_vcal( $vcal );
		die;
	}
}

function my_calendar_send_vcal( $event_id ) {
	header( "Content-Type: text/calendar" );
	header( "Cache-control: private" );
	header( 'Pragma: private' );
	header( "Expires: Thu, 11 Nov 1977 05:40:00 GMT" ); // That's my birthday. :)
	header( "Content-Disposition: inline; filename=my-calendar.ics" );
	$output = preg_replace( "~(?<!\r)\n~", "\r\n", my_calendar_generate_vcal( $event_id ) );

	return urldecode( stripcslashes( $output ) );
}

function my_calendar_generate_vcal( $event_id = false ) {
	global $mc_version;
	$output = '';
	$mc_id  = ( isset( $_GET['vcal'] ) ) ? (int) str_replace( 'mc_', '', $_GET['vcal'] ) : $event_id;
	if ( $mc_id ) {
		$event = mc_get_event( $mc_id, 'object' );
		// need to modify date values to match real values using date above
		$array = mc_create_tags( $event );

		$template = "BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
PRODID:-//Accessible Web Design//My Calendar//http://www.joedolson.com//v$mc_version//EN';
BEGIN:VEVENT
UID:{dateid}-{id}
LOCATION:{ical_location}
SUMMARY:{title}
DTSTAMP:{ical_start}
ORGANIZER;CN={host}:MAILTO:{host_email}
DTSTART:{ical_start}
DTEND:{ical_end}
CATEGORIES:{category}
URL;VALUE=URI:{link}
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:{ical_desc}
END:VEVENT
END:VCALENDAR";
		$template = apply_filters( 'mc_single_ical_template', $template, $array );
		$output   = jd_draw_template( $array, $template );
	}

	return $output;
}

function my_calendar_rss( $events = array() ) {
	// establish template
	if ( isset( $_GET['mcat'] ) ) {
		$cat_id = (int) $_GET['mcat'];
	} else {
		$cat_id = false;
	}
	// add RSS headers
	if ( empty( $events ) ) {
		$events = mc_get_rss_events( $cat_id );
	}
	$output = mc_format_rss( $events );
	if ( $output ) {
		header( 'Content-type: application/rss+xml' );
		header( "Pragma: no-cache" );
		header( "Expires: 0" );
		echo $output;
	}
}

function mc_format_rss( $events ) {
	if ( is_array( $events ) && !empty( $events ) ) {
		$template = "\n<item>
			<title>{rss_title}</title>
			<link>{details_link}</link>
			<pubDate>{rssdate}</pubDate>
			<dc:creator>{author}</dc:creator>  	
			<description><![CDATA[{rss_description}]]></description>
			<date>{dtstart}</date>
			<dateSubmitted>{rssdate}</dateSubmitted>
			<content:encoded><![CDATA[<div class='vevent'>
			<h1 class='summary'>{rss_title}</h1>
			<div class='description'>{rss_description}</div>
			<p class='dtstart' title='{ical_start}'>Begins: {time} on {date}</p>
			<p class='dtend' title='{ical_end}'>Ends: {endtime} on {enddate}</p>	
			<p>Recurrance: {recurs}</p>
			<p>Repetition: {repeats} times</p>
			<div class='location'>{rss_hcard}</div>
			{rss_link_title}
			</div>]]></content:encoded>
			<dc:format xmlns:dc='http://purl.org/dc/elements/1.1/'>text/html</dc:format>
			<dc:source xmlns:dc='http://purl.org/dc/elements/1.1/'>" . home_url() . "</dc:source>
			{guid}
		  </item>\n";

		if ( get_option( 'mc_use_rss_template' ) == 1 ) {
			$templates = get_option( 'mc_templates' );
			$template  = $templates['rss'];
		}

		$charset = get_bloginfo( 'charset' );
		$output  = '<?xml version="1.0" encoding="' . $charset . '"?>
		<rss version="2.0"
			xmlns:content="http://purl.org/rss/1.0/modules/content/"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:atom="http://www.w3.org/2005/Atom"
			xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
			xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
			>
		<channel>
		  <title>' . get_bloginfo( 'name' ) . ' Calendar</title>
		  <link>' . home_url() . '</link>
		  <description>' . get_bloginfo( 'description' ) . ': My Calendar Events</description>
		  <language>' . get_bloginfo( 'language' ) . '</language>
		  <managingEditor>' . get_bloginfo( 'admin_email' ) . ' (' . get_bloginfo( 'name' ) . ' Admin)</managingEditor>
		  <generator>My Calendar WordPress Plugin http://www.joedolson.com/my-calendar/</generator>
		  <lastBuildDate>' . mysql2date( 'D, d M Y H:i:s +0000', current_time( 'timestamp' ) ) . '</lastBuildDate>
		  <atom:link href="' . htmlentities( esc_url( add_query_arg( $_GET, mc_get_current_url() )  ) ) . '" rel="self" type="application/rss+xml" />';
		foreach ( $events as $date ) {
			foreach ( array_keys( $date ) as $key ) {
				$event =& $date[ $key ];
				$array = mc_create_tags( $event );
				$output .= jd_draw_template( $array, $template, 'rss' );
			}
		}
		$output .= '</channel>
		</rss>';

		return mc_strip_to_xml( $output );
	} else {
		return false;
	}
}

// just a double check to try to ensure that the XML feed can be rendered.
function mc_strip_to_xml( $value ) {
	$ret = $current = "";
	if ( empty( $value ) ) {
		return $ret;
	}
	$length = strlen( $value );
	for ( $i = 0; $i < $length; $i ++ ) {
		$current = ord( $value{$i} );
		if ( ( $current == 0x9 ) ||
		     ( $current == 0xA ) ||
		     ( $current == 0xD ) ||
		     ( ( $current >= 0x20 ) && ( $current <= 0xD7FF ) ) ||
		     ( ( $current >= 0xE000 ) && ( $current <= 0xFFFD ) ) ||
		     ( ( $current >= 0x10000 ) && ( $current <= 0x10FFFF ) )
		) {
			$ret .= chr( $current );
		} else {
			$ret .= " ";
		}
	}
	$ret = iconv( "UTF-8", "UTF-8//IGNORE", $ret );

	return $ret;
}


function my_calendar_ical() {
	$p  = ( isset( $_GET['span'] ) ) ? 'year' : false;
	$y  = ( isset( $_GET['yr'] ) ) ? $_GET['yr'] : date( 'Y' );
	$m  = ( isset( $_GET['month'] ) ) ? $_GET['month'] : date( 'n' );
	$ny = ( isset( $_GET['nyr'] ) ) ? $_GET['nyr'] : $y;
	$nm = ( isset( $_GET['nmonth'] ) ) ? $_GET['nmonth'] : $m;

	if ( $p ) {
		$from = "$y-1-1";
		$to   = "$y-12-31";
	} else {
		$d    = date( 't', mktime( 0, 0, 0, $m, 1, $y ) );
		$from = "$y-$m-1";
		$to   = "$ny-$nm-$d";
	}

	$from = apply_filters( 'mc_ical_download_from', $from, $p );
	$to   = apply_filters( 'mc_ical_download_to', $to, $p );
	$atts = array(
		'category' => null,
		'ltype'    => '',
		'lvalue'   => '',
		'source'   => 'calendar',
		'author'   => null,
		'host'     => null
	);
	$atts = apply_filters( 'mc_ical_attributes', $atts );
	extract( $atts );

	global $mc_version;
// establish template
	$template = "BEGIN:VEVENT
UID:{dateid}-{id}
LOCATION:{ical_location}
SUMMARY:{title}
DTSTAMP:{ical_start}
ORGANIZER;CN={host}:MAILTO:{host_email}
DTSTART:{ical_start}
DTEND:{ical_end}
URL;VALUE=URI:{link}
DESCRIPTION:{ical_desc}
CATEGORIES:{category}
END:VEVENT";
// add ICAL headers
	$output = 'BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
PRODID:-//Accessible Web Design//My Calendar//http://www.joedolson.com//v' . $mc_version . '//EN';
	// to do : add support for other arguments
	//$events = my_calendar_grab_events( $from, $to, $category, $ltype, $lvalue, $source, $author, $host );
	// my calendar grab events returns a flat array, but doesn't eliminate holiday cancellations; my-calendar_events eliminates those, but isn't a flat array. 
	// rewrite array navigation so that this works.
	$events = my_calendar_events( $from, $to, $category, $ltype, $lvalue, $source, $author, $host );
	$events = mc_flatten_event_array( $events );
	
	if ( is_array( $events ) && ! empty( $events ) ) {
		foreach ( array_keys( $events ) as $key ) {
			$event =& $events[ $key ];
			if ( is_object( $event ) ) {
				if ( ! ( $event->category_private == 1 && ! is_user_logged_in() ) ) {
					$array = mc_create_tags( $event );
					$output .= "\n" . jd_draw_template( $array, $template, 'ical' );
				}
			}
		}
	}
	$output .= "\nEND:VCALENDAR";
	$output = html_entity_decode( preg_replace( "~(?<!\r)\n~", "\r\n", $output ) );
	if ( ! ( isset( $_GET['sync'] ) && $_GET['sync'] == 'true' ) ) {
		header( "Content-Type: text/calendar; charset=" . get_bloginfo( 'charset' ) );
		header( "Pragma: no-cache" );
		header( "Expires: 0" );
		header( "Content-Disposition: inline; filename=my-calendar.ics" );
	}
	echo $output;
}

function mc_flatten_event_array( $events ) {
	$flat = array();
	foreach( $events as $event ) {
		foreach( $event as $e ) {
			$flat[] = $e;
		}
	}
	
	return $flat;
}