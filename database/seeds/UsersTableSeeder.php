<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Admin;
use App\Models\SysSetting;
use App\Models\Banner;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->delete();
        DB::table('admins')->delete();
        DB::table('roles')->delete();
        DB::table('sys_settings')->delete();
        DB::table('permissions')->delete();
        // DB::table('banners')->delete();

        SysSetting::create([
            'intro' => '关于我们',
            'daili' => '代理介绍',
            'share_content' => '分享的页面内容',
            'name' => '网站名称',
            'scale' => 10,
            'scale_level2' => 0,
            'post_per_page' => 15,
            'shoufei_xinyongka' => 1,
            'shoufei_jieqian' => 1,
        ]);
        
        // User::create([
        //     'name' => '用户',
        //     'email' => 'zcjy@foxmail.com',
        //     'password'=>Hash::make('123456'),
        //     'mobile' => '18717160163',
        //     'status' => '正常',
        // ]);

        $user_super = Admin::create([
            'name' => '超级管理员',
            'email' => 'zcjy@foxmail.com',
            'password'=>Hash::make('zcjyadmin'),
        ]);

        $user_admin = Admin::create([
            'name' => '管理员',
            'email' => 'manager@foxmail.com',
            'password'=>Hash::make('zcjymanager*'),
        ]);

        $user_editor = Admin::create([
            'name' => '编辑',
            'email' => 'editor@foxmail.com',
            'password'=>Hash::make('zcjyeditor*'),
        ]);

        // Banner::create([
        //     'name' => '首页',
        //     'slug' => 'index'
        // ]);

        // Banner::create([
        //     'name' => '学习',
        //     'slug' => 'learn'
        // ]);

        // Banner::create([
        //     'name' => '直播',
        //     'slug' => 'live'
        // ]);

        // Banner::create([
        //     'name' => '工具',
        //     'slug' => 'tool'
        // ]);

        // Banner::create([
        //     'name' => '贷款',
        //     'slug' => 'dk'
        // ]);

        // Banner::create([
        //     'name' => '信用卡',
        //     'slug' => 'xyk'
        // ]);

        //所有功能
        $super_admin = Role::create(['guard_name' => 'admin', 'name' => '超级管理员']);
        //除去会员卡设置、会员管理，账户管理之外的所有功能
        $admin = Role::create(['guard_name' => 'admin', 'name' => '管理员']);
        //只有文章编辑功能
        $editor = Role::create(['guard_name' => 'admin', 'name' => '文章编辑']);

        //文章编辑
        $article = Permission::create(['guard_name' => 'admin', 'name' => '文章编辑']);
        //查看销售统计
        $stats = Permission::create(['guard_name' => 'admin', 'name' => '查看统计']);
        //修改会员状态及提成比例
        $member = Permission::create(['guard_name' => 'admin', 'name' => '会员管理']);

        //网站设置，提成比例，会员卡销售金额等信息
        $setting = Permission::create(['guard_name' => 'admin', 'name' => '网站设置']);


        //网站设置，提成比例，会员卡销售金额等信息
        $share = Permission::create(['guard_name' => 'admin', 'name' => '分化平台']);

        $shop = Permission::create(['guard_name' => 'admin', 'name' => '商城管理']);

        $super_admin->givePermissionTo(['文章编辑', '查看统计', '会员管理', '网站设置', '分化平台','商城管理']);

        $admin->givePermissionTo(['文章编辑', '查看统计', '会员管理']);
        $editor->givePermissionTo(['文章编辑']);

        $user_super->assignRole('超级管理员');
        $user_admin->assignRole('管理员');
        $user_editor->assignRole('文章编辑');
    }
}
