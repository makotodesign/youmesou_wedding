/* admin_user_xx */

( function ( $ ) {
	
	// disabled
	var 
		$disabledField
	;
	// title_from_selects
	var 
		$titleWrap,
		$titleField,
		acfField01,
		acfField02,
		acfSelectedVal01,
		acfSelectedVal02
	;
	
	function init() {
		create();
		eventify();
		setup();
	}
	
	function create() {
		
		// disabled
		$disabledField   = $( '#acf-field-' + 'acfxxxxxxx' );
		
		// title_from_selects
		$titleWrap       = $( '#titlediv' );
		$titleField      = $( 'input#title' );
		acfField01       = '#acf-field-' + 'acfxxxxxxx';
		acfField02       = '#acf-field-' + 'acfxxxxxxx';
		acfSelectedVal01 = $(acfField01).val();
		acfSelectedVal02 = $(acfField02).val();
	}
	
	function eventify() {
		
		// title_from_selects
		$( document ).on( 'change', acfField01, function() {
			acfSelectedVal01 = $( this ).val();
			$titleField.val( acfSelectedVal01 + acfSelectedVal02 );
		} );
		$( document ).on( 'change', acfField02, function() {
			acfSelectedVal02 = $( this ).val();
			$titleField.val( acfSelectedVal01 + acfSelectedVal02 );
		} );
	}
	
	function setup() {
		
		// disabled
		$( '#title' ).prop( 'disabled', true ); // for title
		$disabledField.prop( 'disabled', true );
		
		// title_from_selects
		$titleWrap.hide();
		$titleField.val( acfSelectedVal01 + acfSelectedVal02 );
	}
	
	$(function () {
		init();
	} );

})( jQuery );