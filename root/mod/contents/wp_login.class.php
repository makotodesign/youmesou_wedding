<?php
/**************************************************************************
 *
 * wp_oo_login.class
 * 		会員機能 ログイン判定クラス
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		118.1.1
 *
 * @history
 * 		2019-09-27	新規制作N[ 1.1.1 ]
 * 		2021-01-08	判定のみの使用
 * 					リダイレクト自動生成
 * 					該当セッションの自動クリア[ 17.1.1 ]
 *
 * *************************************************************************/

class wp_oo_login {

	public $debug_report;

	public $status;               // loggedin || loggedin_other_account || not_login
	public $login_failed = false; // true || false
	public $redirect_after_loggedin;
	public $user_info;

	private $mode;
	private $is_wp_login;
	private $is_wp_user_check;

	### constructor

	function __construct( $mode, $wp_user_ids = 'all' ) {

		// mode
		if( $mode === 'login_mode' || $mode === 'loggedin_mode' || $mode === 'dispself_mode' ) {
			$this->mode = $mode;
		} else {
			$this->mode = 'mode_error';
		}

		// wp_login_check
		$this->is_wp_login = is_user_logged_in();

		// wp_user_check
		if( $wp_user_ids === 'all' ) {
			$wp_user_ids = 'all';
			$this->is_wp_user_check = true;
		} else {
			$wp_user_ids = ( ! is_array( $wp_user_ids ) ) ? explode( ',', $wp_user_ids ) : $wp_user_ids;
			if( in_array( get_current_user_id(), $wp_user_ids ) ) {
				$this->is_wp_user_check = true;
			} else {
				$this->is_wp_user_check = false;
			}
		}

		// redirect
		$this->redirect_after_loggedin = '';
		if( $this->mode === 'loggedin_mode' && ! $this->is_wp_login ) {
			$temp_url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			if( strpos( $temp_url, home_url() ) === 0 ) {
				$_SESSION[ 'redirect_url' ] = $temp_url;
				$this->redirect_after_loggedin = $temp_url;
			}
		}

		// status
		if( $this->is_wp_login && $this->is_wp_user_check ) {
			$this->status = 'loggedin';
		} elseif( $this->is_wp_login && ! $this->is_wp_user_check ) {
			$this->status = 'loggedin_other_account';
		} else {
			$this->status = 'not_login';
		}

		// login_faled
		if( isset( $_GET[ 'login' ] ) && $_GET[ 'login' ] === 'failed' ) {
			$this->login_failed = true;
		}
	}

	### public function

	/* login_check_redirect */
	public function login_check_redirect( $redirect = '' ) {

		if( $this->mode === 'login_mode'          && $this->status === 'loggedin' ) {
			$redirect = $this->redirect_after_loggedin ?? $redirect;
			header( 'Location: ' . $redirect );
		} elseif( $this->mode === 'loggedin_mode' && $this->status !== 'loggedin' ) {
			header( 'Location: ' . $redirect );
		}
	}

	/* reset session */
	public function reset_session_not_login( $arr ) {
		if( is_array( $arr ) && ! $this->is_wp_login ) {
			foreach( $arr as  $v ) {
				$_SESSION[ $v ] = '';
			}
		}
	}

	/* get_user_info */
	public function get_wp_user_info( $type = 'def', $meta_keys = [] ) {

		$temp_user_info_arr = [];
		$wp_current_user = wp_get_current_user();
		// user_info
		$temp_user_info_arr[ 'wp_id' ]             = $wp_current_user->ID;
		$temp_user_info_arr[ 'user_login' ]        = $wp_current_user->user_login;
		if( $type === 'detail' ) {
			$temp_user_info_arr[ 'user_nicename' ]     = $wp_current_user->user_nicename; //サニタイズ後のログインIDを取得
			$temp_user_info_arr[ 'display_name' ]      = $wp_current_user->display_name;  //サニタイズ後のログインIDを取得
			$temp_user_info_arr[ 'user_email' ]        = $wp_current_user->user_email;
			$temp_user_info_arr[ 'user_status' ]       = $wp_current_user->user_status;
			$temp_user_info_arr[ 'name' ]              = $wp_current_user->last_name . ' ' .$wp_current_user->first_name;
			// user_meta
			$wp_user_meta = get_user_meta( $wp_current_user->ID );
			if( $meta_keys === 'all' ) {
				$temp_user_info_arr = array_merge( $temp_user_info_arr, $wp_user_meta );
			} else {
				foreach( $wp_user_meta as $k => $v ) {
					if( in_array( $k, $meta_keys ) )
					$temp_user_info_arr[ $k ] = $v;
				}
			}
		}

		return $temp_user_info_arr;
	}
}