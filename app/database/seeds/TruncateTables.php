<?php

class TruncateTables extends Seeder
{

	public function run()
	{

        $tables = [

            // 'activity_log',
            // 'cargo_container',
            // 'cargo_items',
            // 'cargoes',
            'container_workorder',
            // 'container_workorder_confirmation',
            'containers'
            // 'export_dl',
            // 'import_dl',
            // 'm_cargo_container',
            // 'port_users',
            // 'receiving',
            // 'vessel_schedule',
            // 'vessels',
            // 'workorders'
            // 'settings',
            // 'roles'
            // 'users'
            // 'permissions'
            // 'fees'
            // 'custom_tariff'
            // 'container_confirmation_process'
            // 'permission_role'
            // 'role_user',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');                            
	}
}