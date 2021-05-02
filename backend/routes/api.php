<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'api'], function ($router) {
    Route::get('menu', 'MenuController@index');

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register'); 

    Route::resource('notes', 'NotesController');
    Route::resource('resource/{table}/resource', 'ResourceController');

    // Get User Informations
    Route::group(['middleware' => 'auth:api'], function(){
    });
    Route::get('/user/{id}', 'UsersController@getAuthenticateUser')->name('authenticateUser');

    
    Route::group(['middleware' => 'admin'], function ($router) {

        Route::resource('mail',        'MailController');
        Route::get('prepareSend/{id}', 'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}',   'MailController@send')->name('mailSend');

        // Code Maintenance
        Route::post('/saveinfo','TestController@saveinfo')->name('saveinfo');
        // Get All Investigation Data
        Route::get('/investigation_code', 'TestController@getDept')->name('getDept');

        // Branch Route
        Route::post('/create_branch', 'BranchController@createBranch')->name('branch.create');
        Route::get('/branch_index/{id}', 'BranchController@branchIndex')->name('branch.index');
        Route::get('/branch_edit/{id}', 'BranchController@branchEdit')->name('branch.edit');
        Route::post('/branch_edit/{id}', 'BranchController@branchUpdate')->name('branch.update');
        Route::post('/branch_delete/{id}', 'BranchController@branchDelete')->name('branch.delete');
        Route::get('/branch_search/{search_string}', 'BranchController@branchSearch')->name('branch.search');
        Route::get('/get_branches/{id}', 'BranchController@getBranches')->name('branch.branches');


        // Designation Route
        Route::post('/create_designation', 'DesignationController@createDesignation')->name('designation.create');
        Route::get('/designation_index/{id}', 'DesignationController@designationIndex')->name('designation.index');


        Route::get('/company_info/{id}', 'CompanyController@companyInfo')->name('company.info');
        

        // Employee Route
        Route::post('/employee_register', 'EmployeeController@employeeRegister')->name('employee.register');
        Route::get('/employee_index/{id}', 'EmployeeController@employeeIndex')->name('employee.index');

        Route::resource('bread',  'BreadController');   //create BREAD (resource)

        Route::resource('users', 'UsersController')->except( ['create', 'store'] );

        Route::prefix('menu/menu')->group(function () { 
            Route::get('/',         'MenuEditController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuEditController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuEditController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuEditController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuEditController@update')->name('menu.menu.update');
            Route::get('/delete',   'MenuEditController@delete')->name('menu.menu.delete');
        });
        Route::prefix('menu/element')->group(function () { 
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });

        

        Route::resource('roles','RolesController');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
    });
});

