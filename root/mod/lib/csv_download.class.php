<?php
/**************************************************************************
 *
 * csv_download.class
 * 		CSVダウンロードクラス
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.2
 *
 * @history
 * 		2015-05-25 新規作成N(1.1.1)
 * 		2015-05-27 文字化け対策
 * 		2021-03-29 エンコード先文字コード設定 [17.1.1]
 * 		2021-05-08	調整 [18.1.1]
 * 		2021-05-22	CSVの値に配列が指定された場合 var_export 処理 [18.1.2]
 *
 * @readme
 * 		使用する場合はcontentsに移動
 *
 * *************************************************************************/

class csv_download {

	public $convert_encoding_to = 'SJIS';

	### constructor

	function __construct() {
	}

	### public

	/* CSV 生成 */
	public function csv_create( $arr, $file_name_create = false, $file_name_prefix = '', $field_line_from_key = true ) {

		$csv_filename = self::create_csv_filename( $file_name_prefix );
		header( 'Content-type: text/html; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="'. $csv_filename . '"' );
		header( 'Content-Type: application/octet-stream' );
		if( $field_line_from_key && is_array( $arr[ 0 ] ) ) {
			$field_names = array_keys( $arr[ 0 ] );
			$data = self::make_csv_line( $field_names );
			$converted_field_names = mb_convert_encoding( $data, $this->convert_encoding_to, 'UTF-8' );
			echo $converted_field_names;
		}
		foreach ( $arr as $v ) {
			$data = self::make_csv_line( $v );
			$converted_csv_data = mb_convert_encoding( $data, $this->convert_encoding_to, 'UTF-8' );
			echo $converted_csv_data;
		}
		mb_http_output( 'pass' ); //バイナリデータ誤認識&コード変換防止
	}

	### private

	/* CSV行の生成 */
	private static function make_csv_line( $values ) {

		foreach( $values as $i => $v ){
			if( is_array( $v ) ) {
				$v = var_export( $v, true );
			}
			if (
				( strpos( $v, ',' )  !== false ) ||
				( strpos( $v, '"' )  !== false ) ||
				( strpos( $v, ' ' )  !== false ) ||
				( strpos( $v, "\t" ) !== false ) ||
				( strpos( $v, "\n" ) !== false ) ||
				( strpos( $v, "\r" ) !== false )
			){
				$values[ $i ] = '"' . str_replace( '"', '""', $v ) . '"';
			}
		}
		return implode(',',$values )."\n";
	}

	/* ファイル名の自動生成 */
	private static function create_csv_filename( $prefix = '' ) {

		$filename = '';
		$filename .= ( $prefix ) ? $prefix . '_' : '';
		$filename .= date( 'Ymd_His' );
		$filename .= '.csv';
		return $filename;
	}
}

