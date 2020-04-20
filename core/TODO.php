 <?php
/* 
 * BUGS/TODO:
 * 		
 * 		List view shows html that should be from tile view. 
 * 		Create a css file for each entity type and have it autoincluded
 * 
 * 		baseTable object cant add entities to calender_entities because time format in database is not compatible,
 * 			time format is being edited in baseEntity->setPropertiesFromArray(). form helper creates form fields from the
 * 			current format. User Object and Purchase Object are the only two currently using time...
 * 			Review html, and form helpers and DB creating automation before continuing!
 * 
 * 		pagination skips several pages back when scrolling up ... sometimes.
 * 		pagination goes back a page on refresh.
 * 		pagination loads a page_segement that already exists on pageload/first fire
 * 		
 * 		Search form submit not working in sm/med views, two forms exist on page with same class, so I think this cause conflict
 * 		create endless scrolling for entities view.
 * 		create options for omiting entity properties from create forms
 * 		create permission options for entity-property-view and entity-property-edit
 * 		remove uneeded writer functions for views, api, and php processors
 * 		
 * 		edit forms in an entity view don't always show entity data
 * 		
 * 		Loading the entity mapper is very slow. While not used now, if we do need it we'll need to build
 * 			it once and store it in session, or write to file...
 * 		Create time/calendar view option
 * 		Installing framework on non-Windows env will require new builds of some vendor applications
 * 		Media is unable to hook 'media_create_mid' because the instance of the media object is passed during init and it is another object at time of upload;
 *		api_helper and php_helper entity_create methods need to remove their conditional statments for media and be replaced with hook system
 * 		add property type detection to form helpers so that bool properties show up as checkbox.
 * 			How do we create options from the entity in the forms?
 * 		typing forward or back slash in to log-in form cause sql errors, possible injection?
 * 		
 * 			
 * DONE:
 * 		4.17.20 Added Week/Day views to calendars including color features
 * 		4.3..20 Added Calendar entity view select options, modified core.js
 * 		3.20.20 Added JS and CSS 
 * 		2.11.20 Added Functions to Calendar Object to assist calendar view
 * 		2.11.20 Added Functions to baseTable to paginate calenders
 * 		2.9.20 Created Calendar Button in entity menu
 * 		2.9.20 Added color naming conventions, cleaned up some css/bootstrap in the menu, added color object for holding default palettes
 * 		9.6.19 Pagination now endless, follows current page visually.
 * 		9.3.19 Pagination controls are now dynamic: edited core.js
 * 		9.3.19 Reworked pagination, adding carosel
 * 		9.2.19 Reworked Nav bar
 * 		9.2.19 Nested Search forms in entities view for cleaner looks
 * 		8.28.19 Added: create option for having an enitity have a different public name, that is not the entity name.
 * 			see: entity->config['altPublicName']
 * 		8.27.19 Added: "user_download" permission to writer
 * 		8.27.19 Added: download link to media files
 * 		8.27.19 Updated: views
 * 		6.16.19 Gixed: tools menu dropdown not working...seems like the toast is over it.
 * 		6.16.19 Added: toast to core.js
 * 		6.16.19 Added: popper and reupdated all bootstrap/jquery/css - it is also localized
 * 			orginal sourses listed in setup/jsheaders (commented)
 * 		6.15.19 Fixed: viewing a media entity doens't show it's media
 * 		6.13.19 Added: main view searches now js-update pagination
 * 		6.13.19 main view searches pagination now load proper page of entities
 * 
 * 		6.12.19 Fixed: core/view/default/write_link_child_seach_table cannot see correct permissions
 * 		6.12.19 Fixed: submitting an edit form in an entity creates a new entity
 * 		6.12.19 Fixed entity_entity_link 
 * 		6.12.19 Added getParent and getChild static function to baseEntity
 * 		6.12.19 Added Purchase and Product_Purchase entities 
 * 		6.3.19 Fixed: Media Uploads
 * 		6.3.19 Updated table view and entity modal views
 * 		6.2.19 Fixed: Update not working in entity view->links->node link
 * 		6.1.19 Modified Template object to use default view for entities view when file doesn't exist.
 * 		6.1.19 Started restructure of association arrays for entity objects 
 * 		6.1.19 Entity Objects need to have the assocations arrays restructured to allow separate array for belongsTo and Has to allow recursive relationships
 * 		5.22.19 Fixed main and in-modal searches
 * 		5.22.19 Controller object now dynamically executes own functions for CRUD operations, api and controller files for them
 * 			deleted in core/controllers and core/controllers/api
 * 		5.16.19 Moved controller into object, extensive reworks to most controllers
 * 		5.17.19 Modified controllers to not echo returned code from html_helper, instead they use templates. See line below.
 * 		5.17.19 Moved html_helper funcions that would render views into seperate files in dir core/view/default/
 * 		5.17.19 Fixed entity_search_api/controllers: Complete entity_search_api/controllers, currently returns a empty table in the payload
 * 		3.8.19 Main view searches now return results via ajax into main view container using toggled selection
 * 		3.5.19 Added toggle views in entity table view.
 * 		3.5.19 Media is unable to hook 'media_create_mid' because the instance of the media object is passed during init and it is another object at time of upload;
 * 			Solution: Keep modification code in api_helper, adding $media->upload() when creating this entity api...
 * 		2.6.19 Fixed: Look up if there is a way to discover which PDO statements have already been prepared.
 * 			Made all data base connection persistent, reducing wait times and overhead
 * 			https://phpdelusions.net/pdo#query
 * 		2.5.19 Fixed: logged out user can see all medias
 * 		2.5.19 Fixed: counting pagination will have a bug caused by improper sql being sent during baseTable->CountPages()
 * 		2.5.19 Fixed: baseTable->SetSTMTSqlOnlySeeTheirs appends modifier to statemnts mulitple times
 * 		2.4.19 BaseEntity object now has user_id property that records new entities with current user_id so we can track ownership
 * 		2.4.19 Cleaned up the write executor....
 * 		2.3.19 Logging out of a company shows that we have logged the user out in the menu
 * 			Api requests GetHTML, GetEntity and GetForm maybe creating new User Objects killing the permissions we have
 * 			Issue was caused in getEntity api, we were creating the entity to return as a global (no underscore prefix)
 * 		2.2.19 removed  $this->loadPermissions from user->__contruct(); reduces significant overhead
 * 			since permissions can be loaded from init (only run from session restore) and not needed if Has array stored in session
 * 		2.1.19 Create filters in baseController to not allow requests for company entities unless logged into a company
 * 		2.1.19 Create filters for any links going to company entities unless logged into a company 
 * 		2.1.19 Create dynamic menu builder
 * 		2.1.19 Session randomly losing is user auth... added a fix in session restore, but feel like it's a work around.
 * 
 * 
 * 
 * 
 * Naming Convention Notes: 
 * 
 * 		Views/Forms/Controllers
 * 
 * 		[entity_name]_[entity_name]_add - used to describe a form/controller that creates an entity AND connects it to another entity
 * 			Note: Entity Names should be arranged alphabetically.
 * 
 * 		[entity_name]_create - used to create a new entity with no assocation to another object
 * 
 * 		[entity_name]_[entity_name]_link - used to associate two entities that already exist through a create method,
 * 			Note: Entity Names should be arranged alphabetically.
 *
 * 		[entity_name]_[entity_name]_unlink - used to disassociate two entities that alread exist through a create method,
 * 			Note: Entity Names should be arranged alphabetically.
 * 
 * 		[entity_name]_link - used to associate two entities of THE SAME TYPE that already exist through a create method,
 * 			Note: Entity Names should be arranged alphabetically.
 * 
 * 		[entity_name]_remove - used to mark an entity as deleted, which will automatically unlink it from all other entities.
 * 
 * 		[entity_name]_delete - used to delete an entity, which will automatically unlink it from all others
 * 
 * 		[entity_name]_search - used to search a entity and return it's collection to the Table object of the entity, the plural version
 * 
 * 
 * Entity Methods Used for Views
 * 
 * 		$entity_name->getHasByEntity('entity_type')
 * 		
 * 			Returns an array of child objects linked to this of the entity_type. Ex:
 * 
 * 			//Asks the company for each card the company has as $_card
 * 			//The underscore is very important! using $card will overwrite the variable used in the global scope
 * 			foreach($company->getHasbyEntity('card') as $_card){
							echo '<li>'.$_card->id.' - '.$_card->name.'</li>'; 
 * 			}
 * 			// $_card can now be used to print any property the child has
 * 
 * 		$entity_name->getBelongsToByEntity('entity_type')
 * 
 * 			Returns an arrray of parent objects linked to this of the entity_type. 
 * 
 * 			//Asks the user for each company that the user belongsTo as $_company
 * 			//again, the underscore is important - see above
 * 			foreach($user->getBelongsToByEntity('company') as $_company){
 *						echo '<li>'.$_company->name.'</li>';
 * 			}
 * 			// $_company can now be used to print any property the parent has
 * 
 * 	Entity Structure Outline:
 * 
 * 		Entity(Parent)-----Entity(Child)
 *			\ 
 * 			Entity(Child)
 * 
 * 		User------------------------------------------------------------
 * 		 |	\				  \		\				\ 					\
 * 		 |	Company_User	   \	Message			Account(Bank)		Role
 * 		 |		\			    \                    \						\
 * 		 |	Company--MechantAcct \				  	  |						Permission
 * 		 \		   \			\ \	  				  |
 * 		  \		 ---Store		Card--------------    |    
 * 		   \	/		\                         \   |
 * 		   Purchase    	Product_Store              Transaction
 *		   /|\ \	\  				  \
 * 		  /	| \ \ ---------------Product-----Category(recursive) 							
 * 		 /	|  \ \				/  \  \
 * Shipment |	\ ------MediaFile	\  -------Vendor(could be internal company)
 * 	\		|	 \......		\	 \
 * 	 \	  Transaction-----------Comment
 *    \
 *   Shipper
 *  
 * 
 * 
 * 
 * NOTES FOR VARIABLES
 * 
 * 		The session will automatically create an Entity object when defined in:
 * 			core/core/model/entity/
 * 			core/model/entity/
 * 
 * 		The session will also create two baseTable object for each entity as defined in:
 * 			core/core/model/table/
 * 			core/model/table/
 * 			
 * 			$_baseTableEntityName (PREFixed with underscore)
 * 				
 * 				This object is used in the background to display information into views, including forms.
 * 				Controllers will not modify these objects, but forms will. You may use baseTable->SetSTMTSql()
 * 				or baseTable->SetSTMTSqlNoLimit() to gather a collection of entities and display them to a
 * 				view. Because other views may modify this collection, be sure that you use the collection
 * 				immediately gathering it via:
 * 
 * 				
 * 
 * 			AND
 * 
 * 			$baseTableEntityName (NOT PREFixed with underscore)
 * 
 * 				This object is used in the forground as a static object that represents the current search
 * 				collection. This object is used to display the collection in primary views. The only 
 * 				controller that should modify this collection is the entity's search controller.
 * 
 *	CONNECTING TO Databases:
 * 	
 * 		Database settings are in core/setup/config
 * 		The user account of the database connection will need permissions to create table, create databases,
 * 		and alter tables in addition to the typical needs of selecting, updating and write permission.
 * 
 * 	FIRST EXECUTION and CONFIG FILE CONSTANTS:
 * 
 * 		During the first execution and when updating the framework with new entities, some constants will need to 
 * 		be altered later to properly propagate changes needed. During the first execution, response time may appear
 * 		very slow as the framework creats all the files needed to display it's first view. While DEVELOPMENT is TRUE
 * 		controllers, forms, views, modals, js, api that do not already exist we be created.
 * 
 * 		The default settings should be as follows:
 * 		define("DEVELOPMENT",TRUE);
 * 		define("REWRITE_CONTROLLERS",FALSE);
 *		define("REWRITE_FORMS",FALSE);
 *		define("REWRITE_VIEWS",	FALSE);
 *		define("REWRITE_MODALS", FALSE);
 *		define("REWRITE_JS", FALSE);
 *		define("REWRITE_APIS", FALSE);
 *		define("REWRITE_INCLUDES", FALSE);
 *		define("REWRITE_PERMISSIONS", TRUE);	
 * 
 * 		During development to involk the changes that each contant effects, change the value of the constant you 
 * 		need to TRUE, execute a request to the server once and return the value back to FALSE.
 * 
 * 		DEVELOPMENT  - what does this affect?
 * 		REWRITE_CONTROLLERS - overwrites all existing controllers in /core/controller
 * 		REWRITE_FORMS - overwrites all existing forms in /core/view/forms
 * 		REWRITE_VIEWS - overwrites all existing views in /core/view
 * 		REWRITE_MODALS - overwrites all existing modals views in /core/view 
 * 		REWRITE_JS - overwrites all existing js files in /core/js
 * 		REWRITE_APIS - overwrites all existing api files in /core/controller/api
 * 		REWRITE_INCLUDES - anylizes all entities and tables for auto inclusion into the project
 * 		REWRITE_PERMISSIONS- anylizes all permissions needed for the project and adds them to the ADMIN role.
 * 			Creates the root Admin User if it doesn't exist
 * 			Adds Admin Role to admin user pre-existing or not.
 * 
 * 		ADMIN_PASSWORD - the password to assign to the auto generated Admin user account
 * 		SALT & PEPPER - the salt and pepper values used in secure hash. While these are set with a value by default, 
 * 			you should change these values so that they are unique to your project
 * 
 * 		SITE_URL - the www address of the server
 * 		MEDIA_DIRECTORY - the path directory to place user uploaded media.
 * 
 * 		DBHOST - the host name of the location of the database
 * 		DBUSER - the username of the account to login to
 * 		DBPASSWORD - the password for the username for the database
 * 		COREDBNAME - the name of the database for the core framework to use
 * 		COMPANYDBPREFIX - the prefix to use infront of core-created sharded databases
 * 
 * 
 * 
 * 
 * 	Helper Classes and the Writer Class:
 * 	
 * 		At Run-time in developement mode, the write_executer.php file(/core/utilities) is responsible for writing non-existing Forms,
 * 		Controllers, Views, Modals, JS, and Auto-includes. The writer contains the logic and order
 * 		to build these using the helper classes via their modular functions. The writer does not 
 * 		contain any HTML or PHP that would echo to the page, but rather returns code and html to be
 * 		executed in real-time or optionally write the code to disk to later be executed via a file-
 * 		include.
 * 
 * 		The Write Class makes calls to the following helping objects:
 * 
 * 			form_helper, html_helper, api_helper and php_helper
 * 
 * 		Form Helper - Writes HTML snippets for each field.
 * 			param entity_name
 * 			param property_name
 * 			param id_prefix
 * 			param hidden
 * 
 * 		PHP Helper - Writes PHP snippets, processors and api files
 * 		
 * 		HTML Helper - Writes HTML snippets that make up sections of views and other things not Forms
 * 
 * 	Hooks
 * 		
 * 		The hook objects exists as a global unserializable object, its methods and documentation can be found in:
 * 			/core/untility/php-hooks-master/src/voku/helper/Hooks.php
 * 
 * 		do_action($hook_name str,$args mixed)
 * 			$hook_name string, the name of the hook being called
 * 			$args mixed, the aguments passed to the function being called at the hook
 * 
 * 		Hooks names and a brief description of where they are implemented follow:
 * 
 * 
 * 		HTML AND VIEWS
 * 
 * 		MAIN_TOOLBAR
 * 
 * 			do_action('main_toolbar', entites obj)
 * 				When: Called when the main tool bar is shown on each tables view
 * 		
 * 		ENTITY_MAIN_TOOLBAR
 * 
 * 			do_action([$entity_name]_main_toolbar str, $entities obj)
 * 				When: Called when the main tool bar is show for $entity_name, ex: do_action('user_main_toolbar',$users) is called when viewing the toolbar on "users" page 
 * 
 * 		
 * 		Process and API 
 * 	
 * 		ADD_PRE		
 * 	
 * 			do_action([$entity_name]_[$entity_name]_add_pre str, $entity_obj obj)
 * 				[$entity_name]_[$entity_name]_add str - The two entities being linked, placed in order by naming convention followed by '_add'
 * 				$entity_obj obj - The entity that was created, it will be the child object to the parent
 * 				When: Fired after the new child is created, before it is linked to the existing parent
 * 		
 * 		ADD_POST
 * 		
 * 			do_action([$entity_name]_[$entity_name]_add_post str, $entity_obj obj)
 * 				[$entity_name]_[$entity_name]_add str - The two entities being linked, placed in order by naming convention followed by '_add'
 * 				$entity_obj obj - The entity that was created, it will be the child object to the parent
 * 				When: Fired after the new child is created and linked to the existing parent
 * 		
 * 		CREATE_PRE
 * 
 * 			do_action([$entity_name]_create_pre str)
 * 				[$entity_name]_create_pre string - The entity name being created followed by '_create_pre'
 * 				When: Fires after validation and before a new entity is created				
 * 
 *		CREATE_MID
 * 
 * 			do_action([$entity_name]_create_mid str)
 * 				[$entity_name]_create_pre string - The entity name being created followed by '_create_pre'
 * 				When: Fires after validation, the new entity is created, but before any saves	
 * 
 * 		CREATE_POST
 * 
 * 			do_action([$entity_name]_create_post str,$entity_id str)
 * 				[$entity_name]_create_post string - The entity name being created followed by '_create_post'
 * 				$entity_id str - The entity id of the object that was created after being saved
 * 				When: Fires after an entity is validated, created and saved;
 * 
 * 		LINK_PRE
 * 
 * 			do_action([$entity_name]_[$entity_name]_link_pre str)
 * 				[$entity_name]_[$entity_name]_link_pre string - The two entities being linked, placed in order by naming convention followed by 'link_pre'
 * 				When: Fires before link data is created
 * 
 * 		LINK_POST currenly passes no args
 * 
 * 			do_action([$entity_name]_[$entity_name]_link_post str, $args array)
 * 				[$entity_name]_[$entity_name]_link_pre string - The two entities being linked, placed in order by naming convention followed by '_link_post'
 * 				$args array - an indexed array of the entity objects after links have been made
 * 				When: Fires after link data is created before the entities are saved
 *
 * 		UNLINK_PRE 
 * 
 * 			do_action([$entity_name]_[$entity_name]_unlink_pre str)
 * 				[$entity_name]_[$entity_name]_unlink_pre string - The two entities being unlinked, placed in order by naming convention followed by 'link_pre'
 * 				When: Fires before link data is removed
 * 
 * 		UNLINK_POST currently passes no args
 * 
 * 			do_action([$entity_name]_[$entity_name]_unlink_post str, $args array)
 * 				[$entity_name]_[$entity_name]_unlink_pre string - The two entities being unlinked, placed in order by naming convention followed by '_link_post'
 * 				$args array - an indexed array of the entity objects after unlinks have been made
 * 				When: Fires after link data is removed before the entities are saved
 *  
 * 		DELETE_PRE
 * 
 * 			do_action([$entity_name]_delete_pre str, $entity_obj obj)
 * 				[$entity_name]_delete_pre string - The entity name being deleted followed by '_delete_pre'
 * 				$entity_object object - The entity object before it is deleted
 * 				When: Fires before a entity is unlinked from all relationships and before the entity is deleted
 * 
 * 		DELETE_POST
 * 
 * 			do_action([$entity_name]_delete_post str, $entity_obj obj)
 * 				[$entity_name]_delete_post string - The entity name being delted followed by '_delete_post'
 * 				$entity_object object - The entity obejct after is is deleted
 * 				When: Fires after the object has been unlinked from any relationship and before it is unset and lost from future session and the database
 * 		
 * 		EDIT (NODE)
 * 		
 * 			do_action([$entity_name]_[$entity_name]_edit str, entity_obj obj)
 * 				[$entity_name]_[$entity_name]_edit string - The node being edited, placed in order by naming convention followed by '_edit'
 * 				$entity_object object - The entity object after it is edited
 * 				When: Fires after the node entity has been edited before is saved
 * 		
 * 		EDIT
 * 
 * 			do_action([$entity_name]_edit str, entity_obj obj)
 * 				[$entity_name]_edit string - The name of the entity being edited followed by '_edit'
 * 				$entity_object object - The entity object after it is edited
 * 				When: Fires after the entity has been edited before is saved
 * 
 * 		SEARCH
 * 
 * 			do_action([$entity_name]_search str, table_obj obj)
 * 				[$entity_name] string - The plural convention of the entity table being searched ex:users, not user 
 * 				$table_object object - The table object being searched
 * 				When: Fires after a search is completed, the table object is set to Page 1 of the result set				
 * 
 * 		REMOVE
 * 	
 * 			do_action([$entity_name]_remove st,)
 * 				[$entity_name] string - The name of the entity being removed followed by '_remove'
 * 				When: Fired after the entity has been marked for removal 		
 * 
 * 
 * 	
 * 		
 * 
 * 		
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *   View Outline:
 * 
 * 		User Registration
 * 			Create
 * 			Suspend/Recover Account
 * 		
 * 		User Profile
 * 			Edit
 * 			Delete
 * 			Add a card (Links to user)
 * 		
 * 		User Roles
 * 			Create Roles
 * 			Create Permissions
 * 			Link Roles and Permissions
 * 			Remove Roles and Permissions
 * 
 * 		Company Profile
 * 			Add a company(Links creating user)
 * 			Link a user to this company
 * 			Add a store (links to company)
 * 			Add a card (links to company)
 * 			Remove a user (unlink from company)
 * 			Remove a card (unlink from company)
 * 			Remove a store (unlink from company)
 * 			Manage order process methods for purchases, rentals etc.
 * 			Manage merchant accounts for this business
 * 
 * 		Store Manager
 * 			Log into a store
 * 			Manage inventory at this store (Product_Store entity)
 * 			Manage users (employee and customers) at this store
 * 			Manage orders at this store
 * 			Accept inventory and shipments
 * 			Manage outgoing shipments from this store 
 * 
 * 		Product Manager
 * 			Create a product
 * 			Manage Public views of this product 
 * 			Edit products
 * 			Set defaults for Product_Store values
 * 			Add MediaFiles to a product
 * 			Remove MediaFiles from an product
 * 			Add Comments to a Product (reviews)
 * 			Remove/Edit Comment on a product
 * 
 * 		Order Manager
 * 			Views an Order
 * 			Modify/Edit Orders
 * 			Pushes an order through	statuses
 * 			Perpare/Pullsheet
 * 			Add MediaFiles to an order
 * 			Remove MediaFiles from an order
 * 			Add Comments to a MediaFile
 * 			Remove/Edit Comments on a MediaFile	
 * 		
 * 		Message Center
 * 			Create and Send Messages
 * 			Seperate personal from work related
 * 			Connects a customer to a service rep in real time
 * 			Can be a push-style dialog available on every page.
 * 			Push style should not create new windows
 * 			Create/Send a MediaFile with-in a Message
 * 	
 * 		POS View
 * 			Simplified view for scanning products to an order
 * 			Should act as a cash register.
 * 
 * 		Discounts Manager
 * 			Create a discount
 * 			Edit a discount
 * 			Delete a discount
 * 
 * 		Accounts Manager
 * 			Can see all transaction for orders, users, vendors, stores, all sortable.
 * 			Add/Remove/Edit Comments on a transaction
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */





//       Find a way to add this resource back on Wakeup()
// TODO: Core update process? How do we update all company databases with new properties being used?


// TODO: Store Close proceedure. What happens to old inventory? 
// TODO: Create billing page for stores used and employees.
// TODO: Create outline of features using the site, with billing expectations
// Model 1:
//		Flat Rate per X employees
// 		Flat Rate per X stores
// Model 2:
//		Flat Percentage of each sale

// TODO: Interface merchant account sandbox into billing processing
// TODO: Create Product Management views, outline product/item/version product models
// TODO: Create Market place views
?>

