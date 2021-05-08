<?php
/**************************************************************************
 *
 * db.class
 * 		DBクラス
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.1
 *
 * @history
 * 		2009-01-12 DB内容をHTML上に結果表示する機能を追加
 * 		2009-04-09 出力する配列のkeyをDBのFieldNameで取り出す機能を追加
 * 		2009-05-08 DB内に該当の情報がない場合の処理を追加
 * 		2013-06-04 PHP5に対応 N
 * 		----------------------
 * 		2015-03-06 セキュリティ対策を含めコード全て見直し[ver.4]
 * 		           変数名・関数名も全て一新
 * 		----------------------
 * 		2016-10-12 mysqliへの移行 N [ver.5]
 * 		2017-09-17 result_arr('record')の不具合修正 N [5.1.2]
 * 		----------------------
 * 		2018-06-13 ct11バージョンンにあわせて修正 N [11.1.1]
 * 		           ・closeを追加
 * 		           ・errorコメントにoo_を付記
 * 		----------------------
 * 		2019-03-15 ct13バージョンンにあわせて修正 N [13.1.1]
 * 		           ・pdoでの接続に切り替え
 * 		----------------------
 * 		2019-03-15 ct13バージョンンにあわせて修正 N [13.1.1]
 * 		           ・pdoでの接続に切り替え
 * 		----------------------
 * 		2020-05-25 全てにprepare適用 N [16.1.1]
 * 		           ・query()で全ての情報取得
 *
 * *************************************************************************/

class db {

	public $debug_report;

	private $pdo;
	private $close;
	private $result;

	### constructor

	function __construct( $host, $user, $password, $dbname ) {

		$dsn  = 'mysql:';
		$dsn .= 'host=' . $host . ';';
		$dsn .= 'dbname=' . $dbname . ';';
		$dsn .= 'charset=utf8';
		$opt  = [
			PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => false
		];
		try {
			$this->pdo = new PDO( $dsn, $user, $password, $opt );
		} catch( PDOException $e ) {
			echo 'oo_db_connect_error : ' . $e->getMessage();
			exit;
		}
	}

	### public function

	public function query( $sql, $sql_val = [], $type = 'array', $key = 'fieldname' ) {

		$sql_val = is_array( $sql_val ) ? $sql_val : [];
		$prepare = $this->pdo->prepare( $sql );
		$count = 1;
		foreach( $sql_val as $v ) {
			if( is_int( $v ) ) {
				$prepare->bindValue( $count, ( int )$v, PDO::PARAM_INT );
			} else {
				$prepare->bindValue( $count, $v, PDO::PARAM_STR );
			}
			$count++;
		}
		$prepare->execute();
		if( $type === 'var' ) {
			$this->result = $prepare->fetchAll( PDO::FETCH_NUM );
			return $this->result[ 0 ][ 0 ] ?? '';
		} elseif( $key === 'num' ) {
			if( $type === 'record' ) {
				return $this->result[ 0 ] ?? [];
			} else {
				return $this->result ?? [];
			}
		} else {
			$this->result = $prepare->fetchAll( PDO::FETCH_ASSOC );
			if( $type === 'record' ) {
				return $this->result[ 0 ] ?? [];
			} else {
				return $this->result ?? [];
			}
		}
	}

	public function get_results( $sql, $sql_val = [] ) {

		$this->query( $sql, $sql_val, 'array' );
	}

	public function get_row( $sql, $sql_val = [] ) {

		$this->query( $sql, $sql_val, 'record' );
	}

	public function get_var( $sql, $sql_val = [] ) {

		$this->query( $sql, $sql_val, 'var' );
	}

	public function close() {

		$this->pdo = null;
	}
}
