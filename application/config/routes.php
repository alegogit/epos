<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "Login_controller"; 
 
$route['forgot'] = "Forgot_controller";

$route['reset/(:any)'] = "Reset_controller";
//$route['book/(:any)'] = "book/slugify/$1";

$route['login'] = "Login_controller";
$route['loginauth'] = "Loginauth_controller";
$route['logout'] = "dashboard/sales_controller/logout";

$route['dashboard'] = "dashboard/sales_controller";
$route['dashboard/sales'] = "dashboard/sales_controller";  
$route['dashboard/salesview/(:any)'] = "dashboard/sales_controller/view";
$route['dashboard/salesprint/(:any)'] = "dashboard/sales_controller/printing";
$route['dashboard/trends'] = "dashboard/trends_controller";  
$route['dashboard/trendsview/(:any)'] = "dashboard/trends_controller/view";
$route['dashboard/trendsprint/(:any)'] = "dashboard/trends_controller/printing";
$route['dashboard/inventory'] = "dashboard/inventory_controller"; 
$route['dashboard/inventoryview/(:any)'] = "dashboard/inventory_controller/view";
$route['dashboard/inventoryprint/(:any)'] = "dashboard/inventory_controller/printing";
$route['dashboard/test'] = "dashboard/test_controller";

$route['profile'] = "profile_controller";
$route['profile/pic/(:any)'] = "profile_controller";

$route['inventory'] = "inventory_controller";
$route['customers'] = "customers_controller";

$route['setting'] = "setting/restaurant_controller";
$route['setting/restaurant'] = "setting/restaurant_controller";
$route['setting/category'] = "setting/category_controller";   
$route['setting/menu'] = "setting/menu_controller";            
$route['setting/menuinventory'] = "setting/menuinventory_controller";            
$route['setting/tableorder'] = "setting/tableorder_controller";
$route['setting/users'] = "setting/users_controller";
$route['setting/printer'] = "setting/printer_controller";
//$route['setting/devices'] = "setting/devices_controller"; 
$route['setting/terminal'] = "setting/terminal_controller"; 
$route['setting/currency'] = "setting/currency_controller";    

$route['reports'] = "reports/sales_controller";
$route['reports/sales'] = "reports/sales_controller";
$route['reports/salesview/(:any)'] = "reports/sales_controller/view";
$route['reports/salesprint/(:any)'] = "reports/sales_controller/printing";
$route['reports/inventory'] = "reports/inventory_controller";
$route['reports/inventoryview/(:any)'] = "reports/inventory_controller/view";
$route['reports/inventoryprint/(:any)'] = "reports/inventory_controller/printing";
$route['reports/cashflow'] = "reports/cashflow_controller";   
$route['reports/cashflowview/(:any)'] = "reports/cashflow_controller/view";
$route['reports/cashflowprint/(:any)'] = "reports/cashflow_controller/printing";
$route['reports/attendance'] = "reports/attendance_controller";  
$route['reports/attendance/exec'] = "reports/attendance_controller/exec";  
$route['reports/daily'] = "reports/daily_controller"; 
$route['reports/salesdaily/(:any)'] = "reports/daily_controller/salesview";
$route['reports/recondaily/(:any)'] = "reports/daily_controller/reconview";
$route['reports/dailysalesprint/(:any)'] = "reports/daily_controller/salesprint";
$route['reports/dailyreconprint/(:any)'] = "reports/daily_controller/reconprint"; 

$route['extracts'] = "extracts/ordersdata_controller";
$route['printpdf'] = "printpdf_controller";
$route['printpdf/tojpg'] = "printpdf_controller/tojpg";
$route['printpdf/view'] = "printpdf_controller/view";
$route['printpdf/topdf'] = "printpdf_controller/topdf";

$route['sync'] = "sync_controller";
$route['sync/exec'] = "sync_controller/exec";
                                                          
$route['process/restaurant'] = "process/restaurantsetting_controller";   
$route['process/category'] = "process/categorysetting_controller";
$route['process/menu'] = "process/menusetting_controller";   
$route['process/menuinventory'] = "process/menuinventorysetting_controller"; 
$route['process/tableorder'] = "process/tableordersetting_controller";   
$route['process/users'] = "process/userssetting_controller";        
$route['process/printer'] = "process/printersetting_controller";
//$route['process/devices'] = "process/devicessetting_controller";
$route['process/terminal'] = "process/terminalsetting_controller";
$route['process/orders'] = "process/orderdetails_controller";
$route['process/inventory'] = "process/inventoryprocess_controller";
$route['process/customers'] = "process/customersprocess_controller";    

$route['cron/inventorywastage'] = "cron/inventorywastage_controller";

$route['404_override'] = 'P404';   


/* End of file routes.php */
/* Location: ./application/config/routes.php */