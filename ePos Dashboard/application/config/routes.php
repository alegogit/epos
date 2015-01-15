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
$route['dashboard/inventory'] = "dashboard/inventory_controller";

$route['inventory'] = "inventory/inventory_controller";

$route['customers'] = "customers/customers_controller";

$route['setting'] = "setting/restaurant_controller";
$route['setting/restaurant'] = "setting/restaurant_controller";
$route['setting/category'] = "setting/category_controller";   
$route['setting/menu'] = "setting/menu_controller";            
$route['setting/tableorder'] = "setting/tableorder_controller";
$route['setting/users'] = "setting/users_controller";
$route['setting/printer'] = "setting/printer_controller";
$route['setting/devices'] = "setting/devices_controller"; 
$route['setting/discounts'] = "setting/discounts_controller";
$route['setting/currency'] = "setting/currency_controller";    

$route['reports'] = "reports/sales_controller";
$route['reports/sales'] = "reports/sales_controller";
$route['reports/inventory'] = "reports/inventory_controller";   

$route['extracts'] = "extracts/ordersdata_controller";
                                                             
$route['process/menu'] = "process/menu_controller";
$route['process/orders'] = "process/orderdetails_controller";
$route['process/printer'] = "process/printersetting_controller";
$route['process/devices'] = "process/devicessetting_controller";
$route['process/category'] = "process/categorysetting_controller";
$route['process/tableorder'] = "process/tableordersetting_controller";

$route['404_override'] = 'P404';


/* End of file routes.php */
/* Location: ./application/config/routes.php */