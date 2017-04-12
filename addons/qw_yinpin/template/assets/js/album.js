/*! m.ximalaya.com 11-11-2015 */ ! function(a) {
	function b() {
		PageBase.apply(this, arguments)
	}
	b.prototype = a.extend({}, PageBase.prototype), b.prototype.doInit = function() {
		PageBase.prototype.doInit.call(this)
	};
	var c = a(".list-sound"),
		d = a(".text-more"),
		e = new b({
			url: "/album/more_tracks",
			aid: d.attr("data-aid")
		}, c, d);
	c.on("click", "li[data-url]", e.doLocation), c.on("onstop", "[sound_id]", function() {
	//	alert(1);
		c.find(".icon-sound,.icon-playing").removeClass("icon-sound").removeClass("icon-playing")
	}), c.on("onpause", "[sound_id]", function() {
		c.find(".icon-playing").removeClass("icon-playing").addClass("icon-sound")
	}), c.on("onplaying", "[sound_id]", function(b) {
		a(b.currentTarget).parent().find(".icon:eq(0)").removeClass("icon-sound").addClass("icon-playing")
	}), a(".btn-more,.btn-open").on("click", function() {
		var b = a(this).attr("href"),
			c = a.cookie("from");
		c && a(this).attr("href", e.combineHref(b, {
			from: c
		}))
	}), soundManager.isOnReady ? e.doInit() : soundManager.onready(function() {
		e.doInit()
	})
}($);