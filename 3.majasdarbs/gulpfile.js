import gulp from "gulp";
import htmltidy from "gulp-htmltidy";
import autoprefixer from "gulp-autoprefixer";
import csslint from "gulp-csslint";
import babel from "gulp-babel";
import jshint from "gulp-jshint";


export function html() {
  return gulp
    .src("index.html")
    .pipe(htmltidy())
    .pipe(gulp.dest("build"));
}

export function css() {
  return gulp
    .src("src/style.css")
    .pipe(csslint())
    .pipe(csslint.formatter("compact"))
    .pipe(
      autoprefixer({
        cascade: false,
      }),
    )
    .pipe(gulp.dest("build"));
}

export function js() {
  return gulp
    .src("src/main.js")
    .pipe(jshint())
    .pipe(jshint.reporter("default"))
    .pipe(
      babel({
        presets: ["@babel/env"],
      }),
    )
    .pipe(gulp.dest("build"));
}


export default gulp.series(html, css, js);
