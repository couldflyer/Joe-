<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<script>
	function detectIE() {
		var n = window.navigator.userAgent,
			e = n.indexOf("MSIE ");
		if (e > 0) {
			return parseInt(n.substring(e + 5, n.indexOf(".", e)), 10)
		}
		if (n.indexOf("Trident/") > 0) {
			var r = n.indexOf("rv:");
			return parseInt(n.substring(r + 3, n.indexOf(".", r)), 10)
		}
		var i = n.indexOf("Edge/");
		return i > 0 && parseInt(n.substring(i + 5, n.indexOf(".", i)), 10)
	};
	detectIE() && (alert('当前站点不支持IE浏览器或您开启了兼容模式，请使用其他浏览器访问或关闭兼容模式。'), (location.href = 'https://www.baidu.com'));
	
	window.Joe = {
		TITLE: `<?php $this->options->title() ?>`,
		THEME_URL: `<?php $this->options->themeUrl() ?>`,
		LIVE2D: `<?php $this->options->JLive2d() ?>`,
		BASE_API: `<?php echo $this->options->rewrite == 0 ? $this->options->rootUrl . '/index.php/joe/api' : $this->options->rootUrl . '/joe/api' ?>`,
		DYNAMIC_BACKGROUND: `<?php $this->options->JDynamic_Background() ?>`,
		IS_MOBILE: /windows phone|iphone|android/gi.test(window.navigator.userAgent),
		//BAIDU_PUSH: <?php //echo $this->options->JBaiduToken ? 'true' : 'false' ?>,
		//BING_PUSH: <?php //echo $this->options->JBingToken ? 'true' : 'false' ?>,
		DOCUMENT_TITLE: `<?php $this->options->JDocumentTitle() ?>`,
		LAZY_LOAD: `<?php joe\getLazyload() ?>`,
		BIRTHDAY: `<?php $this->options->JBirthDay() ?>`,
		MOTTO: `<?php joe\getAsideAuthorMotto() ?>`,
		PAGE_SIZE: `<?php $this->parameter->pageSize() ?>`,
		AUTO_NIGHT: `<?php $this->options->JAutoNight() ?>`,
	}
</script>
<?php
$fontUrl = $this->options->JCustomFont;
if (!$fontUrl) {
	$fontUrl = '';
}
if (strpos($fontUrl, 'woff2') !== false) $fontFormat = 'woff2';
elseif (strpos($fontUrl, 'woff') !== false) $fontFormat = 'woff';
elseif (strpos($fontUrl, 'ttf') !== false) $fontFormat = 'truetype';
elseif (strpos($fontUrl, 'eot') !== false) $fontFormat = 'embedded-opentype';
elseif (strpos($fontUrl, 'svg') !== false) $fontFormat = 'svg';
?>
<style>
	<?php
	
	if (joe\isMobile()) {
		// 移动端情况下
		// 移动端屏蔽热门文章滚动条
		if ($this->is('index')) {
			echo '.joe_index__hot-list .item>.item-body>.item-tags-category::-webkit-scrollbar {display: none;}';
		}
		// 部分背景壁纸适配优化
		if ($this->options->JWallpaper_Background_Optimal == 'all' || $this->options->JWallpaper_Background_Optimal == 'wap') {
			echo joe\background_adaptive();
		}
		// 移动端自定义背景壁纸
		if ($this->options->JWallpaper_Background_WAP) {
			echo 'html body::before {background: url(' . $this->options->JWallpaper_Background_WAP . ')}';
		}
	} else {
		// 非移动端情况下
		// 首页热门文章滚动条内部下边距
		if ($this->is('index')) {
			echo '.joe_index__hot-list .item>.item-body>.item-tags-category {padding-bottom: 3px;}';
		}

		if ($this->options->JWallpaper_Background_Optimal == 'all' || $this->options->JWallpaper_Background_Optimal == 'pc') {
			echo joe\background_adaptive();
		}

		// PC端自定义背景壁纸
		if ($this->options->JWallpaper_Background_PC) {
			echo 'html body::before {background: url(' . $this->options->JWallpaper_Background_PC . ')}';
		}
	}

	// 全局灰色
	if ($this->options->JGrey_Model == 'on') {
		echo 'html {-webkit-filter: grayscale(1);}';
	}

	if (($this->is('index') || $this->is('archive')) && $this->options->JIndex_Article_Double_Column == 'on') {
		echo '@media(min-width: 1200px) {
			.joe_aside {
				display: none;
			}
			.joe_list {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				column-gap: 15px;
			}
			.joe_list>.joe_list__item {
				border-radius: var(--radius-wrap);
			}
		}';
	}
	?>
	<?php if ($fontUrl!='') : ?>
	@font-face {
		font-family: 'Joe Font';
		font-weight: 400;
		font-style: normal;
		font-display: swap;
		<?php if (isset($fontFormat)) : ?>src: url('<?php echo $fontUrl ?>') format('<?php echo $fontFormat ?>');
		<?php else: ?>src: url('<?php echo $fontUrl ?>');
		<?php endif; ?>
	}
	<?php endif; ?>
	body {
		<?php if ($fontUrl) : ?>font-family: 'Joe Font';
		<?php else : ?>font-family: 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif;
		<?php endif; ?>
	}

	<?php $this->options->JCustomCSS() ?>
</style>
<?php
if ($this->options->JIndex_Link_Active == 'on') {
	echo '<link rel="stylesheet" href="'.joe\theme_url('assets/css/options/JIndex_Link_Active.min.css').'">';
}
?>