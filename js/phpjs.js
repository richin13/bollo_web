function sha1(r) {
    var e, o, t, a, n, h, f, c, d, u = function (r, e) {
        var o = r << e | r >>> 32 - e;
        return o
    }, i = function (r) {
        var e, o, t = "";
        for (e = 7; e >= 0; e--)o = r >>> 4 * e & 15, t += o.toString(16);
        return t
    }, s = new Array(80), C = 1732584193, l = 4023233417, A = 2562383102, g = 271733878, v = 3285377520;
    r = this.utf8_encode(r);
    var w = r.length, p = [];
    for (o = 0; w - 3 > o; o += 4)t = r.charCodeAt(o) << 24 | r.charCodeAt(o + 1) << 16 | r.charCodeAt(o + 2) << 8 | r.charCodeAt(o + 3), p.push(t);
    switch (w % 4) {
        case 0:
            o = 2147483648;
            break;
        case 1:
            o = r.charCodeAt(w - 1) << 24 | 8388608;
            break;
        case 2:
            o = r.charCodeAt(w - 2) << 24 | r.charCodeAt(w - 1) << 16 | 32768;
            break;
        case 3:
            o = r.charCodeAt(w - 3) << 24 | r.charCodeAt(w - 2) << 16 | r.charCodeAt(w - 1) << 8 | 128
    }
    for (p.push(o); p.length % 16 != 14;)p.push(0);
    for (p.push(w >>> 29), p.push(w << 3 & 4294967295), e = 0; e < p.length; e += 16) {
        for (o = 0; 16 > o; o++)s[o] = p[e + o];
        for (o = 16; 79 >= o; o++)s[o] = u(s[o - 3] ^ s[o - 8] ^ s[o - 14] ^ s[o - 16], 1);
        for (a = C, n = l, h = A, f = g, c = v, o = 0; 19 >= o; o++)d = u(a, 5) + (n & h | ~n & f) + c + s[o] + 1518500249 & 4294967295, c = f, f = h, h = u(n, 30), n = a, a = d;
        for (o = 20; 39 >= o; o++)d = u(a, 5) + (n ^ h ^ f) + c + s[o] + 1859775393 & 4294967295, c = f, f = h, h = u(n, 30), n = a, a = d;
        for (o = 40; 59 >= o; o++)d = u(a, 5) + (n & h | n & f | h & f) + c + s[o] + 2400959708 & 4294967295, c = f, f = h, h = u(n, 30), n = a, a = d;
        for (o = 60; 79 >= o; o++)d = u(a, 5) + (n ^ h ^ f) + c + s[o] + 3395469782 & 4294967295, c = f, f = h, h = u(n, 30), n = a, a = d;
        C = C + a & 4294967295, l = l + n & 4294967295, A = A + h & 4294967295, g = g + f & 4294967295, v = v + c & 4294967295
    }
    return d = i(C) + i(l) + i(A) + i(g) + i(v), d.toLowerCase()
}
function utf8_encode(r) {
    if (null === r || "undefined" == typeof r)return "";
    var e, o, t = r + "", a = "", n = 0;
    e = o = 0, n = t.length;
    for (var h = 0; n > h; h++) {
        var f = t.charCodeAt(h), c = null;
        if (128 > f)o++; else if (f > 127 && 2048 > f)c = String.fromCharCode(f >> 6 | 192, 63 & f | 128); else if (55296 != (63488 & f))c = String.fromCharCode(f >> 12 | 224, f >> 6 & 63 | 128, 63 & f | 128); else {
            if (55296 != (64512 & f))throw new RangeError("Unmatched trail surrogate at " + h);
            var d = t.charCodeAt(++h);
            if (56320 != (64512 & d))throw new RangeError("Unmatched lead surrogate at " + (h - 1));
            f = ((1023 & f) << 10) + (1023 & d) + 65536, c = String.fromCharCode(f >> 18 | 240, f >> 12 & 63 | 128, f >> 6 & 63 | 128, 63 & f | 128)
        }
        null !== c && (o > e && (a += t.slice(e, o)), a += c, e = o = h + 1)
    }
    return o > e && (a += t.slice(e, n)), a
}