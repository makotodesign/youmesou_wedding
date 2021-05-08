<?php
/*******************************************************************************************

	GD画像リサイズクラス

	@package	resize_image
	@author		oldoffice.com
	@since		PHP 5.*
	@ver		2.2.2

	@memo
		2010-12-14 クラス作成
		2011-02-14 RETURN出力に変更
		2011-02-22 W,Hのどちらかを「*」でauto指定
		2011-02-22 リサイズタイプを選択できる機能を追加
		2011-02-22 引数が適切でない場合の処理追加
		2011-03-28 http～のファイルに対応
		2011-04-25 引数の値を再設定
		2011-04-26 WordPressプラグインに対応
		2011-05-04 絶対パスにも対応
		2011-09-28 処理付加の軽減
		2011-10-07 ImageCopyResampled時のxy座標不具合修正
		2012-02-07 画像のリサイズ方法に「resizefit」を追加
		2012-04-20 画像の余白白塗り処理を追加
		2012-05-30 画像のリサイズ方法に「allocation」を追加
		2012-08-29 画像のリサイズ方法に「allocation」を「allocationfit」に変更
		2012-08-29 画像のリサイズ方法に「allocation」を新仕様にて追加
		2012-10-10 リサイズ画像が存在した場合にも画像サイズを呼び出せるように変更 N
		2013-03-19 コンストラクタ内 $root_realpath をバーチャルドメインに対応

*******************************************************************************************/

class resize_image {

	public $debug_report;

	public $new_file_path;
	public $new_width;           // 生成された画像サイズ
	public $new_height;

	private $img_fname_arr;      // [.]で分割されたファイル名-配列
	private $img_ext;
	private $temp_image;
	private $create_img_width;   // 指定した画像サイズ
	private $create_img_height;
	private $temp_image_width;   // アップされた画像サイズ
	private $temp_image_height;
	private $img_create;
	private $src_file_realpath;
	private $new_file_realpath;

	protected $root_realpath;
	protected $url;

	### constructor

	function __construct() {

		$this->url           = 'http://' . $_SERVER[ 'SERVER_NAME' ];  //末尾のスラッシュなし
		$script_name         = $_SERVER[ 'SCRIPT_NAME' ];
		$script_filename     = $_SERVER[ 'SCRIPT_FILENAME' ];
		$this->root_realpath = substr( $script_filename, 0, strlen( $script_filename ) - strlen( $script_name ) );
	}

/*----------------------------------------------------------

	GD画像リサイズ

	引数01 : src画像ファイルパス
	引数02 : 生成画像のwidth ※自動 = "auto"
	引数03 : 生成画像のheight ※自動 = "auto"
	引数04 : リサイズタイプ：
	   fit           => 縮小＆トリミング ※default
	   resize        => サイズ内に縮小   ※縮小は縦横枠内に収まる／拡大なし
	   wfit          => 横幅のみ縮小     ※縦幅自動
	   hfit          => 縦幅のみ縮小     ※横幅自動
	   resizefit     => サイズ内に縮小   ※拡大有り（resizeで指定サイズより小さい場合のみ）
	   allocation    => 指定サイズに縮小 ※不足部分を塗りたす／塗りたし色は白
	   allocationfit => 指定サイズに縮小 ※不足部分を塗りたす／塗りたし色は白／拡大有り

	fpath:***.jpg(URL可), width:200, height:300
	「***-200x300.jpg」ファイル名があればそのまま表示。
	なければリサイズ＆トリミング画像を作成の上表示。

-----------------------------------------------------------*/

	public function disp_resize_img_path( $src_img_path, $create_img_width, $create_img_height, $type = 'fit' ) {

		/* realpath変換 */
		if( substr( $src_img_path, 0 ,1 ) == "/" ) {
			$src_file_realpath = $this->root_realpath . $src_img_path;
		} else {
			$src_file_realpath = str_replace( $this->url, $this->root_realpath, $src_img_path );
		}

		/* ファイルの存在チェック */
		if( !is_file( $src_file_realpath ) ) {
			return 'noimage';
			} else {
			// 画像ファイル名分割
			$img_fname_arr = explode( ".", $src_img_path );
			// 拡張子を除いた画像ファイル名（ファイル名に「.」「.jpg」が入っている時にも対応）
			$img_first_name = $img_fname_arr[0];
			for( $i = 1; $i < ( count( $img_fname_arr ) - 1 ); $i++ ) {
				$img_first_name .= ".".$img_fname_arr[$i];
			}
			// 画像拡張子（小文字）
			$img_ext = strtolower( $img_fname_arr[ count( $img_fname_arr ) - 1 ] );
			switch( $type ) {
				case 'fit':
					$create_img_width = intval( $create_img_width );
					$create_img_height = intval( $create_img_height );
					$img_create = ( is_numeric( $create_img_width ) && is_numeric( $create_img_height ) ) ? 'on' : 'off';
					break;
				case 'resize':
					$create_img_width = intval( $create_img_width );
					$create_img_height = intval( $create_img_height );
					$img_create = ( is_numeric( $create_img_width ) && is_numeric( $create_img_height ) ) ? 'on' : 'off';
					break;
				case 'wfit':
					$create_img_width = intval( $create_img_width );
					$create_img_height = 'auto';
					$img_create = ( is_numeric( $create_img_width ) ) ? 'on' : 'off';
					break;
				case 'hfit':
					$create_img_width = 'auto';
					$create_img_height = intval( $create_img_height );
					$img_create = ( is_numeric( $create_img_height ) ) ? 'on' : 'off';
					break;
				case 'resizefit':
					$create_img_width = intval( $create_img_width );
					$create_img_height = intval( $create_img_height );
					$img_create = ( is_numeric( $create_img_width ) && is_numeric( $create_img_height ) ) ? 'on' : 'off';
					break;
				case 'allocationfit':
					$create_img_width = intval( $create_img_width );
					$create_img_height = intval( $create_img_height );
					$img_create = ( is_numeric( $create_img_width ) && is_numeric( $create_img_height ) ) ? 'on' : 'off';
					break;
				case 'allocation':
					$create_img_width = intval( $create_img_width );
					$create_img_height = intval( $create_img_height );
					$img_create = ( is_numeric( $create_img_width ) && is_numeric( $create_img_height ) ) ? 'on' : 'off';
					break;
				default:
					$img_create = 'off';
			}
			// 生成画像パス
			if( $img_create == 'on' ) {
				$new_file_path = $img_first_name.'_'.$type.'_'.$create_img_width.'_'.$create_img_height.'.'.$img_ext; //生成される画像ファイル名
			} else {
				$new_file_path = $src_img_path; //生成されなかった時は元画像
			}


		/* 画像処理 */

			if( is_file( $new_file_path ) ) {
				$arr = getimagesize( $new_file_path );
				$this->new_width  = $arr[ 0 ]; //横幅（px）
				$this->new_height = $arr[ 1 ]; //縦幅（px）
				return $new_file_path;
			} elseif( !is_file( $new_file_path ) && ( $img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'gif' || $img_ext == 'png' ) ) {

				//拡張子により処理を分岐
				switch( $img_ext ) {
					case 'jpg':
						$temp_image = ImageCreateFromJPEG( $src_file_realpath );
						break;
					case 'jpeg':
						$temp_image = ImageCreateFromJPEG( $src_file_realpath );
						break;
					case 'gif':
						$temp_image = ImageCreateFromGIF( $src_file_realpath );
						break;
					case 'png':
						$temp_image = ImageCreateFromPNG( $src_file_realpath );
						break;
				}

				// アップされた画像のサイズ
				$temp_image_width  = ImageSX( $temp_image ); //横幅（px）
				$temp_image_height = ImageSY( $temp_image ); //縦幅（px）


				/*- fit -*/
				if( $type == 'fit' ) {

					// 対象画像-case横長
					if( ( $temp_image_width / $temp_image_height ) > ( $create_img_width / $create_img_height ) ) {
						$this->new_height = $create_img_height;
						$rate             = $this->new_height / $temp_image_height; //縦横比
						$this->new_width  = $rate * $temp_image_width;
						$x                = ( $create_img_width - $this->new_width ) / 2;
						$y                = 0;

					// 対象画像-case縦長
					} else {
						$this->new_width  = $create_img_width;
						$rate             = $this->new_width / $temp_image_width; //縦横比
						$this->new_height = $rate * $temp_image_height;
						$x = 0;
						$y = ( $create_img_height - $this->new_height ) / 2;
					}

					$new_image = ImageCreateTrueColor( $create_img_width, $create_img_height ); //空画像

				/*- resize -*/
				} elseif ( $type == 'resize' ) {

					// 対象画像-サイズが収まる場合
					if( ( $temp_image_width < $create_img_width ) && ( $temp_image_height < $create_img_height ) ) {
						$this->new_width  = $temp_image_width;
						$this->new_height = $temp_image_height;
						$x = 0;
						$y = 0;

					// 対象画像-case横長
					} elseif( ( $temp_image_width / $temp_image_height ) > ( $create_img_width / $create_img_height ) ) {
						$this->new_width  = $create_img_width;
						$rate             = $this->new_width / $temp_image_width; //縦横比
						$this->new_height = $rate * $temp_image_height;
						$x = 0;
						$y = 0;

					// 対象画像-case縦長
					} else {
						$this->new_height = $create_img_height;
						$rate             = $this->new_height / $temp_image_height; //縦横比
						$this->new_width  = $rate * $temp_image_width;
						$x = 0;
						$y = 0;
					}

					$new_image = ImageCreateTrueColor( $this->new_width, $this->new_height ); //空画像

				/*- wfit -*/
				} elseif ( $type == 'wfit' ) {

					// 対象画像 : create_img_widthは数値
					$this->new_width  = $create_img_width;
					$rate             = $this->new_width / $temp_image_width; //縦横比
					$this->new_height = $rate * $temp_image_height;
					$x = 0;
					$y = 0;

					$new_image = ImageCreateTrueColor( $this->new_width, $this->new_height ); //空画像

				/*- hfit -*/
				} elseif ( $type == 'hfit' ) {

					// 対象画像 : create_img_heightは数値
					$this->new_height = $create_img_height;
					$rate             = $this->new_height / $temp_image_height; //縦横比
					$this->new_width  = $rate * $temp_image_width;
					$x = 0;
					$y = 0;
					$new_image = ImageCreateTrueColor( $this->new_width, $this->new_height ); //空画像

				/*- resizefit -*/
				} elseif ( $type == 'resizefit' ) {

					// 対象画像-case横長
					if( ( $temp_image_width / $temp_image_height ) > ( $create_img_width / $create_img_height ) ) {
						$this->new_width  = $create_img_width;
						$rate             = $this->new_width / $temp_image_width; //縦横比
						$this->new_height = $rate * $temp_image_height;
						$x = 0;
						$y = 0;

					// 対象画像-case縦長
					} else {
						$this->new_height = $create_img_height;
						$rate             = $this->new_height / $temp_image_height; //縦横比
						$this->new_width  = $rate * $temp_image_width;
						$x = 0;
						$y = 0;
					}

					$new_image = ImageCreateTrueColor( $this->new_width, $this->new_height ); //空画像

				/*- allocationfit -*/
				} elseif ( $type == 'allocationfit' ) {

					// 対象画像-case横長
					if( ( $temp_image_width / $temp_image_height ) > ( $create_img_width / $create_img_height ) ) {
						$this->new_width  = $create_img_width;
						$rate             = $this->new_width / $temp_image_width; //縦横比
						$this->new_height = $rate * $temp_image_height;
						$x = 0;
						$y = ( $create_img_height - $this->new_height ) / 2;

					// 対象画像-case縦長
					} else {
						$this->new_height = $create_img_height;
						$rate             = $this->new_height / $temp_image_height; //縦横比
						$this->new_width  = $rate * $temp_image_width;
						$x = ( $create_img_width - $this->new_width ) / 2;
						$y = 0;
					}

					$new_image = ImageCreateTrueColor( $create_img_width, $create_img_height ); //空画像

				/*- allocation -*/
				} elseif ( $type == 'allocation' ) {

					// 対象画像-サイズが収まる場合
					if( ( $temp_image_width < $create_img_width ) && ( $temp_image_height < $create_img_height ) ) {
						$this->new_width  = $temp_image_width;
						$this->new_height = $temp_image_height;
						$x = ( $create_img_width - $temp_image_width ) / 2;
						$y = ( $create_img_height - $temp_image_height ) / 2;

					// 対象画像-case横長
					} elseif( ( $temp_image_width / $temp_image_height ) > ( $create_img_width / $create_img_height ) ) {
						$this->new_width  = $create_img_width;
						$rate             = $this->new_width / $temp_image_width; //縦横比
						$this->new_height = $rate * $temp_image_height;
						$x = 0;
						$y = ( $create_img_height - $this->new_height ) / 2;

					// 対象画像-case縦長
					} else {
						$this->new_height = $create_img_height;
						$rate             = $this->new_height / $temp_image_height; //縦横比
						$this->new_width  = $rate * $temp_image_width;
						$x = ( $create_img_width - $this->new_width ) / 2;
						$y = 0;
					}

					$new_image = ImageCreateTrueColor( $create_img_width, $create_img_height ); //空画像
				}

				$bg = imagecolorallocate( $new_image ,0xFF, 0xFF, 0xFF ); // 元画像から透過色を取得する
				imagefill( $new_image, 0, 0, $bg );                       // その色でキャンバスを塗りつぶす
				imagecolortransparent( $new_image, $bg );                 // 塗りつぶした色を透過色として指定する

				ImageCopyResampled( $new_image, $temp_image, $x, $y, 0, 0, $this->new_width, $this->new_height, $temp_image_width, $temp_image_height );

				// realpathで画像生成
				if( substr( $new_file_path, 0 ,1 ) == "/" ) {
					$new_file_realpath = $this->root_realpath . $new_file_path;
				} else {
					$new_file_realpath = str_replace( $this->url, $this->root_realpath, $new_file_path );
				}
				ImageJPEG( $new_image, $new_file_realpath, 100 ); // 3rd_param:quality(0-100)

				imagedestroy( $temp_image );
				imagedestroy( $new_image );

				return $new_file_path;
			} else {
				return $new_file_path;
			}
		}
	}
}

