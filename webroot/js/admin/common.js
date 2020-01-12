function addPreClassToCss(css, preClass) {
    var css = preClass + " " + css;
    css = css.split("}").join("} " + preClass + " ");
    //最後尾のpreClassを削除
    css = css.replace(new RegExp(preClass + "$"), "");
    return css;
}
