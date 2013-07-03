<?= $this->loadView('header'); ?>
	<div class="container">

		<a href="/">
			<h1 class="title">
				<img class="icon" src="/assets/skin/flat-ui/images/icons/Book@2x.png">
				<span class="text">Annuaire de poche</span>
			</h1>
		</a>

		<div id="content" class="row-fluid">
			<div class="span4 categories">
				<div class="wrapper_categories">
					<h2>Catégories<a></h2>
					<ul class="list_categories">
						<?php 
							//print_r($list_of_categories);
							$last_level = 0;
							foreach($list_of_categories as $categoryid => $name):
								$level = substr_count($name, "-");
								$name = substr($name, $level);
							
							//echo $level . " => "  . $last_level;
							if($level > $last_level){
								echo str_repeat('<ul>', ($level-$last_level));	
							}
							if($level < $last_level){
								echo str_repeat('</ul>', ($last_level-$level));
							}

							$actived = $categoryid == $current_categoryid ? "active" : "";
						?>
							<li>
								<div class="actions">
									<a href="#wrapper_edit_category" class="edit_category" title="Editer"><span class="fui-new"></span></a>
									&nbsp;
									<a href="#" class="delete_category" title="Supprimer"><span class="fui-cross"></span></a>
								</div>
								<a href="/index.php?cat=<?= $categoryid ?>" class="<?= $actived ?>" data-id="<?= $categoryid ?>" ><?= $name ?></a>
							</li>
						<?php
							$last_level = $level;
							endforeach;
						?>
					</ul>
					<a href="#wrapper_add_category" class="btn btn-small btn-primary btn_add_category" title="Ajouter une fiche"><span class="fui-plus"></span> Catégorie</a>
					<div id="wrapper_add_category" class="wrapper_manage hide">
						<form id="add_new_catgory">
							<h4>Ajouter une catégorie</h4>
							<input type="text" value="" name="name" placeholder="Nom" class="span3">
							<p>Imbriqué sous:</p>
							<select class="select-block span3 categories dropup" name="parent_id" multiple>
								<option value="">Aucune catégorie</option>
								<?php
									foreach($list_of_categories as $categoryid => $name):
								?>
								<option value="<?= $categoryid ?>"><?= $name ?></option>
								<?php
									endforeach;
								?>
							</select>
							<button type="submit" class="btn btn-large btn-block btn-primary">Ajouter</button>
						</form>
					</div>

					<div id="wrapper_edit_category" class="wrapper_manage hide">
						<form id="edit_catgory">
							<h4>Editer une catégorie</h4>
							<input type="hidden" name="id" value="">
							<input type="text" value="" name="name" placeholder="Nom" class="span3">
							<button type="submit" class="btn btn-large btn-block btn-primary">Enregistrer</button>
						</form>
					</div>

				</div>
			</div>

			<div class="span8 sheets">
				<div class="wrapper_sheets">
					<h2>Liste des fiches</h2>
					<?php 
						if($list_of_sheets):
						foreach($list_of_sheets as $a_sheet):
					?>
						<div class="asheet" data-id="<?= $a_sheet['sheetid'] ?>">
							<div class="actions">
								<a href="#wrapper_manage_sheet"  data-type="add"  class="edit_sheet btn_manage_sheet edit" title="Editer"><span class="fui-new"></span></a>
								<a href="/index.php?a=delete_sheet&id=<?= $a_sheet['sheetid'] ?>" class="delete_sheet" title="Supprimer"><span class="fui-cross"></span></a>
							</div>
							<h4 class="title"><?= $a_sheet['title'] ?></h4>
							<p class="desc"><?= $a_sheet['description'] ?></p>
							<hr/>
						</div>
					<?php
						endforeach;
						else:
							echo '<h6 class="empty">Aucune fiche n\'est présent dans cet annuaire.</h6>';
						endif;
					?>
					<div id="wrapper_manage_sheet" class="wrapper_manage hide">
						<form id="manage_sheet">
							<h4>Ajouter / Modifier une fiche</h4>
							<input type="hidden" name="sheet_id"  value="">
							<input type="text" value="" name="sheet_title" placeholder="Titre" class="span3">
							<textarea name="sheet_desc" placeholder="Ajouter la description" class="span3" rows="4">qsdf</textarea>
							<p>Veuillez sélectionner une ou plusieurs catégories:</p>
							<select class="select-block span3 dropup sheet_categories" name="sheet_categories" multiple>
								<option value="">Sélectionner les catégories</option>
								<?php
									foreach($list_of_categories as $categoryid => $name):
								?>
								<option value="<?= $categoryid ?>"><?= $name ?></option>
								<?php
									endforeach;
								?>
							</select>
							<button type="reset" class="btn btn-large btn-block btn-danger">Annuler</button>
							<button type="submit" class="btn btn-large btn-block btn-primary">Ajouter</button>
						<form>
					</div>
					<a href="#wrapper_manage_sheet" class="btn btn-small btn-primary btn_manage_sheet add" title="Ajouter une fiche"><span class="fui-plus"></span> Fiche</a>
				</div>
			</div>

		</div>

	</div>
<?= $this->loadView('footer'); ?>
