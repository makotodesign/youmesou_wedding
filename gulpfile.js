/*=======================================================

    gulpfile.js
    @version
        gulp : 4.0

========================================================*/

/*------------------------------------------------
	module
------------------------------------------------*/

const gulp = require('gulp');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const flexBugsFixes = require('postcss-flexbugs-fixes');
const cssWring = require('csswring');
const imagemin = require('gulp-imagemin');
const mozjpeg = require('imagemin-mozjpeg');
const pngquant = require('imagemin-pngquant');
const svgo = require('imagemin-svgo');
const gifsicle = require('imagemin-gifsicle');
const changed = require('gulp-changed');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const browserSync = require('browser-sync').create();
const Webp = require('gulp-webp');
const rename = require('gulp-rename');

/*------------------------------------------------
	setting
------------------------------------------------*/

const project = 'root';

const paths = {
	// scss > css
	scssPath: './_sass/**/*.scss',
	cssDir: './' + project + '/css/',
	// js > minify
	// prettier-ignore
	jsSrcPaths: [
		'./_js_src/common/oo_lib.js',
		'./_js_src/common/base.js'
	],
	//jsSrcPaths: ['./_js_src/common/oo_lib.js', './_js_src/common/base.js'],
	jsDir: './' + project + '/js/common/',
	// images > minify
	imgSrcPath: './_images_src/**/*',
	imgDir: './' + project + '/images',
	//browser-sync
	bsPath: './' + project + '/**/*.php'
};

const server = {
	open: 'external',
	proxy: '', //'https://xxx.sakura.ne.jp/official01/',
	watchOptions: {
		debounceDelay: 1000 //1秒間、タスクの再実行を抑制
	}
};

/*------------------------------------------------
	option
------------------------------------------------*/

// postcss
const postcssOption = [flexBugsFixes, autoprefixer({ grid: true }), cssWring];

/*------------------------------------------------
	task
------------------------------------------------*/

// scss
gulp.task('sass', function () {
	return gulp
		.src([paths.scssPath], { sourcemaps: true })
		.pipe(sass())
		.pipe(postcss(postcssOption))
		.pipe(gulp.dest(paths.cssDir, { sourcemaps: './sourcemaps/' }));
});

// js : minify
gulp.task('jsminify', function () {
	return gulp.src(paths.jsSrcPaths).pipe(concat('base.min.js')).pipe(uglify()).pipe(gulp.dest(paths.jsDir));
});

// images : minify
gulp.task('imagemin', function () {
	return gulp
		.src([paths.imgSrcPath])
		.pipe(changed(paths.imgDir))
		.pipe(imagemin([gifsicle(), mozjpeg({ quality: 80 }), pngquant(), svgo()]))
		.pipe(gulp.dest(paths.imgDir));
});

// images : wepp
gulp.task('imagewepp', function () {
	return gulp
		.src([paths.imgSrcPath])
		.pipe(changed(paths.imgDir))
		.pipe(
			rename((path) => {
				path.basename += path.extname;
			})
		)
		.pipe(Webp())
		.pipe(gulp.dest(paths.imgDir));
});

// browser open
gulp.task('browser-sync', () => {
	if (server.proxy) {
		browserSync.init(server);
	}
});

// browser reload
gulp.task('reload', (done) => {
	if (server.proxy) {
		browserSync.reload();
		done();
	}
});

/*------------------------------------------------
    [ default ]
------------------------------------------------*/

gulp.watch(paths.scssPath, gulp.series('sass'));
gulp.watch(paths.jsSrcPaths, gulp.series('jsminify'));
gulp.watch(paths.imgSrcPath, gulp.series('imagemin'));
gulp.watch(paths.imgSrcPath, gulp.series('imagewepp'));
if (server.proxy) {
	gulp.watch(paths.bsPath, gulp.series('reload'));
	gulp.watch(paths.cssDir, gulp.series('reload'));
	gulp.task('default', gulp.series('sass', 'browser-sync'));
} else {
	//gulp.task('default', gulp.series('sass', 'imagemin', 'imagewepp'));
	gulp.task('default', gulp.series('sass'));
}
