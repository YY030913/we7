/*!
 * Author: xinshw
 * Date: 2014-04-02
 */
define("script/tools/ajax", [],
function(a, b, c) {
    var d = {
        _jsonpGuid: 0,
        _reqObjPool: [],
        _getInstance: function() {
            for (var a = this,
            b = 0; b < a._reqObjPool.length; b++) if (0 == a._reqObjPool[b].readyState || 4 == a._reqObjPool[b].readyState) return a._reqObjPool[b];
            return a._reqObjPool[a._reqObjPool.length] = a._createRequest(),
            a._reqObjPool[a._reqObjPool.length - 1]
        },
        _createRequest: function() {
            var a;
            try {
                a = new XDomainRequest
            } catch(b) {
                try {
                    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP")
                } catch(b) {
                    try {
                        a = new ActiveXObject("Microsoft.XMLHTTP")
                    } catch(b) {}
                }
            }
            return ! a && window.XMLHttpRequest && (a = new XMLHttpRequest),
            a
        },
        requestData: function(a, b, c, d, e, f, g, h, i, j) {
            var k = this,
            l = a; 
			/*- 1 == l.indexOf("appId") && (l += "&appId=" + appId),
            -1 == l.indexOf("usertoken") && (l += "&usertoken=" + localStorage.getItem("usertoken")),
            -1 == l.indexOf("userid") && (l += "&userid=" + localStorage.getItem("userid")),
            -1 == l.indexOf("openid") && (l += "&openid=" + localStorage.getItem("openid")),
            -1 == l.indexOf("jsoncallback") && (l += "&jsoncallback=?");*/
            var m = b || null,
            n = d ? d.toUpperCase() : "JSON",
            o = e ? e.toUpperCase() : "GET",
            p = i || "undefined",
            q = h,
            r = j || !0,
            s = f || 3e4,
            t = -1,
            u = !1,
            v = function(a, b) {
                c && c(a, b)
            };
            m = function(a, c) {
                b && b(a, c)
            };
            var w = k._getInstance(),
            x = !1;
            if (("withCredentials" in w || "[object XDomainRequest]" == w) && (x = !0), w || v(w, "XMLHttpRequest创建失败"), !x) return - 1 == l.indexOf(window.location.host) && k.requestJSONP(a, b, c, f, h),
            void 0;
            if (w.onprogress && (w.onprogress = function(a) {
                p && p(w, a)
            }), "undefined" != typeof w.onload ? (w.onload = function() {
                clearTimeout(t),
                k.ajaxComplete(w, n, m, v)
            },
            w.onerror = function() {
                v(w, "errorcode====" + w.status)
            }) : w.onreadystatechange = function() {
                4 == w.readyState && (clearTimeout(t), 200 == w.status ? k.ajaxComplete(w, n, m, v) : u || v(w, "errorcode====" + w.status))
            },
            s) {
                try {
                    s = parseInt(s)
                } catch(y) {
                    v(w, "parseInt timeout args faild")
                }
                if (s > 0) {
                    var z = function() {
                        u = !0,
                        w.abort(),
                        v(w, "请求超时")
                    };
                    "undefined" == typeof w.timeout ? t = setTimeout(z, s) : (w.timeout = s, w.ontimeout = z)
                }
            }
            w.open(o, l + "&timeStamp=" + (new Date).getTime(), r),
            "GET" != o && w.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"),
            null != q && this.xmlHttp.overrideMimeType("text/html; charset=" + q),
            w.send(null)
        },
        ajaxComplete: function(a, b, c, d) {
            var e, f = !1;
            if ("JSON" == b) try {
                var g = a.responseText;
                if (a.responseText.indexOf("?(") >= 0) {
                    var h = a.responseText.indexOf("?("),
                    i = a.responseText.lastIndexOf(")");
                    g = a.responseText.substring(h + 2, i)
                }
                e = JSON.parse(g)
            } catch(i) {
                f = i
            } else e = a.responseText;
            f ? d(a, "parsererror", f) : c(e, a)
        },
        requestJSONP: function(a, b) {
            var c = this,
            d = "jsonp" + c._jsonpGuid,
            e = document.createElement("script");
            e.setAttribute("type", "text/javascript"),
            e.setAttribute("src", a.replace(/=\?/, "=" + d)),
            e.async = "async",
            document.getElementsByTagName("head")[0].appendChild(e),
            window[d] = function(a) {
                b(a),
                delete window[d]
            },
            c._jsonpGuid++
        }
    };
    c.exports = d
}),
define("script/tools/lazyloadimage", [],
function(a, b, c) {
    function d(a) {
        var b = 0;
        return document.documentElement.getBoundingClientRect ? b = a.getBoundingClientRect().top: (b = a.offsetTop, (getParentTop = function(a) {
            a.parentNode != document.body && (b += a.parentNode.offsetTop, getParentTop(a.parentNode))
        })(a)),
        b
    }
    c.exports = {
        loadInScreenImage: function(a, b) {
            var c = document.getElementsByClassName(a);
            for (i = 0; i < c.length; i++) {
                var e = c[i],
                f = null;
                if (f = "undefined" == typeof b ? e.getElementsByTagName("img")[0] : e.getElementsByClassName(b)[0]) {
                    var g = d(e),
                    h = f.getAttribute("data-src"),
                    j = parseInt(f.getAttribute("data-loaded")),
                    k = parseInt(document.documentElement.scrollTop - 1);
                    if (g < k + parseInt(window.innerHeight) && 0 == j) {
                        var l = new Image;
                        l.src = h,
                        function() {
                            var a = f;
                            l.onload = function() {
                                "undefined" == typeof b ? a.src = this.src: a.style.backgroundImage = "url(" + this.src + ")",
                                a.style.opacity = 1,
                                a.setAttribute("data-loaded", 1)
                            },
                            l.onerror = function() {}
                        } (window)
                    }
                }
            }
        }
    }
}),
define("script/tools/looplist", ["script/app/common/common.js", "sizzle", "event", "lazyloadimage", "gesture"],
function(a, b, c) {
    function d(a, b) {
        return f.touch ? a.changedTouches[0][b] : a[b]
    }
    function e(a, b, c) {
        isNaN(c) || (b.style[j] = c + "ms"),
        b.style[i] = "translate(" + a + "px, 0px) scale(1) translateZ(0px)"
    }
    var f = {
        transform3d: "WebKitCSSMatrix" in window,
        touch: "ontouchstart" in window
    },
    g = {
        start: f.touch ? "touchstart": "mousedown",
        move: f.touch ? "touchmove": "mousemove",
        end: f.touch ? "touchend": "mouseup"
    },
    h = a("script/app/common/common.js"),
    i = h.prefixStyle("transform"),
    j = h.prefixStyle("transitionDuration"),
    k = function(a) {
        var b = this;
        b.animateTime = a.time || 200,
        b.dataPos = a.dataPos || 0,
        b.dataArray = a.data || [],
        b.dataLength = a.data.length || 0,
        b.loopBox = a.boxDom,
        b.aroundFlag = a.around || !1,
        b.movePreDir = 1,
        b.showLength = b.loopBox.children.length + 2 || 0,
        b.minSizeToNext = 0,
        b.currentPoint = 0,
        b.prevPoint = 0,
        b.moveScale = 0,
        b.startPageX = 0,
        b.startPageY = 0,
        b.styleArray = [],
        b.distance = [],
        b.leftEndCoor = [],
        b.moveReady = !0,
        b.moveEnd = !0,
        b.startTime = 0,
        b.initNextData = function() {},
        b._refresh(),
        b.loopBox.addEventListener(g.start, b, !1),
        b.loopBox.addEventListener(g.move, b, !1),
        b.loopBox.addEventListener(g.end, b, !1)
    };
    k.prototype = {
        handleEvent: function(a) {
            var b = this;
            switch (a.preventDefault(), a.stopPropagation(), a.type) {
            case g.start:
                b._touchStart(a);
                break;
            case g.move:
                if (!b.moveEnd) return;
                b._touchMove(a);
                break;
            case g.end:
                if (!b.moveEnd) return;
                b._touchEnd(a);
                break;
            case g.transEnd:
                b.transEnd && b.transEnd(a)
            }
        },
        _refresh: function() {
            var a = this;
            a.minSizeToNext = a.loopBox.children[0].offsetWidth / 2,
            a._creatExchangeDiv(),
            a._initExchangeDiv(1);
            var b = a.loopBox.children;
            a.moveScale = (a.loopBox.offsetWidth - b[2].offsetLeft - b[2].offsetWidth) / b[0].offsetLeft,
            a._initDistance()
        },
        _creatExchangeDiv: function() {
            var a = this,
            b = a.loopBox.children[0].cloneNode(!0);
            a.loopBox.insertBefore(b, a.loopBox.children[1]);
            var c = a.loopBox.children[a.loopBox.children.length - 1].cloneNode(!0);
            a.loopBox.appendChild(c)
        },
        _initExchangeDiv: function(a) {
            var b = this,
            c = b.loopBox.children[(b.currentPoint + a + b.showLength) % b.showLength];
            c.style[j] = "0";
            var d = (b.dataPos + a + b.dataArray.length) % b.dataArray.length;
            c.style.backgroundImage = "url(" + b.dataArray[d].img + ")",
            c.className = b.loopBox.children[b.currentPoint].className,
            c.innerHTML = '<div class="photo_title"><span>' + b.dataArray[d].name + "</span></div>",
            outExChangeDiv = b.loopBox.children[(b.currentPoint - a + b.showLength) % b.showLength],
            outExChangeDiv.style.webkitTransitionDuration = "0",
            0 > a ? (outExChangeDiv.style.backgroundImage = b.loopBox.children[b.currentPoint].style.backgroundImage, outExChangeDiv.innerHTML = b.loopBox.children[b.currentPoint].innerHTML) : (outExChangeDiv.style.backgroundImage = "url(" + b.dataArray[(b.dataPos - a + b.dataArray.length) % b.dataArray.length].img + ")", outExChangeDiv.innerHTML = '<div class="photo_title"><span>' + b.dataArray[(b.dataPos - a + b.dataArray.length) % b.dataArray.length].name + "</span></div>"),
            outExChangeDiv.className = b.loopBox.children[(b.currentPoint - 2 * a + b.showLength) % b.showLength].className
        },
        _initDistance: function() {
            var a = this;
            a.distance[0] = [],
            a.styleArray[0] = [],
            a.leftEndCoor[0] = [];
            for (var b = 0; b < a.showLength; b++) {
                var c = 0;
                c = 1 == b ? a.loopBox.children[a.currentPoint].offsetLeft + a.loopBox.offsetWidth: 4 == b ? -(a.loopBox.children[a.showLength - 2].offsetLeft + a.loopBox.children[3].offsetWidth) : a.loopBox.children[b].offsetLeft,
                a.distance[0][b] = c,
                e(c, a.loopBox.children[b]),
                a.styleArray[0][b] = a.loopBox.children[b].className
            }
            a.leftEndCoor[0][0] = -(a.loopBox.children[0].offsetLeft + a.loopBox.children[0].offsetWidth),
            a.leftEndCoor[0][1] = a.loopBox.children[3].offsetLeft + a.loopBox.offsetWidth,
            a.distance[1] = [],
            a.styleArray[1] = [],
            a.leftEndCoor[1] = [];
            for (var b = 0; b < a.showLength; b++) {
                var c = 0,
                d = "";
                1 == b ? (d = a.loopBox.children[2].className, c = a.loopBox.children[a.showLength - 2].offsetLeft + a.loopBox.offsetWidth) : 4 == b ? (d = a.loopBox.children[a.currentPoint].className, c = -(a.loopBox.children[0].offsetLeft + a.loopBox.children[a.currentPoint].offsetWidth)) : (c = a.loopBox.children[b].offsetLeft, d = a.loopBox.children[b].className),
                a.distance[1][b] = c,
                a.styleArray[1][b] = d
            }
            a.leftEndCoor[1][0] = a.loopBox.children[3].offsetLeft + a.loopBox.offsetWidth,
            a.leftEndCoor[1][1] = -(a.loopBox.children[3].offsetLeft + a.loopBox.children[3].offsetWidth);
            for (var b = 0; b < a.showLength; b++) a.loopBox.children[b].style.left = 0
        },
        _touchStart: function() {
            var a = this;
            a.startTime = (new Date).getTime(),
            a.startPageX = d(event, "pageX"),
            a.startPageY = d(event, "pageY"),
            a.moveReady = !1
        },
        _touchMove: function() {
            {
                var a = this,
                b = d(event, "pageX");
                d(event, "pageY")
            }
            if (!a.moveReady) {
                var c = b - a.startPageX,
                e = c > 0 ? -1 : 1;
                a.movePreDir != e && (a.movePreDir = e, a._initExchangeDiv(e)),
                a._moveXY(c, 0)
            }
        },
        _touchEnd: function() {
            var a = this,
            b = (new Date).getTime(),
            c = b - a.startTime,
            e = d(event, "pageX"),
            f = (d(event, "pageY"), e - a.startPageX);
            Math.abs(f) > a.minSizeToNext || 200 > c && Math.abs(f) > 50 ? f > 0 ? a._movePos( - 1) : a._movePos(1) : a._movePos(0),
            a.moveReady = !0
        },
        _moveXY: function(a, b) {
            for (var c = this,
            d = 0; d < c.showLength; d++) {
                var f = a;
                c.loopBox.children[d].className != c.loopBox.children[c.currentPoint].className && (f = -a * c.moveScale);
                var g = 0 > a ? 0 : 1,
                h = c.distance[g][(c.showLength - c.currentPoint + d) % c.showLength] + f;
                e(h, c.loopBox.children[d], b)
            }
        },
        _movePos: function(a) {
            var b = this;
            0 == a ? b._moveXY(0, b.animateTime) : b._moveToPoint(a)
        },
        _moveToPoint: function(a) {
            var b = this;
            b.dataPos += a,
            b.dataPos < 0 && (b.dataPos = b.dataArray.length - 1),
            b.dataPos > b.dataArray.length - 1 && (b.dataPos = 0),
            b.moveEnd = !1,
            b.currentPoint = (b.prevPoint + a + b.showLength) % b.showLength;
            for (var c = (b.currentPoint - a + b.showLength) % b.showLength, d = (b.currentPoint + a + b.showLength) % b.showLength, f = 0; f < b.showLength; f++) {
                var g = b.loopBox.children[f],
                h = a > 0 ? 0 : 1;
                g == b.loopBox.children[c] ? e(b.leftEndCoor[h][0], g, b.animateTime) : g == b.loopBox.children[d] ? e(b.leftEndCoor[h][1], g, b.animateTime) : e(b.distance[h][(b.showLength - b.currentPoint + f) % b.showLength], g, b.animateTime),
                function() {
                    var i = c,
                    k = d,
                    l = g,
                    m = b.styleArray[h][(b.showLength - b.currentPoint + f) % b.showLength];
                    l.addEventListener("webkitTransitionEnd",
                    function() {
                        l.style[j] = "0ms",
                        l.className = m,
                        l == b.loopBox.children[i] && e(b.distance[h][(b.showLength - a) % b.showLength], l, 0),
                        l == b.loopBox.children[k] && e(b.distance[h][(b.showLength + a) % b.showLength], l, 0),
                        l.removeEventListener("webkitTransitionEnd", arguments.callee, !1),
                        b.moveEnd = !0;
                        var f = null,
                        g = 0;
                        a > 0 ? (f = b.loopBox.children[d], g = (b.dataPos + 1) % b.dataArray.length) : (f = b.loopBox.children[c], g = b.dataPos),
                        b.initNextData(f, g)
                    },
                    !1)
                } ()
            }
            b.prevPoint = b.currentPoint
        }
    },
    c.exports = k
}),
define("script/tools/sizzle", [],
function(a, b, c) { !
    function(a) {
        function b(a, b, c, d) {
            var e, f, g, h, i, j, k, m, p, q;
            if ((b ? b.ownerDocument || b: Q) !== I && H(b), b = b || I, c = c || [], !a || "string" != typeof a) return c;
            if (1 !== (h = b.nodeType) && 9 !== h) return [];
            if (K && !d) {
                if (e = ub.exec(a)) if (g = e[1]) {
                    if (9 === h) {
                        if (f = b.getElementById(g), !f || !f.parentNode) return c;
                        if (f.id === g) return c.push(f),
                        c
                    } else if (b.ownerDocument && (f = b.ownerDocument.getElementById(g)) && O(b, f) && f.id === g) return c.push(f),
                    c
                } else {
                    if (e[2]) return bb.apply(c, b.getElementsByTagName(a)),
                    c;
                    if ((g = e[3]) && y.getElementsByClassName && b.getElementsByClassName) return bb.apply(c, b.getElementsByClassName(g)),
                    c
                }
                if (y.qsa && (!L || !L.test(a))) {
                    if (m = k = P, p = b, q = 9 === h && a, 1 === h && "object" !== b.nodeName.toLowerCase()) {
                        for (j = n(a), (k = b.getAttribute("id")) ? m = k.replace(wb, "\\$&") : b.setAttribute("id", m), m = "[id='" + m + "'] ", i = j.length; i--;) j[i] = m + o(j[i]);
                        p = vb.test(a) && l(b.parentNode) || b,
                        q = j.join(",")
                    }
                    if (q) try {
                        return bb.apply(c, p.querySelectorAll(q)),
                        c
                    } catch(r) {} finally {
                        k || b.removeAttribute("id")
                    }
                }
            }
            return w(a.replace(kb, "$1"), b, c, d)
        }
        function d() {
            function a(c, d) {
                return b.push(c + " ") > A.cacheLength && delete a[b.shift()],
                a[c + " "] = d
            }
            var b = [];
            return a
        }
        function e(a) {
            return a[P] = !0,
            a
        }
        function f(a) {
            var b = I.createElement("div");
            try {
                return !! a(b)
            } catch(c) {
                return ! 1
            } finally {
                b.parentNode && b.parentNode.removeChild(b),
                b = null
            }
        }
        function g(a, b) {
            for (var c = a.split("|"), d = a.length; d--;) A.attrHandle[c[d]] = b
        }
        function h(a, b) {
            var c = b && a,
            d = c && 1 === a.nodeType && 1 === b.nodeType && (~b.sourceIndex || Y) - (~a.sourceIndex || Y);
            if (d) return d;
            if (c) for (; c = c.nextSibling;) if (c === b) return - 1;
            return a ? 1 : -1
        }
        function i(a) {
            return function(b) {
                var c = b.nodeName.toLowerCase();
                return "input" === c && b.type === a
            }
        }
        function j(a) {
            return function(b) {
                var c = b.nodeName.toLowerCase();
                return ("input" === c || "button" === c) && b.type === a
            }
        }
        function k(a) {
            return e(function(b) {
                return b = +b,
                e(function(c, d) {
                    for (var e, f = a([], c.length, b), g = f.length; g--;) c[e = f[g]] && (c[e] = !(d[e] = c[e]))
                })
            })
        }
        function l(a) {
            return a && typeof a.getElementsByTagName !== X && a
        }
        function m() {}
        function n(a, c) {
            var d, e, f, g, h, i, j, k = U[a + " "];
            if (k) return c ? 0 : k.slice(0);
            for (h = a, i = [], j = A.preFilter; h;) { (!d || (e = lb.exec(h))) && (e && (h = h.slice(e[0].length) || h), i.push(f = [])),
                d = !1,
                (e = mb.exec(h)) && (d = e.shift(), f.push({
                    value: d,
                    type: e[0].replace(kb, " ")
                }), h = h.slice(d.length));
                for (g in A.filter) ! (e = qb[g].exec(h)) || j[g] && !(e = j[g](e)) || (d = e.shift(), f.push({
                    value: d,
                    type: g,
                    matches: e
                }), h = h.slice(d.length));
                if (!d) break
            }
            return c ? h.length: h ? b.error(a) : U(a, i).slice(0)
        }
        function o(a) {
            for (var b = 0,
            c = a.length,
            d = ""; c > b; b++) d += a[b].value;
            return d
        }
        function p(a, b, c) {
            var d = b.dir,
            e = c && "parentNode" === d,
            f = S++;
            return b.first ?
            function(b, c, f) {
                for (; b = b[d];) if (1 === b.nodeType || e) return a(b, c, f)
            }: function(b, c, g) {
                var h, i, j, k = R + " " + f;
                if (g) {
                    for (; b = b[d];) if ((1 === b.nodeType || e) && a(b, c, g)) return ! 0
                } else for (; b = b[d];) if (1 === b.nodeType || e) if (j = b[P] || (b[P] = {}), (i = j[d]) && i[0] === k) {
                    if ((h = i[1]) === !0 || h === z) return h === !0
                } else if (i = j[d] = [k], i[1] = a(b, c, g) || z, i[1] === !0) return ! 0
            }
        }
        function q(a) {
            return a.length > 1 ?
            function(b, c, d) {
                for (var e = a.length; e--;) if (!a[e](b, c, d)) return ! 1;
                return ! 0
            }: a[0]
        }
        function r(a, b, c, d, e) {
            for (var f, g = [], h = 0, i = a.length, j = null != b; i > h; h++)(f = a[h]) && (!c || c(f, d, e)) && (g.push(f), j && b.push(h));
            return g
        }
        function s(a, b, c, d, f, g) {
            return d && !d[P] && (d = s(d)),
            f && !f[P] && (f = s(f, g)),
            e(function(e, g, h, i) {
                var j, k, l, m = [],
                n = [],
                o = g.length,
                p = e || v(b || "*", h.nodeType ? [h] : h, []),
                q = !a || !e && b ? p: r(p, m, a, h, i),
                s = c ? f || (e ? a: o || d) ? [] : g: q;
                if (c && c(q, s, h, i), d) for (j = r(s, n), d(j, [], h, i), k = j.length; k--;)(l = j[k]) && (s[n[k]] = !(q[n[k]] = l));
                if (e) {
                    if (f || a) {
                        if (f) {
                            for (j = [], k = s.length; k--;)(l = s[k]) && j.push(q[k] = l);
                            f(null, s = [], j, i)
                        }
                        for (k = s.length; k--;)(l = s[k]) && (j = f ? db.call(e, l) : m[k]) > -1 && (e[j] = !(g[j] = l))
                    }
                } else s = r(s === g ? s.splice(o, s.length) : s),
                f ? f(null, g, s, i) : bb.apply(g, s)
            })
        }
        function t(a) {
            for (var b, c, d, e = a.length,
            f = A.relative[a[0].type], g = f || A.relative[" "], h = f ? 1 : 0, i = p(function(a) {
                return a === b
            },
            g, !0), j = p(function(a) {
                return db.call(b, a) > -1
            },
            g, !0), k = [function(a, c, d) {
                return ! f && (d || c !== E) || ((b = c).nodeType ? i(a, c, d) : j(a, c, d))
            }]; e > h; h++) if (c = A.relative[a[h].type]) k = [p(q(k), c)];
            else {
                if (c = A.filter[a[h].type].apply(null, a[h].matches), c[P]) {
                    for (d = ++h; e > d && !A.relative[a[d].type]; d++);
                    return s(h > 1 && q(k), h > 1 && o(a.slice(0, h - 1).concat({
                        value: " " === a[h - 2].type ? "*": ""
                    })).replace(kb, "$1"), c, d > h && t(a.slice(h, d)), e > d && t(a = a.slice(d)), e > d && o(a))
                }
                k.push(c)
            }
            return q(k)
        }
        function u(a, c) {
            var d = 0,
            f = c.length > 0,
            g = a.length > 0,
            h = function(e, h, i, j, k) {
                var l, m, n, o = 0,
                p = "0",
                q = e && [],
                s = [],
                t = E,
                u = e || g && A.find.TAG("*", k),
                v = R += null == t ? 1 : Math.random() || .1,
                w = u.length;
                for (k && (E = h !== I && h, z = d); p !== w && null != (l = u[p]); p++) {
                    if (g && l) {
                        for (m = 0; n = a[m++];) if (n(l, h, i)) {
                            j.push(l);
                            break
                        }
                        k && (R = v, z = ++d)
                    }
                    f && ((l = !n && l) && o--, e && q.push(l))
                }
                if (o += p, f && p !== o) {
                    for (m = 0; n = c[m++];) n(q, s, h, i);
                    if (e) {
                        if (o > 0) for (; p--;) q[p] || s[p] || (s[p] = _.call(j));
                        s = r(s)
                    }
                    bb.apply(j, s),
                    k && !e && s.length > 0 && o + c.length > 1 && b.uniqueSort(j)
                }
                return k && (R = v, E = t),
                q
            };
            return f ? e(h) : h
        }
        function v(a, c, d) {
            for (var e = 0,
            f = c.length; f > e; e++) b(a, c[e], d);
            return d
        }
        function w(a, b, c, d) {
            var e, f, g, h, i, j = n(a);
            if (!d && 1 === j.length) {
                if (f = j[0] = j[0].slice(0), f.length > 2 && "ID" === (g = f[0]).type && y.getById && 9 === b.nodeType && K && A.relative[f[1].type]) {
                    if (b = (A.find.ID(g.matches[0].replace(xb, yb), b) || [])[0], !b) return c;
                    a = a.slice(f.shift().value.length)
                }
                for (e = qb.needsContext.test(a) ? 0 : f.length; e--&&(g = f[e], !A.relative[h = g.type]);) if ((i = A.find[h]) && (d = i(g.matches[0].replace(xb, yb), vb.test(f[0].type) && l(b.parentNode) || b))) {
                    if (f.splice(e, 1), a = d.length && o(f), !a) return bb.apply(c, d),
                    c;
                    break
                }
            }
            return D(a, j)(d, b, !K, c, vb.test(a) && l(b.parentNode) || b),
            c
        }
        var x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P = "sizzle" + -new Date,
        Q = a.document,
        R = 0,
        S = 0,
        T = d(),
        U = d(),
        V = d(),
        W = function(a, b) {
            return a === b && (G = !0),
            0
        },
        X = "undefined",
        Y = 1 << 31,
        Z = {}.hasOwnProperty,
        $ = [],
        _ = $.pop,
        ab = $.push,
        bb = $.push,
        cb = $.slice,
        db = $.indexOf ||
        function(a) {
            for (var b = 0,
            c = this.length; c > b; b++) if (this[b] === a) return b;
            return - 1
        },
        eb = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
        fb = "[\\x20\\t\\r\\n\\f]",
        gb = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
        hb = gb.replace("w", "w#"),
        ib = "\\[" + fb + "*(" + gb + ")" + fb + "*(?:([*^$|!~]?=)" + fb + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + hb + ")|)|)" + fb + "*\\]",
        jb = ":(" + gb + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + ib.replace(3, 8) + ")*)|.*)\\)|)",
        kb = new RegExp("^" + fb + "+|((?:^|[^\\\\])(?:\\\\.)*)" + fb + "+$", "g"),
        lb = new RegExp("^" + fb + "*," + fb + "*"),
        mb = new RegExp("^" + fb + "*([>+~]|" + fb + ")" + fb + "*"),
        nb = new RegExp("=" + fb + "*([^\\]'\"]*?)" + fb + "*\\]", "g"),
        ob = new RegExp(jb),
        pb = new RegExp("^" + hb + "$"),
        qb = {
            ID: new RegExp("^#(" + gb + ")"),
            CLASS: new RegExp("^\\.(" + gb + ")"),
            TAG: new RegExp("^(" + gb.replace("w", "w*") + ")"),
            ATTR: new RegExp("^" + ib),
            PSEUDO: new RegExp("^" + jb),
            CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + fb + "*(even|odd|(([+-]|)(\\d*)n|)" + fb + "*(?:([+-]|)" + fb + "*(\\d+)|))" + fb + "*\\)|)", "i"),
            bool: new RegExp("^(?:" + eb + ")$", "i"),
            needsContext: new RegExp("^" + fb + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + fb + "*((?:-\\d)?\\d*)" + fb + "*\\)|)(?=[^-]|$)", "i")
        },
        rb = /^(?:input|select|textarea|button)$/i,
        sb = /^h\d$/i,
        tb = /^[^{]+\{\s*\[native \w/,
        ub = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
        vb = /[+~]/,
        wb = /'|\\/g,
        xb = new RegExp("\\\\([\\da-f]{1,6}" + fb + "?|(" + fb + ")|.)", "ig"),
        yb = function(a, b, c) {
            var d = "0x" + b - 65536;
            return d !== d || c ? b: 0 > d ? String.fromCharCode(d + 65536) : String.fromCharCode(d >> 10 | 55296, 1023 & d | 56320)
        };
        try {
            bb.apply($ = cb.call(Q.childNodes), Q.childNodes),
            $[Q.childNodes.length].nodeType
        } catch(zb) {
            bb = {
                apply: $.length ?
                function(a, b) {
                    ab.apply(a, cb.call(b))
                }: function(a, b) {
                    for (var c = a.length,
                    d = 0; a[c++] = b[d++];);
                    a.length = c - 1
                }
            }
        }
        y = b.support = {},
        C = b.isXML = function(a) {
            var b = a && (a.ownerDocument || a).documentElement;
            return b ? "HTML" !== b.nodeName: !1
        },
        H = b.setDocument = function(a) {
            var b, c = a ? a.ownerDocument || a: Q,
            d = c.defaultView;
            return c !== I && 9 === c.nodeType && c.documentElement ? (I = c, J = c.documentElement, K = !C(c), d && d !== d.top && (d.addEventListener ? d.addEventListener("unload",
            function() {
                H()
            },
            !1) : d.attachEvent && d.attachEvent("onunload",
            function() {
                H()
            })), y.attributes = f(function(a) {
                return a.className = "i",
                !a.getAttribute("className")
            }), y.getElementsByTagName = f(function(a) {
                return a.appendChild(c.createComment("")),
                !a.getElementsByTagName("*").length
            }), y.getElementsByClassName = tb.test(c.getElementsByClassName) && f(function(a) {
                return a.innerHTML = "<div class='a'></div><div class='a i'></div>",
                a.firstChild.className = "i",
                2 === a.getElementsByClassName("i").length
            }), y.getById = f(function(a) {
                return J.appendChild(a).id = P,
                !c.getElementsByName || !c.getElementsByName(P).length
            }), y.getById ? (A.find.ID = function(a, b) {
                if (typeof b.getElementById !== X && K) {
                    var c = b.getElementById(a);
                    return c && c.parentNode ? [c] : []
                }
            },
            A.filter.ID = function(a) {
                var b = a.replace(xb, yb);
                return function(a) {
                    return a.getAttribute("id") === b
                }
            }) : (delete A.find.ID, A.filter.ID = function(a) {
                var b = a.replace(xb, yb);
                return function(a) {
                    var c = typeof a.getAttributeNode !== X && a.getAttributeNode("id");
                    return c && c.value === b
                }
            }), A.find.TAG = y.getElementsByTagName ?
            function(a, b) {
                return typeof b.getElementsByTagName !== X ? b.getElementsByTagName(a) : void 0
            }: function(a, b) {
                var c, d = [],
                e = 0,
                f = b.getElementsByTagName(a);
                if ("*" === a) {
                    for (; c = f[e++];) 1 === c.nodeType && d.push(c);
                    return d
                }
                return f
            },
            A.find.CLASS = y.getElementsByClassName &&
            function(a, b) {
                return typeof b.getElementsByClassName !== X && K ? b.getElementsByClassName(a) : void 0
            },
            M = [], L = [], (y.qsa = tb.test(c.querySelectorAll)) && (f(function(a) {
                a.innerHTML = "<select t=''><option selected=''></option></select>",
                a.querySelectorAll("[t^='']").length && L.push("[*^$]=" + fb + "*(?:''|\"\")"),
                a.querySelectorAll("[selected]").length || L.push("\\[" + fb + "*(?:value|" + eb + ")"),
                a.querySelectorAll(":checked").length || L.push(":checked")
            }), f(function(a) {
                var b = c.createElement("input");
                b.setAttribute("type", "hidden"),
                a.appendChild(b).setAttribute("name", "D"),
                a.querySelectorAll("[name=d]").length && L.push("name" + fb + "*[*^$|!~]?="),
                a.querySelectorAll(":enabled").length || L.push(":enabled", ":disabled"),
                a.querySelectorAll("*,:x"),
                L.push(",.*:")
            })), (y.matchesSelector = tb.test(N = J.webkitMatchesSelector || J.mozMatchesSelector || J.oMatchesSelector || J.msMatchesSelector)) && f(function(a) {
                y.disconnectedMatch = N.call(a, "div"),
                N.call(a, "[s!='']:x"),
                M.push("!=", jb)
            }), L = L.length && new RegExp(L.join("|")), M = M.length && new RegExp(M.join("|")), b = tb.test(J.compareDocumentPosition), O = b || tb.test(J.contains) ?
            function(a, b) {
                var c = 9 === a.nodeType ? a.documentElement: a,
                d = b && b.parentNode;
                return a === d || !(!d || 1 !== d.nodeType || !(c.contains ? c.contains(d) : a.compareDocumentPosition && 16 & a.compareDocumentPosition(d)))
            }: function(a, b) {
                if (b) for (; b = b.parentNode;) if (b === a) return ! 0;
                return ! 1
            },
            W = b ?
            function(a, b) {
                if (a === b) return G = !0,
                0;
                var d = !a.compareDocumentPosition - !b.compareDocumentPosition;
                return d ? d: (d = (a.ownerDocument || a) === (b.ownerDocument || b) ? a.compareDocumentPosition(b) : 1, 1 & d || !y.sortDetached && b.compareDocumentPosition(a) === d ? a === c || a.ownerDocument === Q && O(Q, a) ? -1 : b === c || b.ownerDocument === Q && O(Q, b) ? 1 : F ? db.call(F, a) - db.call(F, b) : 0 : 4 & d ? -1 : 1)
            }: function(a, b) {
                if (a === b) return G = !0,
                0;
                var d, e = 0,
                f = a.parentNode,
                g = b.parentNode,
                i = [a],
                j = [b];
                if (!f || !g) return a === c ? -1 : b === c ? 1 : f ? -1 : g ? 1 : F ? db.call(F, a) - db.call(F, b) : 0;
                if (f === g) return h(a, b);
                for (d = a; d = d.parentNode;) i.unshift(d);
                for (d = b; d = d.parentNode;) j.unshift(d);
                for (; i[e] === j[e];) e++;
                return e ? h(i[e], j[e]) : i[e] === Q ? -1 : j[e] === Q ? 1 : 0
            },
            c) : I
        },
        b.matches = function(a, c) {
            return b(a, null, null, c)
        },
        b.matchesSelector = function(a, c) {
            if ((a.ownerDocument || a) !== I && H(a), c = c.replace(nb, "='$1']"), !(!y.matchesSelector || !K || M && M.test(c) || L && L.test(c))) try {
                var d = N.call(a, c);
                if (d || y.disconnectedMatch || a.document && 11 !== a.document.nodeType) return d
            } catch(e) {}
            return b(c, I, null, [a]).length > 0
        },
        b.contains = function(a, b) {
            return (a.ownerDocument || a) !== I && H(a),
            O(a, b)
        },
        b.attr = function(a, b) { (a.ownerDocument || a) !== I && H(a);
            var c = A.attrHandle[b.toLowerCase()],
            d = c && Z.call(A.attrHandle, b.toLowerCase()) ? c(a, b, !K) : void 0;
            return void 0 !== d ? d: y.attributes || !K ? a.getAttribute(b) : (d = a.getAttributeNode(b)) && d.specified ? d.value: null
        },
        b.error = function(a) {
            throw new Error("Syntax error, unrecognized expression: " + a)
        },
        b.uniqueSort = function(a) {
            var b, c = [],
            d = 0,
            e = 0;
            if (G = !y.detectDuplicates, F = !y.sortStable && a.slice(0), a.sort(W), G) {
                for (; b = a[e++];) b === a[e] && (d = c.push(e));
                for (; d--;) a.splice(c[d], 1)
            }
            return F = null,
            a
        },
        B = b.getText = function(a) {
            var b, c = "",
            d = 0,
            e = a.nodeType;
            if (e) {
                if (1 === e || 9 === e || 11 === e) {
                    if ("string" == typeof a.textContent) return a.textContent;
                    for (a = a.firstChild; a; a = a.nextSibling) c += B(a)
                } else if (3 === e || 4 === e) return a.nodeValue
            } else for (; b = a[d++];) c += B(b);
            return c
        },
        A = b.selectors = {
            cacheLength: 50,
            createPseudo: e,
            match: qb,
            attrHandle: {},
            find: {},
            relative: {
                ">": {
                    dir: "parentNode",
                    first: !0
                },
                " ": {
                    dir: "parentNode"
                },
                "+": {
                    dir: "previousSibling",
                    first: !0
                },
                "~": {
                    dir: "previousSibling"
                }
            },
            preFilter: {
                ATTR: function(a) {
                    return a[1] = a[1].replace(xb, yb),
                    a[3] = (a[4] || a[5] || "").replace(xb, yb),
                    "~=" === a[2] && (a[3] = " " + a[3] + " "),
                    a.slice(0, 4)
                },
                CHILD: function(a) {
                    return a[1] = a[1].toLowerCase(),
                    "nth" === a[1].slice(0, 3) ? (a[3] || b.error(a[0]), a[4] = +(a[4] ? a[5] + (a[6] || 1) : 2 * ("even" === a[3] || "odd" === a[3])), a[5] = +(a[7] + a[8] || "odd" === a[3])) : a[3] && b.error(a[0]),
                    a
                },
                PSEUDO: function(a) {
                    var b, c = !a[5] && a[2];
                    return qb.CHILD.test(a[0]) ? null: (a[3] && void 0 !== a[4] ? a[2] = a[4] : c && ob.test(c) && (b = n(c, !0)) && (b = c.indexOf(")", c.length - b) - c.length) && (a[0] = a[0].slice(0, b), a[2] = c.slice(0, b)), a.slice(0, 3))
                }
            },
            filter: {
                TAG: function(a) {
                    var b = a.replace(xb, yb).toLowerCase();
                    return "*" === a ?
                    function() {
                        return ! 0
                    }: function(a) {
                        return a.nodeName && a.nodeName.toLowerCase() === b
                    }
                },
                CLASS: function(a) {
                    var b = T[a + " "];
                    return b || (b = new RegExp("(^|" + fb + ")" + a + "(" + fb + "|$)")) && T(a,
                    function(a) {
                        return b.test("string" == typeof a.className && a.className || typeof a.getAttribute !== X && a.getAttribute("class") || "")
                    })
                },
                ATTR: function(a, c, d) {
                    return function(e) {
                        var f = b.attr(e, a);
                        return null == f ? "!=" === c: c ? (f += "", "=" === c ? f === d: "!=" === c ? f !== d: "^=" === c ? d && 0 === f.indexOf(d) : "*=" === c ? d && f.indexOf(d) > -1 : "$=" === c ? d && f.slice( - d.length) === d: "~=" === c ? (" " + f + " ").indexOf(d) > -1 : "|=" === c ? f === d || f.slice(0, d.length + 1) === d + "-": !1) : !0
                    }
                },
                CHILD: function(a, b, c, d, e) {
                    var f = "nth" !== a.slice(0, 3),
                    g = "last" !== a.slice( - 4),
                    h = "of-type" === b;
                    return 1 === d && 0 === e ?
                    function(a) {
                        return !! a.parentNode
                    }: function(b, c, i) {
                        var j, k, l, m, n, o, p = f !== g ? "nextSibling": "previousSibling",
                        q = b.parentNode,
                        r = h && b.nodeName.toLowerCase(),
                        s = !i && !h;
                        if (q) {
                            if (f) {
                                for (; p;) {
                                    for (l = b; l = l[p];) if (h ? l.nodeName.toLowerCase() === r: 1 === l.nodeType) return ! 1;
                                    o = p = "only" === a && !o && "nextSibling"
                                }
                                return ! 0
                            }
                            if (o = [g ? q.firstChild: q.lastChild], g && s) {
                                for (k = q[P] || (q[P] = {}), j = k[a] || [], n = j[0] === R && j[1], m = j[0] === R && j[2], l = n && q.childNodes[n]; l = ++n && l && l[p] || (m = n = 0) || o.pop();) if (1 === l.nodeType && ++m && l === b) {
                                    k[a] = [R, n, m];
                                    break
                                }
                            } else if (s && (j = (b[P] || (b[P] = {}))[a]) && j[0] === R) m = j[1];
                            else for (; (l = ++n && l && l[p] || (m = n = 0) || o.pop()) && ((h ? l.nodeName.toLowerCase() !== r: 1 !== l.nodeType) || !++m || (s && ((l[P] || (l[P] = {}))[a] = [R, m]), l !== b)););
                            return m -= e,
                            m === d || m % d === 0 && m / d >= 0
                        }
                    }
                },
                PSEUDO: function(a, c) {
                    var d, f = A.pseudos[a] || A.setFilters[a.toLowerCase()] || b.error("unsupported pseudo: " + a);
                    return f[P] ? f(c) : f.length > 1 ? (d = [a, a, "", c], A.setFilters.hasOwnProperty(a.toLowerCase()) ? e(function(a, b) {
                        for (var d, e = f(a, c), g = e.length; g--;) d = db.call(a, e[g]),
                        a[d] = !(b[d] = e[g])
                    }) : function(a) {
                        return f(a, 0, d)
                    }) : f
                }
            },
            pseudos: {
                not: e(function(a) {
                    var b = [],
                    c = [],
                    d = D(a.replace(kb, "$1"));
                    return d[P] ? e(function(a, b, c, e) {
                        for (var f, g = d(a, null, e, []), h = a.length; h--;)(f = g[h]) && (a[h] = !(b[h] = f))
                    }) : function(a, e, f) {
                        return b[0] = a,
                        d(b, null, f, c),
                        !c.pop()
                    }
                }),
                has: e(function(a) {
                    return function(c) {
                        return b(a, c).length > 0
                    }
                }),
                contains: e(function(a) {
                    return function(b) {
                        return (b.textContent || b.innerText || B(b)).indexOf(a) > -1
                    }
                }),
                lang: e(function(a) {
                    return pb.test(a || "") || b.error("unsupported lang: " + a),
                    a = a.replace(xb, yb).toLowerCase(),
                    function(b) {
                        var c;
                        do
                        if (c = K ? b.lang: b.getAttribute("xml:lang") || b.getAttribute("lang")) return c = c.toLowerCase(),
                        c === a || 0 === c.indexOf(a + "-");
                        while ((b = b.parentNode) && 1 === b.nodeType);
                        return ! 1
                    }
                }),
                target: function(b) {
                    var c = a.location && a.location.hash;
                    return c && c.slice(1) === b.id
                },
                root: function(a) {
                    return a === J
                },
                focus: function(a) {
                    return a === I.activeElement && (!I.hasFocus || I.hasFocus()) && !!(a.type || a.href || ~a.tabIndex)
                },
                enabled: function(a) {
                    return a.disabled === !1
                },
                disabled: function(a) {
                    return a.disabled === !0
                },
                checked: function(a) {
                    var b = a.nodeName.toLowerCase();
                    return "input" === b && !!a.checked || "option" === b && !!a.selected
                },
                selected: function(a) {
                    return a.parentNode && a.parentNode.selectedIndex,
                    a.selected === !0
                },
                empty: function(a) {
                    for (a = a.firstChild; a; a = a.nextSibling) if (a.nodeType < 6) return ! 1;
                    return ! 0
                },
                parent: function(a) {
                    return ! A.pseudos.empty(a)
                },
                header: function(a) {
                    return sb.test(a.nodeName)
                },
                input: function(a) {
                    return rb.test(a.nodeName)
                },
                button: function(a) {
                    var b = a.nodeName.toLowerCase();
                    return "input" === b && "button" === a.type || "button" === b
                },
                text: function(a) {
                    var b;
                    return "input" === a.nodeName.toLowerCase() && "text" === a.type && (null == (b = a.getAttribute("type")) || "text" === b.toLowerCase())
                },
                first: k(function() {
                    return [0]
                }),
                last: k(function(a, b) {
                    return [b - 1]
                }),
                eq: k(function(a, b, c) {
                    return [0 > c ? c + b: c]
                }),
                even: k(function(a, b) {
                    for (var c = 0; b > c; c += 2) a.push(c);
                    return a
                }),
                odd: k(function(a, b) {
                    for (var c = 1; b > c; c += 2) a.push(c);
                    return a
                }),
                lt: k(function(a, b, c) {
                    for (var d = 0 > c ? c + b: c; --d >= 0;) a.push(d);
                    return a
                }),
                gt: k(function(a, b, c) {
                    for (var d = 0 > c ? c + b: c; ++d < b;) a.push(d);
                    return a
                })
            }
        },
        A.pseudos.nth = A.pseudos.eq;
        for (x in {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) A.pseudos[x] = i(x);
        for (x in {
            submit: !0,
            reset: !0
        }) A.pseudos[x] = j(x);
        m.prototype = A.filters = A.pseudos,
        A.setFilters = new m,
        D = b.compile = function(a, b) {
            var c, d = [],
            e = [],
            f = V[a + " "];
            if (!f) {
                for (b || (b = n(a)), c = b.length; c--;) f = t(b[c]),
                f[P] ? d.push(f) : e.push(f);
                f = V(a, u(e, d))
            }
            return f
        },
        y.sortStable = P.split("").sort(W).join("") === P,
        y.detectDuplicates = !!G,
        H(),
        y.sortDetached = f(function(a) {
            return 1 & a.compareDocumentPosition(I.createElement("div"))
        }),
        f(function(a) {
            return a.innerHTML = "<a href='#'></a>",
            "#" === a.firstChild.getAttribute("href")
        }) || g("type|href|height|width",
        function(a, b, c) {
            return c ? void 0 : a.getAttribute(b, "type" === b.toLowerCase() ? 1 : 2)
        }),
        y.attributes && f(function(a) {
            return a.innerHTML = "<input/>",
            a.firstChild.setAttribute("value", ""),
            "" === a.firstChild.getAttribute("value")
        }) || g("value",
        function(a, b, c) {
            return c || "input" !== a.nodeName.toLowerCase() ? void 0 : a.defaultValue
        }),
        f(function(a) {
            return null == a.getAttribute("disabled")
        }) || g(eb,
        function(a, b, c) {
            var d;
            return c ? void 0 : a[b] === !0 ? b.toLowerCase() : (d = a.getAttributeNode(b)) && d.specified ? d.value: null
        }),
        "function" == typeof define && define.amd ? define(function() {
            return b
        }) : "undefined" != typeof c && c.exports ? c.exports = b: a.Sizzle = b
    } (window)
}),
define("script/tools/tmb_event", [],
function(require, exports, module) {
    function getPage(a, b) {
        return $support.touch ? a.changedTouches[0][b] : a[b]
    }
    var $support = {
        transform3d: "WebKitCSSMatrix" in window,
        touch: -1 == navigator.userAgent.indexOf("35Phone") ? "ontouchstart" in window: !1
    },
    $E = {
        start: $support.touch ? "touchstart": "mousedown",
        move: $support.touch ? "touchmove": "mousemove",
        end: $support.touch ? "touchend": "mouseup",
        transEnd: "webkitTransitionEnd"
    },
    tmbEvent = function(a, b, c) {
        var d = this;
        return d._clickFun = b || null,
        d._click = !1,
        d.css = c,
        "object" == typeof a ? d.element = a: "string" == typeof a && (d.element = document.getElementById(a)),
        d.attribute = d.element.getAttribute("onclick"),
        d.element.removeAttribute("onclick"),
        d.element.addEventListener($E.start, d, !1),
        d.element.addEventListener($E.move, d, !1),
        d.element.addEventListener($E.end, d, !1),
        document.addEventListener($E.end, d, !1),
        d
    };
    tmbEvent.prototype = {
        handleEvent: function(a) {
            var b = this;
            switch (a.type) {
            case $E.start:
                b._touchStart(a);
                break;
            case $E.move:
                b._touchMove(a);
                break;
            case $E.end:
                b._touchEnd(a)
            }
        },
        _touchStart: function(a) {
            var b = this;
            b.start = !0,
            b._click = !0,
            b.startPageX = getPage(a, "pageX"),
            b.startPageY = getPage(a, "pageY"),
            b.startTime = a.timeStamp,
            b.css && !b.touchTime && (b.touchTime = setTimeout(function() {
                b._click && b.element.className.indexOf(b.css) < 0 && (b.element.className += " " + b.css)
            },
            50))
        },
        _touchMove: function(a) {
            var b = this;
            if (b.start) {
                var c = getPage(a, "pageX"),
                d = getPage(a, "pageY"),
                e = c - b.startPageX,
                f = d - b.startPageY; (Math.abs(e) > 10 || Math.abs(f) > 10) && b._click && (clearTimeout(b.touchTime), b.touchTime = null, b._click = !1, b.css && (b.element.className = b.element.className.replace(" " + b.css, "")))
            }
        },
        _touchEnd: function(event) {
            var self = this;
            if (1 == self.start && (self.touchTime && (clearTimeout(self.touchTime), self.touchTime = null), self.start = !1, self.css && (self.element.className = self.element.className.replace(" " + self.css, "")), self._click)) {
                if (self._click = !1, event.timeStamp - self.startTime > 1e3) return;
                self._clickFun && self._clickFun(self.element),
                self.attribute && eval(self.attribute)
            }
        },
        destroy: function() {
            var a = this;
            a.element.removeEventListener($E.start, a),
            a.element.removeEventListener($E.move, a),
            a.element.removeEventListener($E.end, a),
            document.removeEventListener($E.end, a)
        }
    },
    module.exports = tmbEvent
}),
define("script/tools/tmb_flip", [],
function(a, b, c) {
    function d(a) {
        return "translate(" + a + "px, 0px) scale(1) translateZ(0px)"
    }
    function e(a) {
        return "translate(0px, " + a + "px) scale(1) translateZ(0px)"
    }
    function f(a, b) {
        return h.touch ? a.changedTouches[0][b] : a[b]
    }
    function g(a, b, c, f, g, h, j, k, l, m, n, o) {
        var p = this;
        return p.conf = {},
        p.touchEnabled = !0,
        p.currentPoint = 0,
        p.prevPoint = 0,
        p.currentXY = 0,
        p.stopXY = 0,
        p.timer = -1,
        p._locked = f,
        p.autoPlayFlag = !1,
        p.endFun = c || null,
        p.eClick = h || {},
        p.transEnd = g || null,
        p.nodes = [],
        p.offsetW = 0,
        p.distance = [],
        p.showLength = j || 1,
        p.multiple = k || 1,
        p.imageArray = l || [],
        p.defaultImage = m || "",
        p.loadImage = n || p.defaultImage,
        p.imageFlag = o || "100% 100%",
        p.dir = b || "H",
        a.nodeType && 1 == a.nodeType ? p.element = a: "string" == typeof a && (p.id = a, p.element = document.getElementById(a) || document.querySelector(a)),
        p.element.style.webkitTransform = "H" == p.dir ? d(0) : e(0),
        p.refresh(),
        p.element.parentNode.addEventListener(i.start, p, !1),
        p.element.parentNode.addEventListener(i.move, p, !1),
        p.element.addEventListener(i.transEnd, p, !1),
        document.addEventListener(i.end, p, !1),
        p
    }
    var h = {
        transform3d: !1,
        touch: "ontouchstart" in window
    },
    i = {
        start: h.touch ? "touchstart": "mousedown",
        move: h.touch ? "touchmove": "mousemove",
        end: h.touch ? "touchend": "mouseup",
        transEnd: "webkitTransitionEnd"
    };
    g.prototype = {
        handleEvent: function(a) {
            var b = this;
            switch (a.type) {
            case i.start:
                b._touchStart(a);
                break;
            case i.move:
                b._touchMove(a);
                break;
            case i.end:
                b._touchEnd(a);
                break;
            case "click":
                b._click(a);
                break;
            case i.transEnd:
                b.transEnd && b.transEnd(a)
            }
        },
        addSection: function(a) {
            var b = this;
            b.element.appendChild(a),
            b.refresh()
        },
        getSection: function(a) {
            var b = this,
            c = b.nodes[a];
            return c.childNodes[1] && c.childNodes[1].childNodes[1] ? c.childNodes[1].childNodes[1].childNodes[1] : c
        },
        refresh: function() {
            var a = this,
            b = a.conf;
            a.maxPoint = b.point ||
            function() {
                var b, c = a.element.childNodes,
                d = 0,
                e = 0,
                f = c.length,
                g = 0;
                for (g = "H" == a.dir ? a.element.offsetLeft + a.element.offsetWidth: a.element.offsetTop + a.element.offsetHeight; f > e; e++) {
                    b = c[e],
                    a.distance[e] = 0;
                    var h = 0;
                    h = "H" == a.dir ? b.offsetLeft + b.offsetWidth: b.offsetTop + b.offsetHeight,
                    g > h && (a.showLength = e + 1),
                    1 === b.nodeType && (a.nodes[d] = b, d++)
                }
                return d > 0 && d--,
                d - a.showLength + 1
            } (),
            a.moveToPoint(a.currentPoint),
            a.imageArray.length > 0 && (a.initDistance(), a.loadShowImage())
        },
        hasNext: function() {
            var a = this;
            return a.currentPoint < a.maxPoint
        },
        hasPrev: function() {
            var a = this;
            return a.currentPoint > 0
        },
        toNext: function() {
            var a = this;
            a.hasNext() && a.moveToPoint(a.currentPoint + 1)
        },
        toPrev: function() {
            var a = this;
            a.hasPrev() && a.moveToPoint(a.currentPoint - 1)
        },
        toRepeat: function(a, b) {
            var c = this,
            d = b || 3e3,
            e = a || 1;
            clearTimeout(c.timer),
            c.autoPlayFlag = !0,
            c.timer = setTimeout(function() {
                var a = c.maxPoint,
                b = c.currentPoint + e;
                b > a ? (b = 0, c.moveToPoint(b, 0)) : c.moveToPoint(b),
                c.toRepeat(e, d)
            },
            d)
        },
        cancelRepeat: function() {
            var a = this;
            a.autoPlayFlag = !1,
            clearTimeout(a.timer)
        },
        initDistance: function() {
            var a = this,
            b = 0;
            b = a.currentPoint < a.maxPoint ? a.currentPoint + a.showLength: a.currentPoint,
            a.distance[a.currentPoint] = "H" == a.dir ? parseInt(window.getComputedStyle(a.element.children.item(b), null).width) : parseInt(window.getComputedStyle(a.element.children.item(b), null).height),
            a.distance[a.currentPoint] = a.distance[a.currentPoint] / a.multiple,
            a.maxXY = a.conf.maxXY ? -a.conf.maxXY: -a.distance[a.currentPoint] * a.maxPoint
        },
        moveToPoint: function(a, b) {
            var c = this;
            time = "undefined" != typeof b ? b: 500,
            c.autoPlayFlag ? (c.nodes[c.currentPoint].children[1].style.webkitTransitionDuration = time + "ms", c.nodes[c.currentPoint].children[1].style.opacity = 1) : c.nodes[c.currentPoint].children[1].style.opacity = 0,
            c.prevPoint = c.currentPoint,
            c.initDistance(),
            c.currentPoint = 0 > a ? 0 : a > c.maxPoint ? c.maxPoint: parseInt(a);
            for (var d = 0,
            e = 0; e < c.currentPoint; e++) d += -parseInt(c.distance[e]);
            c.element.style.webkitTransitionDuration = time + "ms",
            c._setXY(d),
            c.autoPlayFlag ? (c.nodes[c.currentPoint].children[1].style.webkitTransitionDuration = "0ms", c.nodes[c.currentPoint].children[1].style.opacity = 1, setTimeout(function() {
                c.nodes[c.currentPoint].children[1].style.webkitTransitionDuration = time + "ms",
                c.nodes[c.currentPoint].children[1].style.opacity = 0
            },
            1)) : c.nodes[c.currentPoint].children[1].style.opacity = 0;
            var f = document.createEvent("Event");
            f.initEvent("css3flip.moveend", !0, !1),
            c.element.dispatchEvent(f),
            c.imageArray.length > 0 && c.loadShowImage()
        },
        _touchEnd: function(a) {
            var b = this;
            if (b.scrolling) {
                b._locked && (a.preventDefault(), a.stopPropagation()),
                b.scrolling = !1,
                b.offsetW = Math.abs(b.currentXY);
                var c = 0;
                c = b.currentPoint + b.direction <= b.maxPoint ? b.currentPoint + b.direction: b.currentPoint,
                b.moveToPoint(c),
                "H" == b.dir && b.currentPoint == c,
                setTimeout(function() {
                    b.element.parentNode.removeEventListener("click", b, !0)
                },
                200),
                b.endFun && b.currentPoint != c && b.endFun();
                var d = f(a, "pageX"),
                e = f(a, "pageY");
                b.eClick && Math.abs(b.startPageX - d) < 10 && Math.abs(b.startPageY - e) < 10 && a.timeStamp - b.startTime < 500 && b.eClick(b)
            }
        },
        _setXY: function(a) {
            var b = this;
            b.currentXY = a,
            b.element.style.webkitTransform = "H" == b.dir ? d(a) : e(a)
        },
        _touchStart: function(a) {
            var b = this;
            b._locked && (a.preventDefault(), a.stopPropagation()),
            b.touchEnabled && (h.touch || a.preventDefault(), b.element.style.webkitTransitionDuration = "0", b.scrolling = !0, b.moveReady = !1, b.startPageX = f(a, "pageX"), b.startPageY = f(a, "pageY"), b.basePage = "H" == b.dir ? b.startPageX: b.startPageY, b.direction = 0, b.startTime = a.timeStamp)
        },
        _touchMove: function(a) {
            var b = this;
            if (b._locked && (a.preventDefault(), a.stopPropagation()), b.scrolling) {
                var c, d, e, g, h = f(a, "pageX"),
                i = f(a, "pageY");
                b.moveReady || (e = Math.abs(h - b.startPageX), g = Math.abs(i - b.startPageY), "H" == b.dir ? e > g && e > 5 && (a.preventDefault(), b.moveReady = !0, b.element.parentNode.addEventListener("click", b, !0)) : g > e && g > 5 ? (b.moveReady = !0, b.element.parentNode.addEventListener("click", b, !0)) : e > 5 && (b.scrolling = !1)),
                b.moveReady && (c = "H" == b.dir ? h - b.basePage: i - b.basePage, d = b.currentXY + c, (d >= 0 || d < b.maxXY) && (d = Math.round(b.currentXY + c / 3)), b._setXY(d), b.direction = c > 0 ? -1 : 1),
                b.basePage = "H" == b.dir ? h: i
            }
        },
        loadShowImage: function() {
            for (var a = this,
            b = 0; b < a.element.children.length; b++) {
                var c = 0,
                d = 0;
                if (a.currentPoint - a.showLength < 0 ? (c = a.element.children.item(b).offsetLeft - a.currentPoint * a.distance[0], d = a.element.children.item(b).offsetTop - a.currentPoint * a.distance[0]) : (c = a.element.children.item(b).offsetLeft - a.currentPoint * a.distance[a.currentPoint - a.showLength], d = a.element.children.item(b).offsetTop - a.currentPoint * a.distance[a.currentPoint - a.showLength]), a.element.offsetWidth - c > 0 && "H" == a.dir || a.element.offsetHeight - d > 0 && "H" != a.dir) for (var e = a.element.children.item(b).querySelectorAll("*"), f = 0; f < e.length; f++) {
                    var g = a.loadImage.replaceAll("\\../", "");
                    if (e[f].style.backgroundImage.indexOf(g) > -1) {
                        var h = new Image;
                        h.src = a.imageArray[b]; {
                            var i = e[f];
                            a.imageArray[b]
                        } !
                        function() {
                            var b = i;
                            h.onload = function() {
                                b.style.backgroundSize = a.imageFlag,
                                b.style.backgroundImage = "url(" + this.src + ")"
                            },
                            h.onerror = function() {
                                b.style.backgroundSize = a.imageFlag,
                                b.style.backgroundImage = "url(" + a.defaultImage + ")"
                            }
                        } (window)
                    }
                }
            }
        },
        _click: function() {},
        destroy: function() {
            var a = this;
            a.element.parentNode.removeEventListener(i.start, a),
            a.element.parentNode.removeEventListener(i.move, a),
            a.element.removeEventListener(i.transEnd, a),
            document.removeEventListener(i.end, a)
        }
    },
    String.prototype.replaceAll = function(a, b) {
        var c = new RegExp(a, "g"),
        d = this.replace(c, b);
        return d
    },
    c.exports = {
        tmbFlip: g
    }
}),
define("script/tools/tmb_gesture", [],
function(a, b, c) {
    function d(a, b) {
        return e.touch ? a.changedTouches[0][b] : a[b]
    }
    var e = {
        transform3d: "WebKitCSSMatrix" in window,
        touch: "ontouchstart" in window
    },
    f = {
        start: e.touch ? "touchstart": "mousedown",
        move: e.touch ? "touchmove": "mousemove",
        end: e.touch ? "touchend": "mouseup",
        transEnd: "webkitTransitionEnd"
    },
    g = function(a, b, c, d, e) {
        var g = this,
        h = 50;
        return g.Max = {
            X: h,
            Y: h
        },
        g.endFun = c || null,
        g.moveFun = b || null,
        g.transEnd = e || null,
        g.type = "",
        g._locked = d,
        g.start = !1,
        "object" == typeof a ? g.element = a: "string" == typeof a && (g.element = document.getElementById(a)),
        g.element.addEventListener(f.start, g, !1),
        g.element.addEventListener(f.move, g, !1),
        g.element.addEventListener(f.transEnd, g, !1),
        document.addEventListener(f.end, g, !1),
        g
    };
    g.prototype = {
        handleEvent: function(a) {
            var b = this;
            switch (a.type) {
            case f.start:
                b._touchStart(a);
                break;
            case f.move:
                b._touchMove(a);
                break;
            case f.end:
                b._touchEnd(a);
                break;
            case "click":
                b._click(a);
                break;
            case f.transEnd:
                b.transEnd && b.transEnd(a)
            }
        },
        _touchStart: function(a) {
            var b = this;
            b.start = !0,
            e.touch || a.preventDefault(),
            b._locked && a.stopPropagation(),
            b.type = "",
            b.startPageX = d(a, "pageX"),
            b.startPageY = d(a, "pageY"),
            b.startTime = a.timeStamp
        },
        _touchMove: function(a) {
            var b = this;
            if (b.start) {
                var c = d(a, "pageX"),
                e = d(a, "pageY"),
                f = c - b.startPageX,
                g = e - b.startPageY;
                b._locked && (a.preventDefault(), a.stopPropagation()),
                Math.abs(f) > Math.abs(g) && f < -b.Max.X && (b.type = "left"),
                Math.abs(f) > Math.abs(g) && f > b.Max.X && (b.type = "right"),
                Math.abs(f) < Math.abs(g) && g < -b.Max.Y && (b.type = "up"),
                Math.abs(f) < Math.abs(g) && g > b.Max.Y && (b.type = "down"),
                b.moveFun && b.moveFun(b.element, f, g)
            }
        },
        _touchEnd: function(a) {
            var b = this;
            if (b._locked && (a.preventDefault(), a.stopPropagation()), 1 == b.start) {
                var c = d(a, "pageX"),
                e = d(a, "pageY"),
                f = c - b.startPageX,
                g = e - b.startPageY;
                b.endFun && b.endFun(b.element, f, g, b.type),
                b.start = !1
            }
        },
        _click: function(a) {
            a.stopPropagation(),
            a.preventDefault()
        },
        destroy: function() {
            var a = this;
            a.element.parentNode.removeEventListener(f.start, a),
            a.element.parentNode.removeEventListener(f.move, a),
            a.element.removeEventListener(f.transEnd, a),
            document.removeEventListener(f.end, a)
        }
    },
    c.exports = g
}),
define("script/app/common/common", ["script/tools/sizzle.js", "script/tools/tmb_event.js", "script/tools/lazyloadimage.js", "script/tools/tmb_gesture.js"],
function(a, b, c) {
    function d(a) {
        h("audio")[0] && h("audio")[0].pause(),
        h("#menu_more_outer")[0] && (h("#menu_more_outer")[0].style[k] = "translate(0px,0px) scale(1) translateZ(0px) rotate(0deg)"),
        h("#share_outer")[0] && (h("#share_outer")[0].style.display = "none"),
        h(".player_outer")[0] && "none" != h(".player_outer")[0].style.display && seajs.use("script/app/detail/player",
        function(a) {
            a.stopPlay()
        }),
        "#page_index" == a.name ? seajs.use("script/app/index/main",
        function(a) {
            a.init(1)
        }) : "#page_list" == a.name ? seajs.use("script/app/list/piclist",
        function(b) {
            b.init(a.url)
        }) : "#page_zk_list" == a.name ? seajs.use("script/app/list/zklist",
        function(b) {
            b.init(a.url)
        }) : "#page_recommend" == a.name ? seajs.use("script/app/user/recommend",
        function(b) {
            b.init(a.url)
        }) : "#page_detail" == a.name ? window.location.href = "index.html": "#page_yy_detail" == a.name ? seajs.use("script/app/detail/yydetail",
        function(b) {
            b.init(a.url)
        }) : "#page_player" == a.name && seajs.use("script/app/detail/player",
        function(b) {
            b.init(a.url)
        })
    }
    function e() {
        var a = h(".menu_button");
        if (a[0].innerHTML.indexOf("菜单") > -1) {
            for (var b = 0; b < a.length - 1; b++) a[b + 1].style.display = "block",
            a[b + 1].style[l] = "400ms",
            a[b + 1].removeEventListener("webkitTransitionEnd", g, !1),
            function() {
                var c = b + 1,
                d = -Math.sin(2 * Math.PI / 360 * (30 * b + .1)) * a[b + 1].offsetHeight / 2.5 * 6.25,
                e = -Math.cos(2 * Math.PI / 360 * (30 * b + .1)) * a[b + 1].offsetHeight / 2.5 * 6.25;
                setTimeout(function() {
                    a[c].style[k] = "translate(" + d + "px, " + e + "px) scale(1) translateZ(0px) rotate(360deg)"
                },
                0)
            } ();
            h(".menu_button")[0].innerHTML = "<span>收起</span>"
        } else {
            h(".menu_button")[0].innerHTML = "<span>菜单</span>";
            for (var b = 0; b < a.length - 1; b++) a[b + 1].style[k] = "translate(0px,0px) scale(1) translateZ(0px) rotate(0deg)",
            function() {
                var c = a[b + 1];
                c.addEventListener("webkitTransitionEnd", g, !1)
            } ()
        }
    }
    function f(b) {
        var c = 0,
        d = 0;
        1 == b && (d = 500, c = -window.innerWidth),
        2 == b && (d = 500),
        h("#menu_more_outer")[0].style[l] = d + "ms",
        h("#menu_more_outer")[0].style[k] = "translate(" + c + "px,0px) scale(1) translateZ(0px)"; {
            var e = a("script/tools/tmb_gesture.js");
            new e("menu_more_outer",
            function() {},
            function(a, b, c, d) {
                "right" == d && f(2)
            },
            !1,
            function() {})
        }
    }
    function g() {
        this.style.display = "none"
    }
    var h = a("script/tools/sizzle.js"),
    i = a("script/tools/tmb_event.js");
    window.addEventListener("popstate",
    function(a) {
        a.state && d(a.state)
    },
    !1),
    window.onscroll = function() {
        if ("block" == h("#page_list")[0].style.display) {
            var b = a("script/tools/lazyloadimage.js");
            b.loadInScreenImage("list_image_outer")
        }
        if ("block" == h("#page_zk_list")[0].style.display) {
            var b = a("script/tools/lazyloadimage.js");
            b.loadInScreenImage("zk_image_area")
        }
    },
    hideDialogTips = function(a) {
        h("#info_dialog_outer")[0].style.opacity = 0,
        h("#info_dialog_outer")[0].style[k] = "translate(150%,0)",
        1 == a && window.history.go( - 1)
    };
    var j = {
        buildHeader: function(a, b, c) {
            if (h(".bheader")[0] && (h(".bheader")[0].style.display = "none"), h(c + " .header")[0]) h(c + " .header .big_title")[0].innerHTML = "<span>" + a + "</span>";
            else {
                var d = '<div class="color_area"><div style="background-color: #fa6f57"></div>';
                d += '<div style="background-color: #a1d36e"></div><div style="background-color: #55c1e7"></div>',
                d += '<div style="background-color: #5c94e9"></div></div>',
                d += '<div class="header_title_outer">',
                d += '<div class="big_title"><span>' + a + "</span></div>",
                d += '<div class="sub_title"><span>' + b + "</span></div>";
                var e = document.createElement("div");
                e.className = "header",
                e.innerHTML = d,
                e.style.display = "block",
                h(c)[0].appendChild(e)
            }
            h(c + " .header")[0].style.display = "block"
        },
        buildBackHeder: function() {
            if (!h(".bheader")[0]) {
                var a = document.createElement("div");
                a.className = "bheader fixed",
                a.innerHTML = '<div class="bheader_back" on' + j.getEvent() + '="window.history.go(-1)"><span>返回</span></div>',
                h("body")[0].appendChild(a)
            }
            h(".bheader")[0].style.display = "block"
        },
        initMoreMenu: function(a) {
            var b = this,
            c = document.createElement("div");
            c.className = "more_menu_area";
            for (var d = 0; d < a.length; d++) {
                if (2 != a[d].extendedAttr.tplChannel) {
                    var e = document.createElement("div");
                    e.className = "more_menu_line";
                    var g = a[d].extendedAttr.tplChannel;
                    "enterprise" == a[d].channelPath ? (g = -1, e.innerHTML = "<img src='" + image_path + a[d].img + "' />&nbsp;<span>" + a[d].extendedAttr.companyname + "</span>") : e.innerHTML = "<img src='" + image_path + a[d].img + "' >&nbsp;<span>" + a[d].name + "</span>",
                    function() {
                        var c = g,
                        i = server_path + a[d].actionUrl,
                        k = a[d].name,
                        l = a[d];
                        e.addEventListener(j.getEvent(),
                        function() {
                            b.tmb_touch("more_menu_line_foucs",
                            function() {
                                f(0),
                                1 == c ? seajs.use("script/app/list/zklist",
                                function(a) {
                                    a.appVar.actionUrl != i && (h("#page_zk_list")[0].innerHTML = ""),
                                    a.init(i),
                                    j.saveState(k, "#page_zk_list", i, 1)
                                }) : -1 == c ? window.location.href = l.extendedAttr.companyUrl: 4 == c ? seajs.use("script/app/user/recommend",
                                function(a) {
                                    a.init(i),
                                    j.saveState(k, "#page_recommend", i, 1)
                                }) : seajs.use("script/app/detail/yydetail",
                                function(a) {
                                    a.init(i, l),
                                    j.saveState(k, "#page_yy_detail", i, 1)
                                })
                            })
                        },
                        !1)
                    } ()
                }
                c.appendChild(e)
            }
            h("#menu_more_content")[0].appendChild(c),
            h("#menu_more_left")[0].addEventListener(j.getEvent(),
            function() {
                b.tmb_touch("",
                function() {
                    f(2)
                })
            },
            !1)
        },
        prefixStyle: function(a) {
            var b = document.createElement("div").style,
            c = function() {
                for (var a, c = "t,webkitT,MozT,msT,OT".split(","), d = 0, e = c.length; e > d; d++) if (a = c[d] + "ransform", a in b) return c[d].substr(0, c[d].length - 1);
                return ! 1
            } ();
            return "" === c ? a: (a = a.charAt(0).toUpperCase() + a.substr(1), c + a)
        },
        pageSwitch: function(a) {
            d(a)
        },
        showMenuEntrance: function() {
            var a = this,
            b = h(".menu_button");
            if ("block" != b[0].style.display) {
                b[0].style.display = "block",
                b[0].addEventListener(a.getEvent(), e, !1);
                for (var c = 0; c < b.length - 1; c++) b[c + 1].addEventListener(a.getEvent(),
                function() {
                    myApp.button1 == this.children[1].innerText && (window.location.href = myApp.url1),
                    "播放" == this.children[1].innerText && (h("audio")[0].play(), "block" == h("#page_player")[0].style.display ? seajs.use("script/app/detail/player",
                    function(a) {
                        a.appVar.playFlag || a.play()
                    }) : seajs.use("script/app/index/main",
                    function(a) {
                        var b = a.appVar.loopData[a.appVar.loopIndex].url,
                        c = a.appVar.loopData[a.appVar.loopIndex].name;
                        seajs.use("script/app/detail/player",
                        function(a) {
                            a.appVar.actionUrl != b && (h("#page_player")[0].innerHTML = ""),
                            a.init(b, void 0, 0, !0),
                            j.saveState(c, "#page_player", b, 1)
                        })
                    })),
                    myApp.button2 == this.children[1].innerText && (setTimeout(function(){document.getElementById('mcover').style.display='block';}, 400)),
                    myApp.button3 == this.children[1].innerText && (window.location.href = myApp.url3),e()
                    /*"更多" == this.children[1].innerText && f(1),
                    e()*/
                },
                !1)
            }
        },
        getSystemAgent: function() {
            var a = {
                sys: "pc",
                browser: ""
            },
            b = navigator.userAgent,
            c = b.indexOf("iPhone") > -1 || b.indexOf("iPod") > -1,
            d = b.indexOf("iPad") > -1,
            e = c || d,
            f = b.indexOf("Android") > -1,
            g = b.indexOf("MicroMessenger") > -1;
            return e && (a.sys = "ios"),
            f && (a.sys = "android"),
            g && (a.browser = "weixin"),
            a
        },
        getEvent: function() {
            var a = "mousedown";
            return "ontouchstart" in window && -1 == navigator.userAgent.indexOf("35Phone") && (a = "touchstart"),
            a
        },
        showLoadTips: function() {
            h("#load_area")[0].style.display = "block"
        },
        hideLoadTips: function() {
            h("#load_area")[0].style.display = "none"
        },
        showDialogTips: function(a) {
            if (!document.querySelector("#info_tips_inner")) {
                var b = '<div id="info_tips_inner"><div class="tips_dialog_title">提示对话框</div>';
                b += '<div class="dialog_triangle_outer"><img src="image/triangle.png" /></div>',
                b += '<div class="tips_dialog_content css3_center"></div>',
                b += '<div class="tips_dialog_fn_outer css3_center">',
                b += '<div onmousedown="hideDialogTips(1)" class="tips_dialog_button" ><span>返回</span></div></div></div>',
                h("#info_dialog_outer")[0].innerHTML = b
            }
            h(".tips_dialog_content")[0].innerHTML = "<div style='line-height:1.75em;'><span>" + a + "</span></div>",
            h("#info_dialog_outer")[0].style[k] = "translate(0,0)",
            h("#info_dialog_outer")[0].style.opacity = 1
        },
        hideSublingPage: function(a) {
            for (var b = a.parentNode,
            c = 0; c < b.children.length; c++) b.children[c].id != a.id ? a.id != b.children[c].id && (b.children[c].style.display = "none") : b.children[c].style.display = "block"
        },
        saveState: function(a, b, c, d) {
            var e = this,
            f = {
                title: a,
                name: b,
                url: c
            };
            e.replaceHistoryState(f, a, b + "?state=" + encodeURIComponent(JSON.stringify(f)), d)
        },
        replaceHistoryState: function(a, b, c, d) {
            window.history.pushState && (0 == d ? window.history.replaceState(a, b, c) : window.history.pushState(a, b, c))
        },
        setSystemInfo: function(a) {
            var b = a;
            localStorage.setItem("systemInfo", JSON.stringify(b))
        },
        getSystemInfo: function() {
            return JSON.parse(localStorage.getItem("systemInfo"))
        },
        tmb_touch: function(a, b) {
            if (navigator.userAgent.indexOf("35Phone") > -1) b();
            else {
                var c = event.currentTarget;
                c.tmbTouch || (c.tmbTouch = new i(c, b, a), c.tmbTouch._touchStart(event))
            }
        },
        initCssFile: function(a, b) {
            function c() {
                if (clearTimeout(h), !document.querySelector("#" + f + "FooterCss")) {
                    var e = document.createElement("div");
                    e.id = f + "FooterCss",
                    document.body.appendChild(e)
                }
                document.querySelector("#" + f + "FooterCss").offsetHeight > 0 ? (document.body.removeChild(document.querySelector("#" + f + "FooterCss")), a.shift(), d.initCssFile(a, b)) : h = setTimeout(c, 10)
            }
            var d = this;
            for (var e in a) {
                var f = a[e].substring(a[e].lastIndexOf("/") + 1, a[e].lastIndexOf(".")) + "Css";
                if (!document.querySelector("#" + f)) {
                    var g = document.createElement("link");
                    g.setAttribute("type", "text/css"),
                    g.setAttribute("rel", "stylesheet"),
                    g.setAttribute("id", f),
                    g.setAttribute("href", "../addons/tim_stralbum/style/script/list.css"),
                    g.async = !0,
                    document.getElementsByTagName("head")[0].appendChild(g);
                    var h = -1;
                    return c(),
                    void 0
                }
            }
            b()
        },
        getOtherPicSize: function(a, b) {
            function c(b) {
                return a.substring(0, a.lastIndexOf(".")) + b + e
            }
            var d = "",
            e = a.substring(a.lastIndexOf("."), a.length);
            return 0 == b && window.innerWidth >= 720 && (d = c("_720X720")),
            (1 == b && window.innerWidth >= 720 || 2 == b && window.innerWidth < 720) && (d = c("_256X256")),
            (2 == b && window.innerWidth >= 720 || 0 == b && window.innerWidth < 720) && (d = c("_512X512")),
            d
        },
        hideAddressBar: function() {
            var a = this,
            b = a.getSystemAgent(),
            c = window.navigator.standalone;
            if ("ios" == b.sys && "weixin" != b.browser && !c) {
                var d = parseInt(window.innerHeight);
                c || (d += 60),
                document.body.style.height = d + "px",
                setTimeout(scrollTo, 0, 0, 1)
            }
            if ("android" == b.sys && "weixin" != b.browser) {
                var e = parseInt(window.screen.availHeight) - document.body.offsetHeight - .04 * parseInt(window.screen.availHeight);
                0 > e && (e = 120),
                document.body.style.height = window.innerHeight + e + "px",
                setTimeout(scrollTo, 0, 0, 1)
            }
        }
    },
    k = j.prefixStyle("transform"),
    l = j.prefixStyle("transitionDuration");
    c.exports = j
});