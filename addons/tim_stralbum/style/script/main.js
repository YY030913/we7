define("script/app/index/main", ["script/tools/tools.js"],
function(a, b, c) {
    function d() {
        l.requestData = !0,
        i.requestData(server_path + index_url,
        function(a) {
            l.requestData = !1,
            a.channels ? e(a.channels) : j.showDialogTips("数据请求失败"),
            j.hideLoadTips(),
            h("#page_start")[0].style.display = "none"
        },
        function(a, b) {
            j.showDialogTips(b)
        })
    }
    function e(a) {
        j.hideSublingPage(h("#page_index")[0]),
        j.initMoreMenu(a);
        for (var b = [], c = 0; c < a.length; c++) if (2 == a[c].extendedAttr.tplChannel && (b = a[c]), "enterprise" == a[c].channelPath) {
            myApp.appName = a[c].name,
            myApp.titleName = a[c].extendedAttr.title,
            myApp.downloadurl = a[c].extendedAttr.download;
            var d = document.getElementById("myaudio");
            d.src = image_path + a[c].extendedAttr.attachments.split(";;")[1]
        }
        j.buildHeader(myApp.appName, myApp.titleName, "#page_index"),
        f(b);
        var e = l.loopData,
        i = '<div class="big_photo photo_out" style="background-image:url(' + e[0].img + ');">';
        i += ' <div class="photo_title"><span>' + e[0].name + "</span></div></div>",
        i += '<div class="normal_photo photo_out" style="background-image:url(' + e[1].img + ');right:5%;">',
        i += '<div class="photo_title"><span>' + e[1].name + "</span></div></div>",
        i += '<div class="normal_photo photo_out" style="background-image:url(' + e[2].img + ');left:5%; ">',
        i += '<div class="photo_title"><span>' + e[2].name + "</span></div></div>";
        var m = document.createElement("div");
        m.className = "photoBox",
        m.innerHTML = i;
        var n = document.createDocumentFragment();
        n.appendChild(m);
        var o = document.createElement("div");
        o.className = "photoPageNum",
        o.innerHTML = "<span>1/" + e.length + "</span>",
        n.appendChild(o),
        h("#page_index")[0].appendChild(n);
        var p = new k({
            data: e,
            boxDom: m,
            time: 500,
            around: !0,
            dataPos: 0
        });
        p.initNextData = function(a, b) {
            a.style.backgroundImage = "url(" + e[b].img + ")",
            a.innerHTML = '<div class="photo_title"><span>' + e[b].name + "</span></div>",
            o.innerHTML = "<span>" + (p.dataPos + 1) + "/" + e.length + "</span>",
            l.loopIndex = p.dataPos
        },
        m.addEventListener(j.getEvent(),
        function() {
            j.tmb_touch("",
            function() {
                p.moveEnd = !0,
                p.moveReady = !0,
                g(e[p.dataPos].url, e[p.dataPos].name)
            })
        },
        !1),
        j.hideAddressBar(),
        j.showMenuEntrance()
    }
    function f(a) {
        l.loopData = [];
        for (var b = 0; b < a.subChannels.length; b++) {
            var c = {
                img: image_path + a.subChannels[b].img,
                name: a.subChannels[b].name,
                url: server_path + a.subChannels[b].actionUrl
            };
            l.loopData.push(c)
        }
    }
    function g(a, b) {
        seajs.use("script/app/list/piclist",
        function(c) {
            c.appVar.actionUrl != a && (h("#page_list")[0].innerHTML = ""),
            c.init(a),
            j.saveState(b, "#page_list", a, 1)
        })
    }
    var h = a("script/tools/sizzle.js"),
    i = a("script/tools/ajax.js"),
    j = a("script/app/common/common.js"),
    k = a("script/tools/looplist"),
    l = {
        loopIndex: 0,
        loopData: [],
        requestData: !1
    };
    c.exports = {
        init: function() {
            h(".photoBox")[0] || l.requestData ? (j.buildHeader(myApp.appName, myApp.titleName, "#page_index"), j.hideSublingPage(h("#page_index")[0])) : (d(), j.replaceHistoryState({
                title: "首页",
                name: "#page_index",
                url: server_path + index_url
            },
            company_name, "#page_index", 0))
        },
        appVar: l,
        initLoopData: f
    }
});