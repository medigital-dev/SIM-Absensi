window.setTimeout("waktu()", 1000);

function waktu() {
    var waktu = new Date();
    setTimeout("waktu()", 1000);

    let h = waktu.getHours();
    let m = waktu.getMinutes();
    let s = waktu.getSeconds();

    m = puluhan(m);
    s = puluhan(s);

    document.getElementById("jam").innerHTML = h + " : " + m + " : " + s;
}

function puluhan(i) {
    if (i < 10) {i = "0" + i};
  return i;
}