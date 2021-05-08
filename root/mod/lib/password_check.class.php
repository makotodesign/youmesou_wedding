<?php
/***********************************************************

	パスワードチェッククラス

	@package	password_check.class
	@author		oldoffice.com
	@since		PHP 5.3
	@ver		1.1.1

	@memo
		2015-05-25 新規作成N

***********************************************************/

class password_check {

	private $password;
	private $issued_password_arr;
	private $id_exist_issued;
	private $id_exist_input;

	### constructor

	function __construct( $issued_password_arr ) {

		$this->issued_password_arr = ( is_array( $issued_password_arr ) ) ? $issued_password_arr : [];
		// id_exist_issued
		$check_key_arr = array_keys( $issued_password_arr[ 0 ] );
		$this->id_exist_issued = ( in_array( 'id', $check_key_arr ) ) ? true : false ;
	}

	### public

	/* パスワード確認 */

	public function password_comp( $password, $id = false ) {

		$arr = $this->issued_password_arr;
		if( $id ) {
			$this->id_exist_input = true;
		}
		$result = false;
		if( $this->id_exist_issued || $this->id_exist_input ) {
			for( $i = 0; $i < count( $arr ); $i++ ) {
				if( isset( $arr[ 'password' ] ) && isset( $arr[ 'id' ] ) && $arr[ 'password' ] === $password && $arr[ 'id' ] === $id ) {
					$result = true;
					break;
				}
			}
		} else {
			for( $i = 0; $i < count( $arr ); $i++ ) {
				if( isset( $arr[ 'password' ] ) && $arr[ 'password' ] === $password ) {
					$result = true;
					break;
				}
			}
		}
		return $result;
	}
}

