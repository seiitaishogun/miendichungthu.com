<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desciption')->nullable();
            $table->timestamps();
        });
        
        Schema::create('customer_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desciption')->nullable();
            $table->timestamps();
        });
        
        /**
         * create role and permission
         */
        /** @var \Modules\Acl\Models\Role $admin */
        $admin = \Modules\Acl\Models\Role::find(1);
        
        /** @var \Modules\Acl\Models\Permission $permission */
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.group.index',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Xem danh sách nhóm khách hàng'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.group.create',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Tạo nhóm khách hàng mới'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.group.edit',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Sửa nhóm khách hàng'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.group.destroy',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Xóa nhóm khách hàng'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.source.index',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Xem danh sách nguồn khách hàng'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.source.create',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Tạo nguồn khách hàng mới'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.source.edit',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Sửa nguồn khách hàng'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
        
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'customer.source.destroy',
            'module' => 'customer'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Xóa nguồn khách hàng'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Modules\Acl\Models\Permission::where('module', 'customer')->delete();
        Schema::dropIfExists('customer_groups');
        Schema::dropIfExists('customer_sources');
    }
}
