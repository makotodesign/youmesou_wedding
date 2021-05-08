<?php
/*************************************************************************

	ブレインメール連動クラス

	@package	blaynmail.class
	@author		oldoffice.com
	@since		PHP 5
	@ver		1.1.2

	2017-01-20	N 作成[ 1.1.1 ]
	2017-01-26	N PEAR利用時を統合[ 1.1.2 ]

**************************************************************************/

/*** blaynmail ( for : wp ) ***/
class blaynmail {

	public $debug_report = '';

	public $results_message;
	public $results_bool;
	public $results_blaynmail_id;
	public $results_mail;
	public $message_text = [
		'add_success'           => 'メール配信システムに登録されました。',
		'add_error'             => 'メール配信システムに登録できませんでした。',
		'delete_success'        => '配信メールが解除されました。',
		'delete_error'          => '配信メールが解除されませんでした。',
		'update_success'        => '配信メールが更新されました。',
		'update_error'          => '配信メールが更新されませんでした。',
		'mail_registered_error' => '<br>既に登録されているアドレスです。',
		'entry_error'           => '<br>ユーザー情報の初期登録内容に問題があります。<br>システム管理者に連絡してください。',
		'unknown_error'         => 'エラーが起こりました。<br>システム管理者に連絡してください。'
	];

	private $access_token;

    const CONNECTURLBASE = 'https://api.bme.jp/rest/1.0/';

	### constructor

	function __construct() {

		include_once ABSPATH . WPINC . '/class-http.php';
		/* wp_http */
        $this->http = new WP_Http();
    }

	### function

	/* login */
	public function login( $blaynmail_connect_array ) {

		$url = '/authenticate/login';
		$opt = [
			'body' => [
				'username' => $blaynmail_connect_array[ 'username' ],
				'password' => $blaynmail_connect_array[ 'password' ],
				'api_key'  => $blaynmail_connect_array[ 'api_key' ],
				'format'   => 'json'
			]
		];
		$res = $this->post_blaynmail( $url, $opt );
		if( ! $res ) {
			return false;
		}
		$this->access_token = $res[ 'accessToken' ];
		return true;
	}

	/* logout */
    public function logout() {

		if ( ! $this->access_token ) return;
		$url = 'authenticate/logout';
		$res = $this->get_blaynmail( $url );
		if( is_wp_error( $res ) ) {
			return false;
		} else {
			$this->access_token = null;
			return true;
		}
	}

	/* add */
	public function add( $add_array ) {

		// url
        $url = '/contact/detail/create';
		// request : base
        $param = array(
            'body' => array(
                'access_token' => $this->access_token,
                'format'       => 'json',
                'status'       => '配信中',
                'error'        => '0',
                'public'       => true
            )
        );
		// request : data_user
		foreach( $add_array as $k => $v ) {
			$param[ 'body' ][ $k ] = $v;
		}
		// run_request
		$res_array = $this->post_blaynmail( $url, $param );
		// results
		if( isset( $res_array[ 'error' ][ 'message' ] ) ) {
			$this->results_message      = $this->message_text[ 'add_error' ];
			if( $res_array[ 'error' ][ 'message' ] == 'Failure_Has already been registered' ) {
				$this->results_message .= $this->message_text[ 'mail_registered_error' ];
			} elseif( strpos( $res_array[ 'error' ][ 'message' ], 'Failure_Required fields' ) ) {
				$this->results_message .= $this->message_text[ 'entry_error' ];
			} else {
				$this->results_message .= $res_array[ 'error' ][ 'message' ];
			}
			$this->results_bool         = false;
		} elseif( isset( $res_array[ 'contactID' ] ) ) {
			$this->results_message      = $this->message_text[ 'add_success' ];
			$this->results_bool         = true;
			$this->results_blaynmail_id = $res_array[ 'contactID' ];
		} else {
			$this->results_message      = $this->message_text[ 'unknown_error' ];
			$this->results_bool         = false;
		}
	}

	/* delete */
	public function delete( $blaynmail_id ) {

		// url
        $url = '/contact/list/delete';
		// request : base
        $param = array(
            'body' => array(
                'access_token' => $this->access_token,
                'format'       => 'json'
            )
        );
		// request : data_user
		$param[ 'body' ][ 'contactIDs' ] = $blaynmail_id;
		// run_request
		$res_array = $this->post_blaynmail( $url, $param );
		// results
		if( isset( $res_array[ 'failure' ] ) && $res_array[ 'failure' ] ) {
			$this->results_message      = $this->message_text[ 'delete_error' ];
			$this->results_bool         = false;
		} elseif( isset( $res_array[ 'success' ] ) && $res_array[ 'success' ] ) {
			$this->results_message      = $this->message_text[ 'delete_success' ];
			$this->results_bool         = true;
			$this->results_blaynmail_id = $res_array[ 'success' ];
		} else {
			$this->results_message      = $this->message_text[ 'unknown_error' ];
			$this->results_bool         = false;
		}
	}

	/* update */
	public function update( $blaynmail_id, $update_array ) {

		// url
        $url = '/contact/detail/update';
		// request : base
        $param = array(
            'body' => array(
                'access_token' => $this->access_token,
                'format'       => 'json'
            )
        );
		// request : data_user
		$param[ 'body' ][ 'contactID' ] = $blaynmail_id;
		foreach( $update_array as $k => $v ) {
			$param[ 'body' ][ $k ] = $v;
		}
		// run_request
        $res_array = $this->post_blaynmail( $url, $param );
		/*
			$update_array = [
				'c15' => $var, // user_email - def
				'c0'  => $var, // name       - def
				'c**' => $var, // **
			];
		*/
		// results
		if( isset( $res_array[ 'error' ][ 'message' ] ) ) {
			$this->results_message      = $this->message_text[ 'update_error' ];
			if( $res_array[ 'error' ][ 'message' ] == 'Failure_Has already been registered' ) {
				$this->results_message .= $this->message_text[ 'mail_registered_error' ];
			}
			$this->results_bool     = false;
		} elseif( isset( $res_array[ 'contactID' ] ) ) {
			$this->results_message      = $this->message_text[ 'update_success' ];
			$this->results_bool         = true;
			$this->results_blaynmail_id = $res_array[ 'contactID' ];
		} else {
			$this->results_message      = $this->message_text[ 'unknown_error' ];
			$this->results_bool         = false;
		}
	}

	/* search */
	public function search( $blaynmail_id ) {

		// url
		$url = '/contact/detail/search';
        $param = array(
			'contactID'    => $blaynmail_id,
			'status'       => urlencode( '配信中' ),
			'access_token' => $this->access_token
        );
        $res_array = $this->get_blaynmail( $url, $param );
		// results
		if( $res_array && isset( $res_array[ 'c15' ] ) ) {
			return $res_array[ 'c15' ];
		} else {
			return '! error_mail';
		}
	}

	### private_function

	/* get_blaynmail */
    private function get_blaynmail( $action, $url_param = [], $opt = [] ) {

		$action = trim( $action, '/' );
		$url = self::CONNECTURLBASE . $action;
		$default_param = [
			'access_token' => $this->access_token,
			'f' => 'json'
		];
		$param = array_merge( $default_param, $url_param );
		$query = http_build_query( $param );
		$url .= '?' . $query;
		$default_option = [
			'timeout'     => 30,
			'redirection' => false,
			'httpversion' => '1.0',
			'headers'     => [],
			'cookies'     => [],
			'body'        => null,
			'sslverify'   => true
		];
		$opt = array_merge( $default_option, $opt );
		$res = $this->http->get( $url, $opt );
		if( is_wp_error( $res ) ) {
			return false;
		}
		$res = json_decode( $res[ 'body' ], true );
		return $res;
    }

	/* post_blaynmail */
    private function post_blaynmail( $action, $args ) {

		$action = trim( $action, '/' );
		$url = self::CONNECTURLBASE . $action;
		$defaults = [
			'method'           => 'POST',
			'headers'          => [
				'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
			],
			'timeout'          => 30,
			'redirection'      => false,
			'httpversion'      => '1.0',
			'body'             => [],
			'cookies'          => []
		];
		$opt = array_merge( $defaults, $args );
		$res = $this->http->post( $url, $opt );
		if( is_wp_error( $res ) ) {
			return $res;
		} else {
			$res = json_decode( $res[ 'body' ], true );
		}
		return $res;
    }
}

/*** blaynmail ( not wp ) ***/
class blaynmail_with_pear {

	public $debug_report = '';

	public $results_message;
	public $results_bool;
	public $results_blaynmail_id;
	public $results_mail;

	public $message_text;

	private $connect_xml;
	private $connect_url_base = 'https://api.bme.jp/rest/1.0';

	### constructor

	function __construct( $blaynmail_connect_array ) {

		/* include : pear */
		include_once 'HTTP/Request.php';

		/* connect */
		$url = $this->connect_url_base . '/authenticate/login';
		$request = new HTTP_Request();
		$request->setURL( $url );
		$request->setMethod( HTTP_REQUEST_METHOD_POST );
		$request->addPostData( 'username', $blaynmail_connect_array[ 'username' ] );
		$request->addPostData( 'password', $blaynmail_connect_array[ 'password' ] );
		$request->addPostData( 'api_key',  $blaynmail_connect_array[ 'api_key' ] );
		$result = $request->sendRequest();
		if ( ! PEAR::isError( $result ) ) {
			$this->connect_xml = simplexml_load_string( $request->getResponseBody() );
		}

		/* message_text */
		$this->message_text = [
			'add_success'           => 'メール配信システムに登録されました。',
			'add_error'             => 'メール配信システムに登録できませんでした。',
			'delete_success'        => '配信メールが解除されました。',
			'delete_error'          => '配信メールが解除されませんでした。',
			'update_success'        => '配信メールが更新されました。',
			'update_error'          => '配信メールが更新されませんでした。',
			'mail_registered_error' => '<br>既に登録されているアドレスです。',
			'entry_error'           => '<br>初期の登録内容に未設定情報があるようです。<br>システム管理者に連絡してください。',
			'unknown_error'         => '原因不明のエラーが起こりました。<br>システム管理者に連絡してください。'
		];
	}

	### function

	/* add */
	public function add( $add_array ) {

		// url
		$url = $this->connect_url_base . '/contact/detail/create';
		// request : base
		$request = new HTTP_Request( $url, [ 'useBrackets' => false ] );
		$request->setMethod( HTTP_REQUEST_METHOD_POST );
		$request->addPostData( 'access_token', $this->connect_xml->access_token );
		$request->addPostData( 'format', 'json' );
		// request : data_const
		$request->addPostData( 'status', '配信中' );
		$request->addPostData( 'error', '0' );
		// request : data_user
		foreach( $add_array as $k => $v ) {
			$request->addPostData( $k, $v );
		}
		/*
			$update_array = [
				'c15' => $var, // user_email - def
				'c0'  => $var, // name       - def
				'c**' => $var, // **
			];
		*/
		// run_request
		$result = $request->sendRequest();
		if ( !PEAR::isError( $result ) ) {
			$res_json = $request->getResponseBody();
			$res_array = json_decode( $res_json, true );
		}
		// results
		if( isset( $res_array[ 'error' ][ 'message' ] ) ) {
			$this->results_message      = $this->message_text[ 'add_error' ];
			if( $res_array[ 'error' ][ 'message' ] == 'Failure_Has already been registered' ) {
				$this->results_message .= $this->message_text[ 'mail_registered_error' ];
			} elseif( strpos( $res_array[ 'error' ][ 'message' ], 'Failure_Required fields' ) ) {
				$this->results_message .= $this->message_text[ 'entry_error' ];
			} else {
				$this->results_message .= $res_array[ 'error' ][ 'message' ];
			}
			$this->results_bool         = false;
		} elseif( isset( $res_array[ 'contactID' ] ) ) {
			$this->results_message      = $this->message_text[ 'add_success' ];
			$this->results_bool         = true;
			$this->results_blaynmail_id = $res_array[ 'contactID' ];
		} else {
			$this->results_message      = $this->message_text[ 'unknown_error' ];
			$this->results_bool         = false;
		}
	}

	/* delete */
	public function delete( $blaynmail_id ) {

		// url
		$url = $this->connect_url_base . '/contact/list/delete';
		// request : base
		$request = new HTTP_Request( $url, [ 'useBrackets' => false ] );
		$request->setMethod( HTTP_REQUEST_METHOD_POST );
		$request->addPostData( 'access_token', $this->connect_xml->access_token );
		$request->addPostData( 'format', 'json' );
		// request : data_user
		$request->addPostData( 'contactIDs', [ $blaynmail_id ] );
		// run_request
		$result = $request->sendRequest();
		if ( !PEAR::isError( $result ) ) {
			$res_json = $request->getResponseBody();
			$res_array = json_decode( $res_json, true );
		}
		// results
		if( isset( $res_array[ 'failure' ] ) && $res_array[ 'failure' ] ) {
			$this->results_message      = $this->message_text[ 'delete_error' ];
			$this->results_bool         = false;
		} elseif( isset( $res_array[ 'success' ] ) && $res_array[ 'success' ] ) {
			$this->results_message      = $this->message_text[ 'delete_success' ];
			$this->results_bool         = true;
			$this->results_blaynmail_id = $res_array[ 'success' ];
		} else {
			$this->results_message      = $this->message_text[ 'unknown_error' ];
			$this->results_bool         = false;
		}
	}

	/* update */
	public function update( $blaynmail_id, $update_array ) {

		// url
		$url = $this->connect_url_base . '/contact/detail/update';
		// request : base
		$request = new HTTP_Request( $url, [ 'useBrackets' => false ] );
		$request->setMethod( HTTP_REQUEST_METHOD_POST );
		$request->addPostData( 'access_token', $this->connect_xml->access_token );
		$request->addPostData( 'format', 'json' );
		// request : data_id
		$request->addPostData( 'contactID', $blaynmail_id );
		// request : data_user
		foreach( $update_array as $k => $v ) {
			$request->addPostData( $k, $v );
		}
		/*
			$update_array = [
				'c15' => $var, // user_email - def
				'c0'  => $var, // name       - def
				'c**' => $var, // **
			];
		*/
		// run_request
		$result = $request->sendRequest();
		if ( !PEAR::isError( $result ) ) {
			$res_json = $request->getResponseBody();
			$res_array = json_decode( $res_json, true );
		}
		// results
		if( isset( $res_array[ 'error' ][ 'message' ] ) ) {
			$this->results_message      = $this->message_text[ 'update_error' ];
			if( $res_array[ 'error' ][ 'message' ] == 'Failure_Has already been registered' ) {
				$this->results_message .= $this->message_text[ 'mail_registered_error' ];
			}
			$this->results_bool     = false;
		} elseif( isset( $res_array[ 'contactID' ] ) ) {
			$this->results_message      = $this->message_text[ 'update_success' ];
			$this->results_bool         = true;
			$this->results_blaynmail_id = $res_array[ 'contactID' ];
		} else {
			$this->results_message      = $this->message_text[ 'unknown_error' ];
			$this->results_bool         = false;
		}
	}

	/* search */
	public function search( $blaynmail_id ) {

		// url
		$url = $this->connect_url_base . '/contact/detail/search';
		$url .= '?access_token=' . $this->connect_xml->access_token;
		$url .= '&f=json';
		$url .= '&contactID=' . $blaynmail_id;
		$url .= '&status=' . urlencode( '配信中' );

		// request : base
		$request = new HTTP_Request( $url, [ 'useBrackets' => false ] );
		$request->setMethod( HTTP_REQUEST_METHOD_GET );
		// run_request
		$result = $request->sendRequest();
		if ( !PEAR::isError( $result ) ) {
			$res_json = $request->getResponseBody();
			$res_array = json_decode( $res_json, true );
		}
		// run_request
		$result = $request->sendRequest();
		if ( !PEAR::isError( $result ) ) {
			$res_json = $request->getResponseBody();
			$res_array = json_decode( $res_json, true );
		}
		if( $res_array && isset( $res_array[ 'c15' ] ) ) {
			return $res_array[ 'c15' ];
		} else {
			return '! error_mail';
		}
	}
}

