import gulp from "gulp";
import htmltidy from "gulp-htmltidy";

export function html() {
  return gulp
    .src("index.html")
    .pipe(htmltidy())
    .pipe(gulp.dest("build"));
}

export default html;
