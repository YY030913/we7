require.config({
	baseUrl: '../addons/imeepos_runner/public/',
	urlArgs: "v=7.1.8",
	paths: {
		'map': 'http://api.map.baidu.com/getscript?v=2.0&ak=F51571495f717ff1194de02366bb8da9&services=&t=20140530104353',
		'jquery': './libs/jquery.min',
		'angular': './libs/angular.min',
		'pjax': './libs/jquery.pjax',
		'core': './js/core.new',
		'swiper': './libs/swiper/js/swiper.jquery',
		'base64upload': './libs/upload_file/base64upload',
		'zepto':'./js/zepto.min',
		'zepto.touch':'./libs/zepto.touch',
		'wangEditor-mobile':'./js/default/avote/wangEditor-mobile',
		'chartCore':'./libs/chart/Chart.Core',
		'chartLine': './libs/chart/Chart.Line',
		'weixin':'http://res.wx.qq.com/open/js/jweixin-1.0.0',
		'index':'./js/index',
		'appointment':'./js/appointment',
		'tool':'./js/tool',
		'touch':'./js/touch',
		'vue':'./libs/vue.min'
	},
	shim:{
		'angular': {
			exports: 'angular',
			deps: ['jquery']
		},
		'map': {
			exports: 'BMap'
		},
		'pjax':{
			exports: '$',
			deps: ['jquery']
		},
		'core':{
			exports: 'core',
			deps: ['jquery','weixin']
		},
		'swiper':{
			exports: '$',
			deps: ['jquery']
		},
		'base64upload':{
			deps: ['jquery']
		},
		'zepto.touch':{
			exports: '$',
			deps: ['zepto']
		},
		'wangEditor-mobile':{
			exports: '___E',
			deps: ['zepto','zepto.touch']
		},
		'chartLine':{
			deps: ['chartCore']
		},
		'index':{
			deps: ['chartCore']
		}
		
	}
});