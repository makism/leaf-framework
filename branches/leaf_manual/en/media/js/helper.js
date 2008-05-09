
function toggle_expand(src, target)
{
    t = document.getElementById(target)
    style = t.style.display

    if (style == "none") {
        t.style.display = "block"
        src.src = "media/images/icons/16x16/list-remove.png"
    } else {
        t.style.display = "none"
        src.src = "media/images/icons/16x16/list-add.png"
    }
}

