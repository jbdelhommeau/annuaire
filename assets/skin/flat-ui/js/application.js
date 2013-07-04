(function($) {
	// Custom Select

	function AppModule(){

		var self = this;

		this.list_selector = {
			"wrapper_add_category"  : "#wrapper_add_category",
			"wrapper_edit_category" : "#wrapper_edit_category",
			"list_categories"       : ".wrapper_categories ul.list_categories",
			"edit_category"         : ".wrapper_categories ul.list_categories li .actions .edit_category",
			"delete_category"       : ".wrapper_categories ul.list_categories li .actions .delete_category",
			"btn_add_category"      : ".wrapper_categories .btn_add_category",
			"add_new_catgory"       : "#add_new_catgory",
			"edit_catgory"          : "#edit_catgory",
			"btn_manage_sheet"      : ".wrapper_sheets .btn_manage_sheet",
			"wrapper_manage_sheet"  : "#wrapper_manage_sheet",
			"manage_sheet"          : "#manage_sheet",
			"delete_sheet"          : ".wrapper_sheets .asheet .actions .delete_sheet",
			"close_wrapper_manager" : ".wrapper_manage .close"

		};

		this.init = function(){
			self.init_select();

			/*Catégories*/
			self.show_add_category();
			self.add_category();
			self.show_edit_category();
			self.edit_category();
			self.delete_category();

			/*Fiches*/
			self.show_manage_sheets();
			self.manage_sheets();
			self.delete_sheet();

			/*Close*/
			self.close_wrapper_manager();
		};

		this.init_select = function(){
			$("select.categories").selectpicker();
		};

		this.show_add_category = function(){
			$(self.list_selector.btn_add_category).click(function(){
				$(self.list_selector.wrapper_add_category).show();
				$(self.list_selector.wrapper_edit_category).hide();
				$(self.list_selector.wrapper_add_category).find('input[name="name"]').focus();
				return false;
			});

		};

		this.add_category = function(){
			$(self.list_selector.add_new_catgory).submit(function(){

				var post_data = $(this).serialize();

				$.post('/index.php?a=add_category', post_data, function(data){

					if(data == "ok"){
						window.location.href = "/";
					}else if(data == "error_name"){
						alert("Veuillez saisir un nom de catégorie.");
					}else{
						alert("Erreur lors de l'insertion en base.");
					}

				});

				return false;
			});


		};

		this.show_edit_category = function(){
			$(self.list_selector.edit_category).click(function(){
				var that = $(this),
					elm  = that.parent().next("a"),
					wrapper_edit_category = $(self.list_selector.wrapper_edit_category);

				wrapper_edit_category.find('input[name="id"]').val(elm.data("id"));
				wrapper_edit_category.find('input[name="name"]').val(elm.text());
				wrapper_edit_category.show();

				$(self.list_selector.wrapper_add_category).hide();

				wrapper_edit_category.find('input[name="name"]').focus();
			});

		};

		this.edit_category = function(){
			$(self.list_selector.edit_catgory).submit(function(){

				var post_data = $(this).serialize();

				$.post('/index.php?a=edit_category', post_data, function(data){

					if(data == "ok"){
						window.location.href = "/";
					}else if(data == "error_name"){
						alert("Veuillez saisir un nom de catégorie.");
					}else{
						alert("Erreur lors de l'insertion en base.");
					}

				});

				return false;
			});


		};

		this.delete_category = function(){
			$(self.list_selector.delete_category).click(function(){
				var that = $(this),
					elm  = that.parent().next("a");
				if(confirm("Voulez vous vraiment ?")){
					$.post('/index.php?a=delete_category', {id: elm.data("id") }, function(data){
						if(data == "ok"){
							that.closest('li').fadeOut(function(){
								$(this).remove();
							});
						}
					});
				}else{
					return false;
				}

			});
		};

		this.show_manage_sheets = function(){
			$(self.list_selector.btn_manage_sheet).click(function(evt){
				var that = $(this),
					wrapper_manage_sheet = $(self.list_selector.wrapper_manage_sheet); 

				wrapper_manage_sheet.find('input[name^="sheet"], textarea[name^="sheet"]').val("");

				wrapper_manage_sheet.find('select[name^="sheet"]').children(":selected").removeProp("selected");
				$("select.sheet_categories").selectpicker('render');

				if($(evt.target).parent().hasClass("edit")){
					var elm  = that.closest(".asheet");
					wrapper_manage_sheet.find('input[name="sheet_sheetid"]').val(elm.data("id"));
					wrapper_manage_sheet.find('input[name="sheet_title"]').val(elm.find(".title").text());
					wrapper_manage_sheet.find('textarea[name="sheet_description"]').val(elm.find(".desc").text());

					var list_of_categories = Array();
					elm.find('.category').each(function(){
						list_of_categories.push($(this).data("id"));
					});
					$("select.sheet_categories").selectpicker('val', list_of_categories);
  					$("select.sheet_categories").selectpicker('render');

				}
				wrapper_manage_sheet.show();
				wrapper_manage_sheet.find('input[name="sheet_title"]').focus();
			});

		};

		this.manage_sheets = function(){
			$(self.list_selector.manage_sheet).submit(function(){

				var post_data = $(this).serialize();

				$.post('/index.php?a=manage_sheet', post_data, function(data){

					if(!isNaN(parseInt(data))){
						window.location.href = "/#sheet_"+data;
						window.location.reload(true);
					}else if(data == "error_seizure"){
						alert("Veuillez saisir tout le champs.");
					}else{
						alert("Erreur lors de l'insertion en base.");
					}

				});
				

				return false;
			});
		};

		this.delete_sheet = function(){
			$(self.list_selector.delete_sheet).click(function(){

				var that = $(this),
					elm  = that.closest(".asheet");
				if(confirm("Voulez vous vraiment ?")){
					$.post('/index.php?a=delete_sheet', {id: elm.data("id") }, function(data){
						if(data == "ok"){
							elm.fadeOut(function(){
								$(this).remove();
							});
						}
					});
				}else{
					return false;
				}

			});
		};

		this.close_wrapper_manager = function(){
			$(self.list_selector.close_wrapper_manager).click(function(){
				$(this).parent().hide();
				return false;
			});
		};

		//initialisation du module
		this.init();
	};

	return new AppModule();

})(jQuery);