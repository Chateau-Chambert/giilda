<section id="principal" class="drm">
    <div id="application_drm">
        <div id="contenu_etape">
		<h2>Transmission de votre DRM à la Douane</h2>
<?php if (!$drm->transmission_douane->success) :
    echo DRMConfiguration::getInstance()->getXmlTransfertEchec($cielResponse);
else: ?>
	<p>Votre DRM a été transmise avec succès sur le portail <a href="https://pro.douane.gouv.fr/">pro.douane.gouv.fr</a>.<br/><br/></p>
	<p>Pour terminer cette prodécure, vous devez vous rendre sur le site des douanes, une fois connecté sur l'espace DRM CIEL, vous pourrez valider votre DRM.<br/><br/></p>
	<p style="text-align: center;"><a href="https://pro.douane.gouv.fr/" class="btn btn-success">Se rendre sur proDouane</a>.</p>
<?php endif; ?>
<br/><br/>
<div class="row">
    <div class="col-xs-4">
        <a href="<?php echo url_for('drm_visualisation', $drm); ?>" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Retour à la visualisation de votre DRM</a>
    </div>
</div>
</div></div>
</section>
<?php
include_partial('drm/colonne_droite', array('drm' => $drm, 'isTeledeclarationMode' => true));
?>
