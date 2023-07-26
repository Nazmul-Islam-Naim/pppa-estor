<?php
namespace App\library{
	use App\Models\UserType;
	use Auth;
	class UserRoleWiseAccess
	{

	    public static function controllerMethods()
	    {
	        $controllerAccessArr = array( 
	        	'AnimalController' => array(
	        		'index' => 'View Cow List',
	        		'create' => 'Cow Entry Form',
	        		'store' => 'Cow Save Access',
	        		'edit' => 'Cow Edit From',
	        		'update' => 'Cow Update Access',
	        		'destroy' => 'Cow Delete Access',
	        	),
	        	'AnimalTypeController' => array(
	        		'index' => 'Animal Type List',
	        		'store' => 'Animal Type Save Access',
	        		'update' => 'Animal Type Update Access',
	        		'destroy' => 'Animal Type Delete Access',
	        	),
	        	'BranchController' => array(
	        		'index' => 'View Branch List',
	        		'store' => 'Branch Save Access',
	        		'update' => 'Branch Update Access',
	        		'destroy' => 'Branch Delete Access',
	        		'updateStatus' => 'Branch Update Status Access',
	        	),
	        	'CalfController' => array(
	        		'index' => 'View Calf List',
	        		'create' => 'Calf Entry Form',
	        		'store' => 'Calf Save Access',
	        		'edit' => 'Calf Edit From',
	        		'update' => 'Calf Update Access',
	        		'destroy' => 'Calf Delete Access',
	        	),
	        	'CollectMilkController' => array(
	        		'index' => 'View Collect Milk List',
	        		'store' => 'Collect Milk Save Access',
	        		'update' => 'Collect Milk Update Access',
	        		'destroy' => 'Collect Milk Delete Access',
	        	),
	        	'MilkCollectReportControlller' => array(
	        		'index' => 'View Animal Color List',
	        		'store' => 'Animal Color Save Access',
	        		'update' => 'Animal Color Update Access',
	        		'destroy' => 'Animal Color Delete Access',
	        	),
	        	'CowFeedController' => array(
	        		'index' => 'View Cow Feed List',
	        		'create' => 'Cow Feed Entry Form',
	        		'store' => 'Cow Feed Save Access',
	        		'edit' => 'Cow Feed Edit From',
	        		'update' => 'Cow Feed Update Access',
	        		'destroy' => 'Cow Feed Delete Access',
	        	),
	        	'CowMonitorController' => array(
	        		'index' => 'View Cow Monitor List',
	        		'create' => 'Cow Monitor Entry Form',
	        		'store' => 'Cow Monitor Save Access',
	        		'edit' => 'Cow Monitor Edit From',
	        		'update' => 'Cow Monitor Update Access',
	        		'destroy' => 'Cow Monitor Delete Access',
	        	),
	        	'CowVaccineMonitorController' => array(
	        		'index' => 'View Cow Vaccine Monitor List',
	        		'create' => 'Cow Vaccine Monitor Entry Form',
	        		'store' => 'Cow Vaccine Monitor Save Access',
	        		'edit' => 'Cow Vaccine Monitor Edit From',
	        		'update' => 'Cow Vaccine Monitor Update Access',
	        		'destroy' => 'Cow Vaccine Monitor Delete Access',
	        	),
	        	'SaleCowController' => array(
	        		'index' => 'View Cow Sale List',
	        		'create' => 'Cow Sale Entry Form',
	        		'store' => 'Cow Sale Save Access',
	        		'edit' => 'Cow Sale Edit From',
	        		'update' => 'Cow Sale Update Access',
	        		'destroy' => 'Cow Sale Delete Access',
	        	),
	        	'DesignationController' => array(
	        		'index' => 'View Designation List',
	        		'store' => 'Designation Save Access',
	        		'update' => 'Designation Update Access',
	        		'destroy' => 'Designation Delete Access',
	        	),
	        	'EmployeeSalaryController' => array(
	        		'index' => 'View Employee Salary List',
	        		'create' => 'Employee Salary Entry Form',
	        		'store' => 'Employee Salary Save Access',
	        		'edit' => 'Employee Salary Edit From',
	        		'update' => 'Employee Salary Update Access',
	        		'destroy' => 'Employee Salary Delete Access',
	        	),
	        	'ExpenseController' => array(
	        		'index' => 'View Expense List',
	        		'store' => 'Expense Save Access',
	        		'update' => 'Expense Update Access',
	        		'destroy' => 'Expense Delete Access',
	        	),
	        	'ExpensePurposeController' => array(
	        		'index' => 'View Expense Purpose List',
	        		'store' => 'Expense Purpose Save Access',
	        		'update' => 'Expense Purpose Update Access',
	        		'destroy' => 'Expense Purpose Delete Access',
	        	),
	        	'FoodItemController' => array(
	        		'index' => 'View Food Item List',
	        		'store' => 'Food Item Save Access',
	        		'update' => 'Food Item Update Access',
	        		'destroy' => 'Food Item Delete Access',
	        	),
	        	'FoodUnitController' => array(
	        		'index' => 'View Food Unit List',
	        		'store' => 'Food Unit Save Access',
	        		'update' => 'Food Unit Update Access',
	        		'destroy' => 'Food Unit Delete Access',
	        	),
	        	'HumanResourceController' => array(
	        		'index' => 'View Staff List',
	        		'userList' => 'View User List',
	        		'create' => 'Staff / User Entry Form',
	        		'store' => 'Staff / User Save Access',
	        		'edit' => 'Staff / User Edit From',
	        		'update' => 'Staff / User Update Access',
	        		'destroy' => 'Staff / User Delete Access',
	        	),
	        	'MonitoringServicesController' => array(
	        		'index' => 'View Monitoring Service List',
	        		'store' => 'Monitoring Service Save Access',
	        		'update' => 'Monitoring Service Update Access',
	        		'destroy' => 'Monitoring Service Delete Access',
	        	),
	        	'SaleMilkController' => array(
	        		'index' => 'View Sale Milk List',
	        		'store' => 'Sale Milk Save Access',
	        		'update' => 'Sale Milk Update Access',
	        		'destroy' => 'Sale Milk Delete Access',
	        	),
	        	'ShedController' => array(
	        		'index' => 'View Shed List',
	        		'store' => 'Shed Save Access',
	        		'update' => 'Shed Update Access',
	        		'destroy' => 'Shed Delete Access',
	        	),
	        	'SupplierContoller' => array(
	        		'index' => 'View Supplier List',
	        		'create' => 'Supplier Entry Form',
	        		'store' => 'Supplier Save Access',
	        		'edit' => 'Supplier Edit From',
	        		'update' => 'Supplier Update Access',
	        		'destroy' => 'Supplier Delete Access',
	        		'supplierFilter' => 'Supplier Filter Access',
	        	),
	        	'UserTypeController' => array(
	        		'index' => 'View User Type List',
	        		'store' => 'User Type Save Access',
	        		'update' => 'User Type Update Access',
	        	),
	        	'VaccinesController' => array(
	        		'index' => 'View Vaccines List',
	        		'store' => 'Vaccines Save Access',
	        		'update' => 'Vaccines Update Access',
	        		'destroy' => 'Vaccines Delete Access',
	        	),
	        	'EmployeeSalaryReportController' => array(
	        		'index' => 'Salary Report Page',
	        		'store' => 'Generate Salary Report',
	        	),
	        	'MilkCollectReportControlller' => array(
	        		'index' => 'Milk Collection Report Page',
	        		'store' => 'Generate Milk Collection Report',
	        	),
	        	'MilkSaleReportControlller' => array(
	        		'index' => 'Milk Sale Report Page',
	        		'store' => 'Generate Milk Sale Report',
	        	),
	        	'OfficeExpensReportController' => array(
	        		'index' => 'Office Expense Report Page',
	        		'store' => 'Generate Office Expense Report',
	        	),
	        	'SaleCowReportController' => array(
	        		'index' => 'Sale Cow Report Page',
	        		'cowSaleReportSearch' => 'Generate Sale Cow Report',
	        	),
	        	'CowVaccineMonitorReportController' => array(
	        		'index' => 'Cow Vaccine Monitoring Report Page',
	        		'store' => 'Generate Cow Vaccine Monitoring Report',
	        		'vaccineWiseMonitoringReport' => 'Vaccine Wise Monitoring Report',
	        		'getVaccineWiseMonitoringReport' => 'Generate Vaccine Wise Monitoring Report',
	        	),
	        	'SaleDueCollectionController' => array(
	        		'index' => 'Cow Due Collection Form',
	        		'store' => 'Collect Now Due Amount',
	        		'getSaleHistory' => 'Get Cow Due Collection Details',
	        	),
	      
	        );
	        return $controllerAccessArr;
	    }

	    public static function verifyAccess($controller = false, $method = false)
	    {
	    	if(Auth::user()->user_type==1){
	            return true;
	        }else{
	            $data=UserType::where('id', Auth::user()->user_type)->pluck('user_role')->first();
	            $userRoleAccess = json_decode($data, true);

	            if(isset($userRoleAccess[$controller][$method])){
	                return true;
	            }
	            else{
	                return false;
	            }
	        }
	    }
	}
}
