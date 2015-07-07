<?php

/* 
 * 
 * init
 *
 *
 */

if( !defined( 'MEDIAWIKI' ) ){
        die( "This is a skins file for mediawiki and should not be viewed directly.\n" );
}

/*
 * 
 * 
 *
 */

class WikistrapTemplate extends BaseTemplate {


        /**
         * Template filter callback for this skin.
         * Takes an associative array of data set from a SkinTemplate-based
         * class, and a wrapper for MediaWiki's localization database, and
         * outputs a formatted page.
         */
        public function execute() {

                global $wgOut, $wgRequest, $wgGroupPermissions;
 
                $skin = $this->data['skin'];
 
                // suppress warnings to prevent notices about missing indexes in $this->data
                wfSuppressWarnings();
 
                $this->html('headelement');

				/*
					$dateTime = new DateTime("now");
					$hoje = $dateTime->format("d/m/Y");
				*/
				
				$skin = $this->getSkin();

				// user
				$user = $skin->getUser();	
				$grupos = $user->getGroups();
				$titulo = $skin->getTitle();
				$eConteudo = $titulo->isContentPage();
				if ($eConteudo) {
					$pagina = $skin->getContext()->getWikiPage();
				}

				$categoriasDisponiveis = $wgOut->mCategories;
				
				/* check if page exists;
					$titleObject = Title::newFromText( 'Talk:Your desired title here' );
					if ( !$titleObject->exists() ) echo "There is no page with that name.";
				*/
				
			?>

		<?php include dirname(__FILE__) . '/wikistrap/menu.php'?>


<div class="container">

	<!--ABRE ROW PRINCIPAL-->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			<br> &nbsp;
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			
			<?php $this->cactions(); ?>
			
			<!--Site Notice-->
			<?php if( $this->data['sitenotice'] ) { ?>
				<div id="siteNotice"><?php $this->html('sitenotice') ?></div>
			<?php } ?>

			<!--Page Name-->
			<?php  if ($titulo->mTextform != "Página principal") : ?>
				<h1 id="firstHeading"><?php $this->html('title'); ?></h1>
			<?php endif; ?>
			
			<!--Undelete Notice-->
			<?php if( $this->data['undelete'] ) { ?>
				<div id="contentSub2"><?php $this->html('undelete') ?></div>
			<?php } ?>
			
			<!--User-Messages Notification-->
			<?php if( $this->data['newtalk'] ) { ?>
				<div class="usermessage"><?php $this->html('newtalk') ?></div>
			<?php } ?>

			<!--Jump-To Links-->
			<?php if($this->data['showjumplinks']) { ?>
				<div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one">
				<?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput">
				<?php $this->msg('jumptosearch') ?></a></div>
			<?php } ?>

			<br>

			<!--Page Contents-->
			<?php
				$this->html('bodytext');
				$bodytext = true;
			?>

			<?php if (!isset($bodytext)) {$this->html('bodytext');} ?>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<!--Search-->
			<div id="p-search" class="portlet well">
				<div id="searchBody" class="pBody">
					<form action="<?php $this->text('searchaction') ?>" id="searchform" class="form-vertical"><div>
						<input id="searchInput" class="input-medium" name="search" type="text"<?php 
						        if( isset($this->data['search'])) {
						                ?> value="<?php $this->text('search') ?>"<?php } ?> />
						&nbsp;
						<input type='submit' name="fulltext" class="searchButton btn" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
					</div></form>
				</div>
			</div>

			<!--User Toolbar-->
			<div class="portlet well" id="p-personal">
				<h5>Usuário</h5> <!-- User Toolbar Label/Caption [optional] -->
				<div class="pBody">
					<ul>
						<?php
						   $personalUrls = $this->data['personal_urls'];
						   
						   foreach( $personalUrls as $key => $item ) { 
								if(in_array($key,array('login','logout','mycontris','anonlogin'))) {
						?>
						
						<li id="<?php echo Sanitizer::escapeId( "pt-$key" ) ?>"<?php
								if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php echo htmlspecialchars( $item['href'] ) ?>"<?php
						if( !empty( $item['class'] ) ) { ?> class="<?php
						echo htmlspecialchars( $item['class'] ) ?>"<?php } ?>><?php
						echo htmlspecialchars( $item['text'] ) ?></a></li>
						
					<?php
							} 
						}
						if (array_key_exists('logout',$personalUrls)) {
							echo '<li><a href="/wiki/index.php?title=Especial:Trocar_senha&returnto=Especial%3APreferências">Trocar senha</a></li>';
							echo '<li><a href="/wiki/index.php/Especial:Preferências">Preferências</a></li>';
							}
					?>

					</ul>
				</div>
			</div>

			<!--Toolbox-->
				<div class="portlet well" id="p-tb">
					<?php $this->toolbox();?>
				</div>


		</div>

	<!--FECHA ROW PRINCIPAL-->
	</div>

	<div class="row">
		<!--Footer-->
		<div id="footer" class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			<!--Category Links-->
			<?php if( $this->data['catlinks'] ) { $this->html('catlinks'); } ?>


		<?php   
			if ( $this->data['copyrightico'] ) { ?>
			<div id="f-copyrightico"><?php $this->html('copyrightico') ?></div>
		<?php   }
			// generate additional footer links
			$footerlinks = array('lastmod');
		?>
		<?php
			foreach ( $footerlinks as $aLink ) {
				if ( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
		?>             		<p id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></p>
		<?php           }
			}
		?>
		</div>
	</div>

<!--FECHA CONTAINER PRINCIPAL-->
</div>

<!-- ????????? -->
<hr class="linha linha1"><hr class="linha linha2">

  <!--ABRE CONTAINER RODAPÉ-->
  <div id="footerIdea" class="rodapeEntorno">

    <!-- CONTAINER -->
    <div class="container">

      <!--abre row1b-->
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="rodapeCaixa">
        </div>
      <!--fecha row1b-->
      </div>
    </div>

  </div>
  <!--FECHA CONTAINER RODAPÉ-->


<!--Closing Trail-->
<!-- scripts and debugging information -->
<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
<?php $this->html('reporttime') ?>
<?php if ($this->data['debug']): ?>
<!-- Debug output:
<?php $this->text('debug'); ?>
-->
<?php endif; ?>

	</body>
</html>

<?php
        wfRestoreWarnings();
        } // end of execute() method



/*
 *
 *
 *
 *
 */
	public function makeSearchButton($mode, $attrs = array()) {
		switch($mode) {
			case 'go':
			case 'fulltext':
				$realAttrs = array(
					'type' => 'submit',
					'class' => 'btn',
					'name' => $mode,
					'value' => $this->translator->translate(
						$mode == 'go' ? 'searcharticle' : 'searchbutton'
					),
				);
				$realAttrs = array_merge(
					
				);
				return Html::element('input', $realAttrs);
				
			case 'image':
				$buttonAttrs = array(
					'class' => 'btn',
					'type' => 'submit',
					'name' => 'button',
				);
				$buttonAttrs = array_merge(
					$buttonAttrs,
					Linker::tooltipAndAccesskeyAttribs( 'search-fulltext' ),
					$attrs
				);
				unset($buttonAttrs['src']);
				unset($buttonAttrs['alt']);
				$imgAttrs = array(
					'src' => $attrs['src'],
					'alt' => isset( $attrs['alt'] )
						? $attrs['alt']
						: $this->translator->translate('searchbutton'),
				);
				return Html::rawElement('button', $buttonAttrs, Html::element('img', $imgAttrs));
			default:
				throw new MWException('Unknown mode passed to BaseTemplate::makeSearchButton');
		}
	} // end function

/* 
 * content actions
 */

	public function cactions() {
?>
	<ul class="nav nav-pills"><?php
		$acoes = $this->data['content_actions'];
		$acoesPermitidas = array(
			'edit',
			'delete',
			'move'
		);
		
		if ($_SESSION["wsUserID"] != 0) {
			$grupos = $this->getSkin()->getUser()->getGroups();

			if (in_array('sysop', $grupos) OR in_array('bureaucrat',$grupos)) {
				foreach($acoes as $key => $tab) {
					echo ' ' . $this->makeListItem( $key, $tab );
				} 
			} else {
				foreach($acoes as $key => $tab) {
					if (in_array($key,$acoesPermitidas)) {
						echo ' ' . $this->makeListItem($key, $tab);
					}
				} 
			}
		}
		
		$printable = $this->data['content_actions']['nstab-main']['href'].'?printable=yes';
		
		?>
		<li><a href="<?php echo $printable; ?>">Imprimir</a></li>
	</ul>
<?php
	} // end function
/*
 * toolbox
 */
	public function toolbox() {
?>
	<div class="portlet" id="p-tb">

		<h5>MediaWiki</h5>

		<div class="pBody">

			<ul>
				<?php
					$tools = $this->getToolbox();
					$allowedTools = array(
						'whatlinkshere',
						'upload',
						'print',
						'specialpages',
						'recentchangeslinked',
					);
					foreach ($tools as $key => $tbitem) {
						if (in_array($key,$allowedTools)) {
								echo $this->makeListItem($key, $tbitem);
						}
					}
					
					wfRunHooks('MonoBookTemplateToolboxEnd', array(&$this));
					wfRunHooks('SkinTemplateToolboxEnd', array(&$this, true));
				?>
			</ul>
		</div>
	</div>
<?php
	} // end function

	/**
	 * @param $bar string
	 * @param $cont array|string
	 */
	public function customBox($bar, $cont) {
		$portletAttribs = array(
			'class' => 'generated-sidebar portlet', 
			'id' => Sanitizer::escapeId( "p-$bar" ),
		);
		
		$tooltip = Linker::titleAttrib("p-$bar");
		if ($tooltip !== false) {
			$portletAttribs['title'] = $tooltip;
		}
		
		echo '	' . Html::openElement( 'div', $portletAttribs );
?>

		<h5>
			<?php 
				$msg = wfMessage($bar); 
				echo htmlspecialchars($msg->exists() ? $msg->text() : $bar); 
			?>
		</h5>

		<div class='pBody'>
	<?php
		if (is_array($cont)) {
	?>
			<ul>
		<?php 
			foreach($cont as $key => $val) {
				echo $this->makeListItem($key, $val);
			} 
		?>
			</ul>
	<?php   
		} else {
			# allow raw HTML block to be defined by extensions
			print $cont;
		}
	?>
		</div>
	</div>
<?php
	} // end function

} // end of class

/*
 * inherit main code from SkinTemplate, set the CSS and template filter
 */
class SkinWikistrap extends SkinTemplate {
        var $useHeadElement = true;
 
        public function initPage(OutputPage $out) {
                parent::initPage($out);
                $this->skinname  = 'wikistrap';
                $this->stylename = 'wikistrap';
                $this->template  = 'WikistrapTemplate';
        }
        public function setupSkinUserCss(OutputPage $out) {
            global $wgHandheldStyle;
            parent::setupSkinUserCss($out);

            // Append to the default screen common & print styles...
	        $out->addStyle('wikistrap/css/bootstrap.css', 'screen');
            $out->addStyle('wikistrap/css/theme.css', 'screen');
	        $out->addStyle('wikistrap/css/jquery-ui-1.8.16.custom.css', 'screen');
            $out->addStyle('wikistrap/css/main.css', 'screen');

            if ($wgHandheldStyle) {
				$out->addStyle('wikistrap/css/handheld.css', 'handheld');
            }
        }

}

?>

