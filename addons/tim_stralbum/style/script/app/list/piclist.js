define("script/app/list/piclist", ["script/tools/tools.js"],
function(a, b, c) {
    function d(a) {
        l.actionUrl = a,
        i.requestData(a,
        function(a) {
            l.requestFlag = !0,
            a.page.items.length > 0 ? i.requestData(server_path + a.page.items[0].actionUrl,
            function(a) {
                try {
                    var b = document.createElement("div");
                    b.className = "list_content",
                    h("#page_list")[0].appendChild(b),
                    l.data = a.content.pictureList,
                    f(l.data)
                } catch(c) {
                    e(error)
                }
            },
            function(a, b) {
                e(b)
            }) : e("数据请求失败")
        },
        function(a, b) {
            e(b)
        })
    }
    function e(a) {
        j.showDialogTips(a),
        j.hideLoadTips()
    }
    function f(a) {
        var b = h("#page_list .list_content")[0];
        if (a.length > 0) for (var c = 0; c < a.length; c++) {
            var d = document.createElement("div");
            d.className = "list_image_outer",
            d.innerHTML = '<img class="list_image" data-src="' + image_path + a[c].imgPath + ' " data-loaded="0" src=""  /></div>',
            b.appendChild(d),
            d.addEventListener(j.getEvent(),
            function() {
                var a = this;
                j.tmb_touch("",
                function() {
                    for (var c = 0; c < b.children.length; c++) a == b.children[c] && g(c)
                })
            },
            !1)
        } else htmlStr = "<div class='nodata'><img src='image/icon_nodata.png'/></div>",
        b.innerHTML = htmlStr;
        k.loadInScreenImage("list_image_outer"),
        j.hideLoadTips(),
        j.showMenuEntrance()
    }
    function g(a) {
        seajs.use("script/app/detail/player",
        function(b) {
            l.actionUrl != b.appVar.actionUrl && (h("#page_player")[0].innerHTML = ""),
            b.init(l.actionUrl, l.data, a),
            j.saveState("播放", "#page_player", l.actionUrl, 1)
        })
    } {
        var h = a("script/tools/sizzle.js"),
        i = a("script/tools/ajax.js"),
        j = a("script/app/common/common.js"),
        k = a("script/tools/lazyloadimage.js"),
        l = {
            actionUrl: "",
            requestFlag: !0,
            data: []
        };
        j.prefixStyle("transform"),
        j.prefixStyle("transitionDuration")
    }
    c.exports = {
        init: function(a) {
            if (!h("#page_list .list_content")[0] && l.requestFlag) {
                l.requestFlag = !1;
                var b = document.createElement("div");
                b.id = "list_cover",
                h("#page_list")[0].appendChild(b),
                j.showLoadTips(),
                j.initCssFile(["style/list.css"],
                function() {
                    d(a)
                })
            }
            j.buildHeader(myApp.appName, myApp.titleName, "#page_list"),
            j.hideSublingPage(h("#page_list")[0])
        },
        appVar: l
    }
});