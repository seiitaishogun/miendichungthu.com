<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->boolean('published')->default(false);
            $table->timestamp('published_at');
            $table->timestamps();
        });

        Schema::create('page_languages', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('slug')->index()->nullable();
            $table->string('description',320);
            $table->text('content');
            $table->mediumInteger('page_id', false, true)->index();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });

        /** create role and permission */
        /** @var \Modules\Acl\Models\Role $admin */
        $admin = \Modules\Acl\Models\Role::find(1);

        /** @var \Modules\Acl\Models\Permission $permission */
        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'page.page.index',
            'module' => 'page'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Xem danh sách các trang'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);

        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'page.page.create',
            'module' => 'page'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Tạo trang mới'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);

        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'page.page.edit',
            'module' => 'page'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Sửa trang'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);

        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'page.page.destroy',
            'module' => 'page'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Xóa trang'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);

        $permission = \Modules\Acl\Models\Permission::create([
            'slug' => 'page.page.publish',
            'module' => 'page'
        ]);
        $permission->saveLanguages([
            'language' => [
                'vi' => [
                    'description' => 'Thay đổi trạng thái của trang'
                ]
            ]
        ]);
        $admin->permissions()->attach($permission->id);


        /** @var \Modules\Menu\Models\MenuItem $menu */
        \Modules\Menu\Models\MenuItem::takeAPositionToEmpty(3);
        $menu = \Modules\Menu\Models\MenuItem::create([
            'attributes' => [
                'url' => '/iadmin/page',
                'id' => null,
                'class' => null,
                'rel' => 'dofollow',
                'icon' => 'fa fa-file-text-o',
                'target' => '_self',
                'permission' => 'page.page.index'
            ],
            'position' => 3,
            'level' => 0,
            'parent_id' => 0,
            'menu_id' => 1
        ]);
        $menu->saveLanguages([
            'language' => [
                'vi' => [
                    'name' => 'Trang nội dung',
                ]
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Modules\Acl\Models\Permission::where('module', 'page')->delete();
        \Modules\Menu\Models\MenuItem::where('attributes', 'like', '%page.page.%')
            ->get()
            ->each->delete();
        Schema::dropIfExists('page_languages');
        Schema::dropIfExists('pages');
    }
}
