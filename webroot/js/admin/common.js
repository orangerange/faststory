function addPreClassToCss(css, preClass) {
    var css = preClass + " " + css;
    css = css.split("}").join("} " + preClass + " ");
    //最後尾のpreClassを削除
    css = css.replace(new RegExp(preClass + "$"), "");
    return css;
}
//全角スペース除去
function deleteSpace(value) {
    value = value.split("　").join("");
    return value;
}
//文字列全体の置換
function wholeReplace(value, search, replace) {
    value = value.split(search).join(replace);
    return value;
}

