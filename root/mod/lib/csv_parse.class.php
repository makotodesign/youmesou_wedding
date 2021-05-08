<?php
/**************************************************************************
 *
 * csv_parse.class
 * 		CSVパースクラス
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.1
 *
 * @history
 * 		2011-05-16 公開用に加筆
 * 		2011-10-23 res_arr_csv_add_fields メソッド追加
 * 		2013-10-03 res_arr_csv_add_fields に オプションARG追加
 * 		----------------------
 * 		2015-03-13 php5.3に対応  [ver4.2.1]
 * 		2015-04-14 文字列対応 全体の記述変更  [ver5.1.1]
 * 		2016-05-12 type:fieldname keyの行数指定を実際の行番号に調整  [ver5.1.2]
 * 		2016-06-07 type:num $title_row_num の値を反映N [5.1.3]
 * 		2017-04-25 type:fieldname $title_row_num ,$key_row_num のdef値を反映N [5.1.4]
 * 		2018-07-24 https 自己署名の場合のfile_get_contentsにオプション付与 N [12.1.1]
 * 		2018-10-31 csvの文字コードを判定した上で文字コード置換を行うように設定 N [12.2.1]
 * 		2019-03-20 csvの文字コードを日本語に限定 [13.1.1]
 * 		2019-04-24 1行の文字数を2000に設定 [13.2.1]
 * 		2020-05-24 fieldname のpublic設定追加 [16.1.1]
 * 		----------------------
 * 		2021-05-08 ファイル名をcsvparse から csv_parse に変更 [18.1.1]
 *
 * *************************************************************************/

class csv_parse {

	public $debug_report;

	public $arr_csv;
	public $arr_type = 'fieldname';
	public $set_keys = [];

	### constructor

	function __construct() {
	}

	### public

	/* CSV > 配列
		// arg
			$fpath             CSVファイルパス
			$csv_total_fields  CSVの読み込み列数
			$type              配列変換時タイプ選択（key：数値||フィールド名）
			$title_row_num     読み込まない行 ※ 数値タイプでは無視
			$key_row           配列変換時のフィールド名を指定する行
	 */
	public function result_array( $fpath, $csv_total_fields, $type = 'fieldname', $title_row_num = 1, $key_row = 1 ) {

		$this->csv_base_parse( $fpath, $csv_total_fields );
		$this->arr_type = $type;
		$arr = $this->arr_csv;
		if( $type == 'num' ) {
			for( $i = 0; $i < $title_row_num; $i++ ) {
				array_shift( $arr );
			}
			return $arr;
		} else {
			$temp_arr = [];
			$keys = $this->set_keys ? $this->set_keys : $arr[ $key_row - 1 ];
			for( $i = $title_row_num; $i < count( $arr ); $i++ ) {
				for( $ii = 0; $ii < count( $keys ); $ii++ ) {
					$temp_arr[ $i ][ $keys[ $ii ] ] = $arr[ $i ][ $ii ];
				}
			}
			return array_values( $temp_arr );
		}
	}

	public function disp_check_table ( $arr = [], $tb = "\t\t" ) {

		$tag = '';
		$tag .= $tb . "" . '<table class="table">' . "\n";
		$cnt = 0;
		if( is_array( $arr ) ) {
			foreach( $arr as $line ) {
				$tag .= $tb . "\t" . '<tr>' . "\n";
				if( is_array( $line ) ) {
					foreach( $line as $v ) {
						if( $cnt === 0 && $this->arr_type === 'fieldname' ) {
							$tag .= $tb . "\t\t" . '<th>' . nl2br( $v, false ) . '</th>' . "\n";
						} else {
							$tag .= $tb . "\t\t" . '<td>' . nl2br( $v, false ) . '</td>' . "\n";
						}
					}
				}
				$tag .= $tb . "\t" . '</tr>' . "\n";
				$cnt++;
			}
		}
		$tag .= $tb . "" . '</table>' . "\n";
		return $tag;
	}

	### module

	/* base parse */
	private function csv_base_parse( $fpath, $csv_total_fields ) {

		$file_contents        = file_get_contents( $fpath );
		$file_contents_encode = mb_detect_encoding( file_get_contents( $fpath ) );

		if( $file_contents ) {
			$buffer = mb_convert_encoding( file_get_contents( $fpath ), 'UTF-8', 'ASCII, JIS, UTF-8, SJIS' );
		} elseif( strpos( $fpath, 'https' ) !== false ) {
			$options[ 'ssl' ][ 'verify_peer' ]      = false;
			$options[ 'ssl' ][ 'verify_peer_name' ] = false;
			$buffer = mb_convert_encoding( file_get_contents( $fpath, false, stream_context_create( $options ) ), 'UTF-8', 'ASCII, JIS, UTF-8, SJIS' );
		}

		$buffer = preg_replace( "\r\n|\r|\n", "\n", $buffer );
		$file_csv = tmpfile();
		fwrite( $file_csv, $buffer );
		rewind( $file_csv );

		$cnt = 0; // CSVデータを多次元配列に格納
		while( $csv = $this->fgetcsv_reg( $file_csv, 2000 ) ) {
			for( $i = 0; $i < $csv_total_fields; $i++ ) {
				$arr_csv[ $cnt ][ $i ] = isset( $csv[ $i ] ) ? $csv[ $i ] : '';
			}
			$cnt++;
		}
		$arr_csv = $this->delate_empty_row( $arr_csv );
		$this->arr_csv = $arr_csv;
	}

	/* fgetcsv関数別途設定（ロケール設定を考慮した文字化け対策）*/
	private function fgetcsv_reg ( $file_csv, $length = null, $d = ',', $e = '"' ) {

		$d = preg_quote( $d );
		$e = preg_quote( $e );
		$line = '';
		$eof = false;
		while ( $eof != true ) {
			$line .= ( $length ) ? fgets( $file_csv ) : fgets( $file_csv, $length );
			$itemcnt = preg_match_all( '/' . $e . '/', $line, $temp_arr );
			if ( $itemcnt % 2 == 0 ) {
				$eof = true;
			}
		}
		$csv_line = preg_replace( '/(?:\\r\\n|[\\r\\n])?$/', $d, trim( $line ) );
		$csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
		preg_match_all( $csv_pattern, $csv_line, $csv_matches );
		$csv_data = $csv_matches[ 1 ];
		for( $i = 0; $i < count( $csv_data ); $i++ ) {
			$csv_data[ $i ] = preg_replace( '/^' . $e . '(.*)' . $e . '$/s', '$1', $csv_data[ $i ] );
			$csv_data[ $i ] = str_replace( ( $e . $e ), $e, $csv_data[ $i ] );
		}
		return empty( $line ) ? [] : $csv_data;
	}

	/* 空白行の削除 */
	private function delate_empty_row( $arr = [] ) {

		$temp_arr = [];
		for( $i = 0; $i < count( $arr ); $i++ ) {
			$str = '';
			foreach( $arr[ $i ] as $v) {
				$str .= $v;
			}
			if( $str ) {
				array_push( $temp_arr, $arr[ $i ] );
			}
		}
		return array_values( $temp_arr );
	}
}

