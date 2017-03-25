var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    browserSync = require('browser-sync'), // Подключаем Browser Sync
    concat      = require('gulp-concat'), // Подключаем gulp-concat (для конкатенации файлов)
    uglify      = require('gulp-uglifyjs'), // Подключаем gulp-uglifyjs (для сжатия JS)
    cssnano     = require('gulp-cssnano'), // Подключаем пакет для минификации CSS
    rename      = require('gulp-rename'), // Подключаем библиотеку для переименования файлов
    del         = require('del'), // Подключаем библиотеку для удаления файлов и папок
    imagemin    = require('gulp-imagemin'), // Подключаем библиотеку для работы с изображениями
    pngquant    = require('imagemin-pngquant'), // Подключаем библиотеку для работы с png
    cache       = require('gulp-cache'), // Подключаем библиотеку кеширования
    autoprefixer = require('gulp-autoprefixer');// Подключаем библиотеку для автоматического добавления префиксов




gulp.task('sass', function() {
    return gulp.src('sass/**/*.+(scss|sass)')
        .pipe(sass())
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: true })) // Создаем префиксы
        .pipe(gulp.dest('style'))
        .pipe(browserSync.reload({stream: true}));// Обновляем CSS на странице при изменении
});

gulp.task('browser-sync', function() { // Создаем таск browser-sync
    browserSync.init({
        files: ['./**/*.php'],
        proxy: 'http://www.skokov/'
    });
});

gulp.task('scripts', function() {
    return gulp.src([ // Берем все необходимые библиотеки
        'libs/jquery/dist/jquery.min.js', // Берем jQuery
        //'libs/magnific-popup/dist/jquery.magnific-popup.min.js', // Берем Magnific Popup
        'libs/bootstrap/dist/js/bootstrap.min.js', // Бутстрап
       // 'libs/slick/slick.min.js', // Слайдер
        //'libs/masonry.pkgd.min.js' // Masonry
    ])
        .pipe(concat('libs.min.js')) // Собираем их в кучу в новом файле libs.min.js
        .pipe(uglify()) // Сжимаем JS файл
        .pipe(gulp.dest('js')); // Выгружаем в папку js
});

gulp.task('css-libs', ['sass'], function() {
    return gulp.src('style/libs.css') // Выбираем файл для минификации
        .pipe(cssnano()) // Сжимаем
        .pipe(rename({suffix: '.min'})) // Добавляем суффикс .min
        .pipe(gulp.dest('style')); // Выгружаем в папку css
});

// gulp.task('img', function() {
//     return gulp.src('img/**/*') // Берем все изображения
//         .pipe(cache(imagemin({  // Сжимаем их с наилучшими настройками с учетом кеширования
//             interlaced: true,
//             progressive: true,
//             svgoPlugins: [{removeViewBox: false}],
//             use: [pngquant()]
//         })))
//         .pipe(gulp.dest('img')); //
// });

gulp.task('watch', ['browser-sync','css-libs','scripts', 'sass'], function () {
    gulp.watch('sass/**/*.+(scss|sass)', ['sass']);
    gulp.watch('./**/*.php', browserSync.reload); // Наблюдение за HTML файлами в корне проекта
    gulp.watch('js/**/*.js', browserSync.reload); // Наблюдение за JS файлами в папке js

});



gulp.task('default', ['watch']);



