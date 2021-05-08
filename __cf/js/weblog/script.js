/*--------------------------------------------------------------

	xx
	
	@memo
	
---------------------------------------------------------------*/

jQuery( function( $ ) {
	
	var
		breakpoint = [ 600, 960 ],
		fromMode   = 'none'
	;
	
	/* autopager */
	var
		autopagerBtn   = '.autopager_btn a',
		repeatSet      = '.article_set',
		appendToWrap   = '.entries_wrap'
	;
	
/***** func : main *****/
	
	function eventify() {
	}
	
	function changed( mode ) {
		
		if( mode === 'sp' ) {
			/* sp */
		} else if( mode === 'sp_tb' ) {
			/* sp_tb * sp_tb で切り替えしない場合 */
		} else if( mode === 'tb' ) {
			/* tb */
		} else if( mode === 'tb_pc' ) {
			/* tb_pc * tb_pc で切り替えしない場合 */
		} else if( mode === 'pc' ) {
			/* pc */
		} else if( mode === 'every' ) {
			/* every */
		}
	}
	
	function setup() {
		
		/* autopager */
		$.autopager( {
			autoLoad : false,
			content  : repeatSet,
			appendTo : appendToWrap,
			link     : autopagerBtn,
			load     : function( current, next ) {
				if( next.url == '' ){
					$( autopagerBtn ).hide();	
				}
            }
		});
		$( appendToWrap ).on( 'click', autopagerBtn, function(){
			$( this ).parent().fadeOut();
			$.autopager( 'load' );
			return false;
		} );
	}
	
/***** util *****/
	
	function changedMedia( status ) {
		if( status === 'sp' ) {
			return window.matchMedia( 'screen and (max-width: ' + breakpoint[ 0 ] + 'px)' );
		} else if( status === 'tb' ) {
			return window.matchMedia( 'screen and (min-width: ' + breakpoint[ 0 ] + 'px) and (max-width: ' + breakpoint[ 1 ] + 'px)' );
		} else if( status === 'pc' ) {
			return window.matchMedia( 'screen and (min-width: ' + breakpoint[ 1 ] + 'px)' );
		} else {
			return false;
		}
	}
	
/***** run *****/
	
	function changed_core() {
		changed( 'every' );
		if( changedMedia( 'sp' ).matches ) {
			changed( 'sp' );
			if( fromMode !== 'tb' ) changed( 'sp_tb' );
			fromMode = 'sp';
		} else if( changedMedia( 'tb' ).matches ) {
			if( fromMode !== 'sp' ) changed( 'sp_tb' );
			changed( 'tb' );
			if( fromMode !== 'pc' ) changed( 'tb_pc' );
			fromMode = 'tb';
		} else if( changedMedia( 'pc' ).matches ) {
			if( fromMode !== 'tb' ) changed( 'tb_pc' );
			changed( 'pc' );
			fromMode = 'pc';
		}
	}
	
	$(  function () {
		eventify();
		changedMedia( 'sp' ).addListener( changed_core );
		// 切り替え時にaddしているのでtb不要
		changedMedia( 'pc' ).addListener( changed_core );
		changed_core();
		setup();
	} );
	
} );