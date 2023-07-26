<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Role management
         $moduleAppRole = Module::updateOrCreate(['title' => 'Role Management', 'slug'=>Str::slug('Role Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Access Roles',
             'slug' => 'app.roles.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Create Role',
             'slug' => 'app.roles.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Edit Role',
             'slug' => 'app.roles.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Delete Role',
             'slug' => 'app.roles.destroy',
         ]);


         // User management
         $moduleAppUser = Module::updateOrCreate(['title' => 'User Management', 'slug'=>Str::slug('User Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Access User',
             'slug' => 'app.users.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Create User',
             'slug' => 'app.users.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Edit User',
             'slug' => 'app.users.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Delete User',
             'slug' => 'app.users.destroy',
         ]);
         // department management
         $moduleAppDepartment = Module::updateOrCreate(['title' => 'Department Management', 'slug'=>Str::slug('Department Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDepartment->id,
             'title' => 'Access Department',
             'slug' => 'app.departments.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDepartment->id,
             'title' => 'Create Department',
             'slug' => 'app.departments.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDepartment->id,
             'title' => 'Edit Department',
             'slug' => 'app.departments.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDepartment->id,
             'title' => 'Delete Department',
             'slug' => 'app.departments.destroy',
         ]);
         // designation management
         $moduleAppDesignation = Module::updateOrCreate(['title' => 'Designation Management', 'slug'=>Str::slug('Designation Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Access Designation',
             'slug' => 'app.designations.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Create Designation',
             'slug' => 'app.designations.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Edit Designation',
             'slug' => 'app.designations.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Delete Designation',
             'slug' => 'app.designations.destroy',
         ]);
         // account type management
         $moduleAppAccountType = Module::updateOrCreate(['title' => 'Account Type Management', 'slug'=>Str::slug('Account Type Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppAccountType->id,
             'title' => 'Access Account Type',
             'slug' => 'app.accounttype.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppAccountType->id,
             'title' => 'Create Account Type',
             'slug' => 'app.accounttype.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppAccountType->id,
             'title' => 'Edit Account Type',
             'slug' => 'app.accounttype.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppAccountType->id,
             'title' => 'Delete Account Type',
             'slug' => 'app.accounttype.destroy',
         ]);
         // bank account management
         $moduleAppBankAccount = Module::updateOrCreate(['title' => 'Bank Account Management', 'slug'=>Str::slug('Bank Account Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppBankAccount->id,
             'title' => 'Access Bank Account',
             'slug' => 'app.bankaccount.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppBankAccount->id,
             'title' => 'Create Bank Account',
             'slug' => 'app.bankaccount.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppBankAccount->id,
             'title' => 'Edit Bank Account',
             'slug' => 'app.bankaccount.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppBankAccount->id,
             'title' => 'Delete Bank Account',
             'slug' => 'app.bankaccount.destroy',
         ]);
         // cheque book management
         $moduleAppChequeBook = Module::updateOrCreate(['title' => 'Cheque Book Management', 'slug'=>Str::slug('Cheque Book Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeBook->id,
             'title' => 'Access Cheque Book',
             'slug' => 'app.chequebook.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeBook->id,
             'title' => 'Create Cheque Book',
             'slug' => 'app.chequebook.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeBook->id,
             'title' => 'Edit Cheque Book',
             'slug' => 'app.chequebook.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeBook->id,
             'title' => 'Delete Cheque Book',
             'slug' => 'app.chequebook.destroy',
         ]);
         // ---------------- cheque number management -------------------------//
         $moduleAppChequeNumber = Module::updateOrCreate(['title' => 'Cheque Number Management', 'slug'=>Str::slug('Cheque Number Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeNumber->id,
             'title' => 'Access Cheque Number',
             'slug' => 'app.chequenumber.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeNumber->id,
             'title' => 'Create Cheque Number',
             'slug' => 'app.chequenumber.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeNumber->id,
             'title' => 'Edit Cheque Number',
             'slug' => 'app.chequenumber.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppChequeNumber->id,
             'title' => 'Delete Cheque Number',
             'slug' => 'app.chequenumber.destroy',
         ]);
         // ---------------- product type management -------------------------//
         $moduleProductType = Module::updateOrCreate(['title' => 'Product Type Management', 'slug'=>Str::slug('Product Type Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductType->id,
             'title' => 'Access Product Type',
             'slug' => 'app.producttype.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductType->id,
             'title' => 'Create Product Type',
             'slug' => 'app.producttype.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductType->id,
             'title' => 'Edit Product Type',
             'slug' => 'app.producttype.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductType->id,
             'title' => 'Delete Product Type',
             'slug' => 'app.producttype.destroy',
         ]);
         // ---------------- product category management -------------------------//
         $moduleProductCategory = Module::updateOrCreate(['title' => 'Product Category Management', 'slug'=>Str::slug('Product Category Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductCategory->id,
             'title' => 'Access Product Category',
             'slug' => 'app.productcategory.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductCategory->id,
             'title' => 'Create Product Category',
             'slug' => 'app.productcategory.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductCategory->id,
             'title' => 'Edit Product Category',
             'slug' => 'app.productcategory.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductCategory->id,
             'title' => 'Delete Product Category',
             'slug' => 'app.productcategory.destroy',
         ]);
         // ---------------- product sub category management -------------------------//
         $moduleProductSubCategory = Module::updateOrCreate(['title' => 'Product Sub Category Management', 'slug'=>Str::slug('Product Sub Category Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductSubCategory->id,
             'title' => 'Access Product Sub Category',
             'slug' => 'app.productsubcategory.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductSubCategory->id,
             'title' => 'Create Product Sub Category',
             'slug' => 'app.productsubcategory.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductSubCategory->id,
             'title' => 'Edit Product Sub Category',
             'slug' => 'app.productsubcategory.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductSubCategory->id,
             'title' => 'Delete Product Sub Category',
             'slug' => 'app.productsubcategory.destroy',
         ]);
         // ---------------- product unit management -------------------------//
         $moduleProductUnit = Module::updateOrCreate(['title' => 'Product Unit Management', 'slug'=>Str::slug('Product Unit Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductUnit->id,
             'title' => 'Access Product Unit',
             'slug' => 'app.productunit.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductUnit->id,
             'title' => 'Create Product Unit',
             'slug' => 'app.productunit.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductUnit->id,
             'title' => 'Edit Product Unit',
             'slug' => 'app.productunit.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductUnit->id,
             'title' => 'Delete Product Unit',
             'slug' => 'app.productunit.destroy',
         ]);
         // ---------------- product brand management -------------------------//
         $moduleProductBrand = Module::updateOrCreate(['title' => 'Product Brand Management', 'slug'=>Str::slug('Product Brand Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductBrand->id,
             'title' => 'Access Product Brand',
             'slug' => 'app.productbrand.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductBrand->id,
             'title' => 'Create Product Brand',
             'slug' => 'app.productbrand.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductBrand->id,
             'title' => 'Edit Product Brand',
             'slug' => 'app.productbrand.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProductBrand->id,
             'title' => 'Delete Product Brand',
             'slug' => 'app.productbrand.destroy',
         ]);
         // ---------------- product management -------------------------//
         $moduleProduct = Module::updateOrCreate(['title' => 'Product Management', 'slug'=>Str::slug('Product Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleProduct->id,
             'title' => 'Access Product',
             'slug' => 'app.product.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProduct->id,
             'title' => 'Create Product',
             'slug' => 'app.product.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProduct->id,
             'title' => 'Edit Product',
             'slug' => 'app.product.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleProduct->id,
             'title' => 'Delete Product',
             'slug' => 'app.product.destroy',
         ]);
         // ---------------- stock management -------------------------//
         $modulePreviousStock = Module::updateOrCreate(['title' => 'Stock Management', 'slug'=>Str::slug('Stock Management')]);
         Permission::updateOrCreate([
             'module_id' => $modulePreviousStock->id,
             'title' => 'Access Previous Stock',
             'slug' => 'app.previousstock.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $modulePreviousStock->id,
             'title' => 'Create Previous Stock',
             'slug' => 'app.previousstock.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $modulePreviousStock->id,
             'title' => 'Previous Stock Report',
             'slug' => 'app.previousstock.report',
         ]);
         Permission::updateOrCreate([
             'module_id' => $modulePreviousStock->id,
             'title' => 'Stock Report',
             'slug' => 'app.stock.report',
         ]);
         Permission::updateOrCreate([
             'module_id' => $modulePreviousStock->id,
             'title' => 'Date Wise Stock Report',
             'slug' => 'app.datewisestock.report',
         ]);
         
         // ---------------- requisition management -------------------------//
         $moduleAppRequisition = Module::updateOrCreate(['title' => 'Requisition Management', 'slug'=>Str::slug('Requisition Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRequisition->id,
             'title' => 'Requisitions',
             'slug' => 'app.requisition.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRequisition->id,
             'title' => 'Create Requisition',
             'slug' => 'app.requisition.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRequisition->id,
             'title' => 'Edit Requisition',
             'slug' => 'app.requisition.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRequisition->id,
             'title' => 'Delete Requisition',
             'slug' => 'app.requisition.destroy',
         ]);

         Permission::updateOrCreate([
            'module_id' => $moduleAppRequisition->id,
            'title' => 'Approve Requisition',
            'slug' => 'app.requisition.approve',
        ]);
         
         Permission::updateOrCreate([
            'module_id' => $moduleAppRequisition->id,
            'title' => 'Report',
            'slug' => 'app.requisition.report',
        ]);
         // ---------------- supplier management -------------------------//
         $moduleAppSupplier = Module::updateOrCreate(['title' => 'Supplier Management', 'slug'=>Str::slug('Supplier Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'title' => 'Access Supplier',
            'slug' => 'app.supplier.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'title' => 'Create Supplier',
            'slug' => 'app.supplier.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'title' => 'Edit Supplier',
            'slug' => 'app.supplier.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'title' => 'Delete Supplier',
            'slug' => 'app.supplier.destroy',
        ]);

         // ---------------- supplier report management -------------------------//
         $moduleAppSupplierReport = Module::updateOrCreate(['title' => 'Supplier Report Management', 'slug'=>Str::slug('Supplier Report Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleAppSupplierReport->id,
            'title' => 'Supplier Payment List',
            'slug' => 'app.supplierreport.paymentlist',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplierReport->id,
            'title' => 'Supplier Due Report',
            'slug' => 'app.supplierreport.duereport',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplierReport->id,
            'title' => 'Supplier Payment Report',
            'slug' => 'app.supplierreport.paymentreport',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplierReport->id,
            'title' => 'Supplier Payment Amendment',
            'slug' => 'app.supplierreport.paymentamendment',
        ]);

         // ---------------- Product Purchase management -------------------------//
         $moduleApppProductPurchase = Module::updateOrCreate(['title' => 'Product Purchase Management', 'slug'=>Str::slug('Product Purchase Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleApppProductPurchase->id,
            'title' => 'Product Purchase',
            'slug' => 'app.productpurchase.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppProductPurchase->id,
            'title' => 'Product Purchase Report',
            'slug' => 'app.productpurchase.report',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppProductPurchase->id,
            'title' => 'Product Purchase Amendment',
            'slug' => 'app.productpurchase.amendment',
        ]);

         // ---------------- Asset management -------------------------//
         $moduleApppAssetType = Module::updateOrCreate(['title' => 'Asset Type Management', 'slug'=>Str::slug('Asset Type Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleApppAssetType->id,
            'title' => 'Access Asset Type',
            'slug' => 'app.assettype.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetType->id,
            'title' => 'Create Asset Type',
            'slug' => 'app.assettype.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetType->id,
            'title' => 'Edit Asset Type',
            'slug' => 'app.assettype.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetType->id,
            'title' => 'Delete Asset Type',
            'slug' => 'app.assettype.destroy',
        ]);

         // ---------------- Asset Sub management -------------------------//
         $moduleApppAssetSubType = Module::updateOrCreate(['title' => 'Asset Sub Type Management', 'slug'=>Str::slug('Asset Sub Type Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleApppAssetSubType->id,
            'title' => 'Access Asset Sub Type',
            'slug' => 'app.assetsubtype.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetSubType->id,
            'title' => 'Create Asset Sub Type',
            'slug' => 'app.assetsubtype.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetSubType->id,
            'title' => 'Edit Asset Sub Type',
            'slug' => 'app.assetsubtype.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetSubType->id,
            'title' => 'Delete Asset Sub Type',
            'slug' => 'app.assetsubtype.destroy',
        ]);

         // ---------------- Asset management -------------------------//
         $moduleApppAsset = Module::updateOrCreate(['title' => 'Asset Management', 'slug'=>Str::slug('Asset Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleApppAsset->id,
            'title' => 'Access Asset',
            'slug' => 'app.asset.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAsset->id,
            'title' => 'Create Asset',
            'slug' => 'app.asset.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAsset->id,
            'title' => 'Edit Asset',
            'slug' => 'app.asset.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAsset->id,
            'title' => 'Delete Asset',
            'slug' => 'app.asset.destroy',
        ]);

         // ---------------- Asset Assign management -------------------------//
         $moduleApppAssetAssign = Module::updateOrCreate(['title' => 'Asset Assign Management', 'slug'=>Str::slug('Asset Assign Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleApppAssetAssign->id,
            'title' => 'Assign Asset',
            'slug' => 'app.assignasset.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetAssign->id,
            'title' => 'Assign Asset Report',
            'slug' => 'app.assignasset.report',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetAssign->id,
            'title' => 'Assign Asset Amendment',
            'slug' => 'app.assignasset.amendment',
        ]);

        Permission::updateOrCreate([
            'module_id' => $moduleApppAssetAssign->id,
            'title' => 'Damage request Approve',
            'slug' => 'app.damage.request.approve',
        ]);

         // ---------------- Product Assign management -------------------------//
         $moduleApppProductAssign = Module::updateOrCreate(['title' => 'Product Assign Management', 'slug'=>Str::slug('Product Assign Management')]);
         Permission::updateOrCreate([
            'module_id' => $moduleApppProductAssign->id,
            'title' => 'User Wise Product',
            'slug' => 'app.productassign.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppProductAssign->id,
            'title' => 'User Wise Product Report',
            'slug' => 'app.productassign.report',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleApppProductAssign->id,
            'title' => 'User Wise Product Amendment',
            'slug' => 'app.productassign.amendment',
        ]);

    }
}
