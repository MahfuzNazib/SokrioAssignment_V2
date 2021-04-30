<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    private $menuId = null;
    private $dropdownId = array();
    private $dropdown = false;
    private $sequence = 1;
    private $joinData = array();
    private $adminRole = null;
    private $userRole = null;

    public function join($roles, $menusId){
        $roles = explode(',', $roles);
        foreach($roles as $role){
            array_push($this->joinData, array('role_name' => $role, 'menus_id' => $menusId));
        }
    }

    /*
        Function assigns menu elements to roles
        Must by use on end of this seeder
    */
    public function joinAllByTransaction(){
        DB::beginTransaction();
        foreach($this->joinData as $data){
            DB::table('menu_role')->insert([
                'role_name' => $data['role_name'],
                'menus_id' => $data['menus_id'],
            ]);
        }
        DB::commit();
    }

    public function insertLink($roles, $name, $href, $icon = null){
        if($this->dropdown === false){
            DB::table('menus')->insert([
                'slug' => 'link',
                'name' => $name,
                'icon' => $icon,
                'href' => $href,
                'menu_id' => $this->menuId,
                'sequence' => $this->sequence
            ]);
        }else{
            DB::table('menus')->insert([
                'slug' => 'link',
                'name' => $name,
                'icon' => $icon,
                'href' => $href,
                'menu_id' => $this->menuId,
                'parent_id' => $this->dropdownId[count($this->dropdownId) - 1],
                'sequence' => $this->sequence
            ]);
        }
        $this->sequence++;
        $lastId = DB::getPdo()->lastInsertId();
        $this->join($roles, $lastId);
        $permission = Permission::where('name', '=', $name)->get();
        if(empty($permission)){
            $permission = Permission::create(['name' => 'visit ' . $name]);
        }
        $roles = explode(',', $roles);
        if(in_array('employee', $roles)){
            $this->employeeRole->givePermissionTo($permission);
        }
        if(in_array('admin', $roles)){
            $this->adminRole->givePermissionTo($permission);
        }
        if(in_array('company', $roles)){
            $this->companyRole->givePermissionTo($permission);
        }
        if(in_array('manager', $roles)){
            $this->managerRole->givePermissionTo($permission);
        }
        return $lastId;
    }

    public function insertTitle($roles, $name){
        DB::table('menus')->insert([
            'slug' => 'title',
            'name' => $name,
            'menu_id' => $this->menuId,
            'sequence' => $this->sequence
        ]);
        $this->sequence++;
        $lastId = DB::getPdo()->lastInsertId();
        $this->join($roles, $lastId);
        return $lastId;
    }

    public function beginDropdown($roles, $name, $href='', $icon=''){
        if(count($this->dropdownId)){
            $parentId = $this->dropdownId[count($this->dropdownId) - 1];
        }else{
            $parentId = null;
        }
        DB::table('menus')->insert([
            'slug' => 'dropdown',
            'name' => $name,
            'icon' => $icon,
            'menu_id' => $this->menuId,
            'sequence' => $this->sequence,
            'parent_id' => $parentId,
            'href' => $href
        ]);
        $lastId = DB::getPdo()->lastInsertId();
        array_push($this->dropdownId, $lastId);
        $this->dropdown = true;
        $this->sequence++;
        $this->join($roles, $lastId);
        return $lastId;
    }

    public function endDropdown(){
        $this->dropdown = false;
        array_pop( $this->dropdownId );
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Get roles */
        $this->adminRole = Role::where('name' , '=' , 'admin' )->first();
        $this->employeeRole = Role::where('name', '=', 'employee' )->first();
        $this->companyRole = Role::where('name', '=', 'company' )->first();
        $this->managerRole = Role::where('name', '=', 'manager' )->first();


        $dropdownId = array();
        /* Create Sidebar menu */
        DB::table('menulist')->insert([
            'name' => 'sidebar menu'
        ]);
        $this->menuId = DB::getPdo()->lastInsertId();  //set menuId
        /* guest menu */
        $this->insertLink('company,employee,manager,admin', 'Dashboard', '/', 'cil-speedometer');
        $this->insertLink('company,employee,manager,admin', 'Login', '/login', 'cil-account-logout');
        $this->insertLink('company', 'Register', '/register', 'cil-account-logout');
        $this->beginDropdown('admin', 'Settings', '/settings', 'cil-puzzle');
            $this->insertLink('admin', 'Users',    '/users');
            $this->insertLink('admin', 'Menu',    '/menu');
        $this->endDropdown();
        // Form Panel
        $this->insertTitle('company,admin','Forms');
        $this->insertLink('company,admin', 'InvestigationCode', '/investigation_code', 'cil-drop');
        $this->insertLink('company,admin', 'Add Branch', '/investigation_code', 'cil-drop');


        // Adding Company Branch Menu Start

        $this->insertTitle('company,admin','Company Branch');
        $this->beginDropdown('company,admin', 'Branch', '/branch', 'cil-puzzle');
            $this->insertLink('company,admin', 'AllBranch','/branch_index');
            $this->insertLink('company,admin', 'CreateBranch', '/create_branch');
        $this->endDropdown();

        // Adding Company Branch Menu End

        // Create Company Employees Start
        $this->insertTitle('company,admin','Employees');
        $this->beginDropdown('company,admin', 'Employee', '/employee', 'cil-puzzle');
            $this->insertLink('company,admin', 'All Employee','/employee_index');
            $this->insertLink('company,admin', 'Add New Employee', '/employee_add');
        $this->endDropdown();
        // Create Company Employees End

        // ###########################
        // For Employee
        $this->insertLink('employee,admin', 'CheckIn', '/check_in', 'cil-drop');
        $this->insertLink('employee,admin', 'CheckOut', '/check_out', 'cil-drop');
        $this->insertLink('employee,admin', 'MyHistory', '/history', 'cil-drop');

        // ##########################
       

        /* Create top menu */
        DB::table('menulist')->insert([
            'name' => 'top_menu'
        ]);
        $this->menuId = DB::getPdo()->lastInsertId();  //set menuId
        $this->beginDropdown('company,employee,admin', 'Pages');
            $this->insertLink('companu,employee,admin', 'Dashboard',    '/');
            $this->insertLink('admin', 'Users',                   '/users');
        $this->endDropdown();
        $this->beginDropdown('admin', 'Settings');
            $this->insertLink('admin', 'Edit menu',               '/menu');
            $this->insertLink('admin', 'Edit roles',              '/roles');
            $this->insertLink('admin', 'Media',                   '/media');
        $this->endDropdown();
       

        $this->joinAllByTransaction(); ///   <===== Must by use on end of this seeder
    }
}
