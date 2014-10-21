<?php
/**
 * Cologne Blue: A nicer-looking alternative to Standard.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

/*
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}
 */

/*
// install skin
$wgResourceModules['skins.milk'] = array(
    'styles' => array(
        'milk/screen.css' => array( 'media' => 'screen' ),
        'milk/print.css' => array( 'media' => 'print' ),
    ),
    'remoteBasePath' => &$GLOBALS['wgStylePath'],
    'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
 */

/**
 * @todo document
 * @ingroup Skins
 */
class SkinMilk extends SkinTemplate {
	var $useHeadElement = true;

    function initPage(&$out){
            SkinTemplate::initPage($out);
            $this->skinname = 'milk';
            $this->stylename = 'milk';
            $this->template = 'MilkTemplate';
    }

	function setupSkinUserCss( OutputPage $out ) {
		$out->addModuleStyles( 'mediawiki.legacy.shared' );
		$out->addModuleStyles( 'mediawiki.legacy.oldshared' );
		$out->addModuleStyles( 'skins.milk' );
	}

    function getTimestamp(){
		$timestamp = $this->getOutput()->getRevisionTimestamp();
		# No cached timestamp, load it from the database
		if ( $timestamp === null ) {
			$timestamp = Revision::getTimestampFromId( $this->getTitle(), $this->getRevisionId() );
		}
        return $timestamp;
    }
}

class MilkTemplate extends CologneBlueTemplate {
	/**
	 * @return string
	 */
	function beforeContent() {
		ob_start();
?>
<div id="content">
	<div id="topbar">
		<p id="sitetitle" role="banner">
			<a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>">
				<?php echo wfMessage( 'sitetitle' )->escaped() ?>
			</a>
		</p>
		<p id="sitesub"><?php echo wfMessage( 'sitesubtitle' )->escaped() ?></p>
		<div id="linkcollection" role="navigation">
			<div id="langlinks"><?php echo str_replace( '<br />', '', $this->otherLanguages() ) ?></div>
			<?php echo $this->getSkin()->getCategories() ?>
			<div id="titlelinks"><?php echo $this->pageTitleLinks() ?></div>
			<?php if ( $this->data['newtalk'] ) { ?>
			<div class="usermessage"><strong><?php echo $this->data['newtalk'] ?></strong></div>
			<?php } ?>
		</div>
	</div>
	<div id="article" role="main">
    <?php
    $mat_day = 86400; // 1 / 60 / 60 / 24 => 86400;
    $mat_month = 180; // 30 * 6 => 180
    $lastModified = strtotime($this->getSkin()->getTimestamp());
    $betweenTime = floor((time() - $lastModified) / $mat_day);
    if($betweenTime > $mat_month){ // over 6 month
    ?>
    <div style='color: red;'>
      注意: このページは最後に更新されてから
      <?php echo $betweenTime ?> 日が経過している記事です。
      文章が腐敗している可能性があります。その点を考慮した上で確認ください。
    </div>
    <?php } ?>

		<?php if ( $this->getSkin()->getSiteNotice() ) { ?>
		<div id="siteNotice"><?php echo $this->getSkin()->getSiteNotice() ?></div>
		<?php } ?>
		<h1 id="firstHeading" lang="<?php
			$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getCode();
			$this->html( 'pageLanguage' );
		?>"><span dir="auto"><?php echo $this->data['title'] ?></span></h1>
		<?php if ( $this->translator->translate( 'tagline' ) ) { ?>
		<p class="tagline"><?php echo htmlspecialchars( $this->translator->translate( 'tagline' ) ) ?></p>
		<?php } ?>
		<?php if ( $this->getSkin()->getOutput()->getSubtitle() ) { ?>
		<p class="subtitle"><?php echo $this->getSkin()->getOutput()->getSubtitle() ?></p>
		<?php } ?>
		<?php if ( $this->getSkin()->subPageSubtitle() ) { ?>
		<p class="subpages"><?php echo $this->getSkin()->subPageSubtitle() ?></p>
		<?php } ?>
<?php
		$s = ob_get_contents();
		ob_end_clean();

		return $s;
	}

	/**
	 * @return string
	 */
	function afterContent() {
		ob_start();
?>
	</div>
	<div id="footer" role="contentinfo">
<?php
		// Page-related links
		echo $this->bottomLinks();
		// echo "\n<br />";
		// Footer and second searchbox
    /*
		echo $this->getSkin()->getLanguage()->pipeList( array(
			$this->getSkin()->mainPageLink(),
			$this->getSkin()->aboutLink(),
			$this->searchForm( 'footer' )
		) );
    */
		//echo "\n<br />";

		// Standard footer info
		//$footlinks = $this->getFooterLinks();
		//if ( $footlinks['info'] ) {
	//		foreach ( $footlinks['info'] as $item ) {
//				echo $this->data[$item] . ' ';
//			}
//		}
?>
	</div>
</div>
<div id="mw-navigation">
	<h2><?php echo wfMessage( 'navigation-heading' )->escaped() ?></h2>
	<div id="toplinks" role="navigation">
		<p id="syslinks"><?php echo $this->sysLinks() ?></p>
		<p id="variantlinks"><?php echo $this->variantLinks() ?></p>
	</div>
	<?php echo $this->quickBar() ?>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo $wgSkinMilkGoogleAdCode ?>']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</div>
<?php
		$s = ob_get_contents();
		ob_end_clean();

		return $s;
	}
}
