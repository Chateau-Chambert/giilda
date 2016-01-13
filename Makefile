all: project/cache project/log project/config/app.yml project/config/databases.yml project/bin/config.inc project/web/declaration_dev.php project/web/components/vins/vins-preview.html .views/vrac.json .views/etablissements.json .views/archivage.json .views/mouvements.json .views/ds.json .views/societe.json .views/compte.json .views/generation.json .views/drm.json project/data/latex .views/mouvementfacture.json .views/elasticsearch

project/cache:
	mkdir project/cache
	chmod g+sw,o+w project/cache

project/data/latex:
	mkdir project/data/latex
	chmod g+sw,o+w project/data/latex

project/log:
	mkdir project/log
	chmod g+sw,o+w project/log

project/config/app.yml:
	cp project/config/app.yml.example project/config/app.yml

project/config/databases.yml:
	cp project/config/databases.yml.example project/config/databases.yml
	mkdir -p .views

project/bin/config.inc:
	cp project/bin/config.example.inc project/bin/config.inc

project/web/declaration_dev.php:
	cp project/web/declaration_dev.php.example project/web/declaration_dev.php

project/web/components/vins/vins-preview.html: project/web/components/vins/fontcustom.yml project/web/components/vins/svg/bouteille.svg  project/web/components/vins/svg/mouts.svg  project/web/components/vins/svg/raisins.svg  project/web/components/vins/svg/vrac.svg
	cd project/web/components/vins ; fontcustom compile -c fontcustom.yml

.views/vrac.json: project/config/databases.yml project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.contratsFromProduit.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.contratsFromProduit.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.domaines.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.domaines.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.history.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.history.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.originalPrixDefinitif.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.originalPrixDefinitif.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.soussigneidentifiant.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.soussigneidentifiant.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.statutAndType.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.statutAndType.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.stocks.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.stocks.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.vracSimilaire.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.vracSimilaire.reduce.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.contratsFromProduit.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.contratsFromProduit.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.domaines.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.domaines.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.history.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.history.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.originalPrixDefinitif.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.originalPrixDefinitif.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.soussigneidentifiant.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.soussigneidentifiant.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.statutAndType.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.statutAndType.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.stocks.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.stocks.reduce.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.vracSimilaire.map.view.js project/plugins/acVinVracPlugin/lib/model/Vrac/views/vrac.vracSimilaire.reduce.view.js > $@ || rm >@

.views/etablissements.json: project/config/databases.yml project/plugins/acVinFacturePlugin/lib/model/views/facture.etablissement.map.view.js project/plugins/acVinFacturePlugin/lib/model/views/facture.etablissement.reduce.view.js project/plugins/acVinRelancePlugin/lib/model/views/relance.etablissement.reduce.view.js project/plugins/acVinRelancePlugin/lib/model/views/relance.etablissement.map.view.js project/plugins/acVinRevendicationPlugin/lib/model/views/revendication.etablissement.reduce.view.js project/plugins/acVinRevendicationPlugin/lib/model/views/revendication.etablissement.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.findByCvi.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.region.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.all.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.findByCvi.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.all.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.douane.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.region.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.douane.map.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinFacturePlugin/lib/model/views/facture.etablissement.map.view.js project/plugins/acVinFacturePlugin/lib/model/views/facture.etablissement.reduce.view.js project/plugins/acVinRelancePlugin/lib/model/views/relance.etablissement.reduce.view.js project/plugins/acVinRelancePlugin/lib/model/views/relance.etablissement.map.view.js project/plugins/acVinRevendicationPlugin/lib/model/views/revendication.etablissement.reduce.view.js project/plugins/acVinRevendicationPlugin/lib/model/views/revendication.etablissement.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.findByCvi.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.region.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.all.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.findByCvi.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.all.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.douane.reduce.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.region.map.view.js project/plugins/acVinEtablissementPlugin/lib/model/views/etablissement.douane.map.view.js  > $@ || rm >@

.views/archivage.json: project/config/databases.yml project/plugins/acVinDocumentPlugin/lib/Archivage/views/archivage.all.map.view.js project/plugins/acVinDocumentPlugin/lib/Archivage/views/archivage.all.reduce.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinDocumentPlugin/lib/Archivage/views/archivage.all.map.view.js project/plugins/acVinDocumentPlugin/lib/Archivage/views/archivage.all.reduce.view.js > $@ || rm >@

.views/mouvements.json: project/config/databases.yml project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvement.consultation.map.view.js project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvement.consultation.reduce.view.js 
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvement.consultation.map.view.js project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvement.consultation.reduce.view.js > $@ || rm >@

.views/mouvementfacture.json: project/config/databases.yml project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvementfacture.facturation.map.view.js project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvementfacture.facturation.reduce.view.js 
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvementfacture.facturation.map.view.js project/plugins/acVinDocumentPlugin/lib/Mouvement/views/mouvementfacture.facturation.reduce.view.js > $@ || rm >@

.views/ds.json:	project/config/databases.yml project/plugins/acVinDSPlugin/lib/model/views/ds.stocks.map.view.js project/plugins/acVinDSPlugin/lib/model/views/ds.stocks.reduce.view.js project/plugins/acVinDSPlugin/lib/model/views/ds.history.map.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinDSPlugin/lib/model/views/ds.stocks.map.view.js project/plugins/acVinDSPlugin/lib/model/views/ds.stocks.reduce.view.js project/plugins/acVinDSPlugin/lib/model/views/ds.history.map.view.js > $@ || rm >@

.views/societe.json: project/config/databases.yml project/plugins/acVinSocietePlugin/lib/model/views/societe.all.reduce.view.js project/plugins/acVinSocietePlugin/lib/model/views/societe.all.map.view.js project/plugins/acVinSocietePlugin/lib/model/views/societe.export.map.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinSocietePlugin/lib/model/views/societe.all.reduce.view.js project/plugins/acVinSocietePlugin/lib/model/views/societe.all.map.view.js project/plugins/acVinSocietePlugin/lib/model/views/societe.export.map.view.js > $@ || rm >@

.views/compte.json: project/config/databases.yml project/plugins/acVinComptePlugin/lib/model/views/compte.all.reduce.view.js project/plugins/acVinComptePlugin/lib/model/views/compte.all.map.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinComptePlugin/lib/model/views/compte.all.reduce.view.js project/plugins/acVinComptePlugin/lib/model/views/compte.all.map.view.js > $@ || rm >@

.views/drm.json: project/config/databases.yml project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.stocks.map.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.all.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.all.map.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.produits.map.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.stocks.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.derniere.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.produits.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.derniere.map.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.stocks.map.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.all.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.all.map.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.produits.map.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.stocks.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.derniere.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.produits.reduce.view.js project/plugins/acVinDRMPlugin/lib/model/DRM/views/drm.derniere.map.view.js > $@ || rm >@

.views/generation.json: project/config/databases.yml project/plugins/acVinGenerationPlugin/lib/model/views/generation.history.map.view.js project/plugins/acVinGenerationPlugin/lib/model/views/generation.history.reduce.view.js project/plugins/acVinGenerationPlugin/lib/model/views/generation.creation.map.view.js project/plugins/acVinGenerationPlugin/lib/model/views/generation.creation.reduce.view.js
	perl bin/generate_views.pl project/config/databases.yml project/plugins/acVinGenerationPlugin/lib/model/views/generation.history.map.view.js project/plugins/acVinGenerationPlugin/lib/model/views/generation.history.reduce.view.js project/plugins/acVinGenerationPlugin/lib/model/views/generation.creation.map.view.js project/plugins/acVinGenerationPlugin/lib/model/views/generation.creation.reduce.view.js > $@ || rm >@

.views/elasticsearch:
	cd project ; bash bin/elastic_configure_old && touch ../.views/elasticsearch ; cd ..

clean:
	rm -f .views/*
