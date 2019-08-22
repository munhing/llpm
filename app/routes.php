<?php

Route::filter('permitted', 'LLPM\Filters\PermittedFilter');


// Auth::attempting(function($credentials, $remember, $login)
// {
//     dd(Hash::make($credentials['password']));
// });
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
 */
/*
|--------------------------------------------------------------------------
| Test
|--------------------------------------------------------------------------
 */
Route::get('/create_admin_user', function () {

    if (!$munhing = User::where('username', 'admin')->first()) {
        var_dump('Creating username admin...');
        $munhing = User::create([
            'username' => 'admin',
            'email' => 'munhing1980@gmail.com',
            'password' => Hash::make('admin'),
        ]);
    } else {
        var_dump('admin already registered!');
    }

    if (!$admin = Role::where('role', 'ADMINISTRATOR')->first()) {
        var_dump('Creating ADMINISTRATOR Role...');
        $admin = Role::create([
            'role' => 'ADMINISTRATOR',
        ]);
    } else {
        var_dump("ADMINISTRATOR Role already registered!");
    }

    if (!$munhing->roles->contains($admin->id)) {
        var_dump('Adding admin role to munhing');
        $munhing->roles()->attach($admin);
    } else {
        dd('I am already an admin');
    }

});

Route::get('/test_view', function () {
    return View::make('vue');
});

Route::get('/excel', function () {

    Excel::load('custome_tariff_01.xls', function($reader) {

        $results = $reader->take(20);

        $results->each(function($sheet) {
            var_dump($sheet->header);
        });

    });
});

Route::get('/pusher', function () {

    $pusher_data = [
        "id" => "4,L,123456,HI",
        "container_no" => "ABAB1231234",
    ];

    $pusher = App::make('Pusher');
    $pusher->trigger('LLPM', 'CY1', json_encode($pusher_data));

    // $pusher_var = Config::get('services.pusher');
    // dd($pusher_var['key']);

    // return View::make('mobile/home', compact('pusher_var'));
});

Route::get('/ctnreport', function () {
    // dd('Container Report');
    $ctnlist = [];
    $ctn = ContainerWorkorderConfirmation::all();

    foreach($ctn as $con) {
        $ctnlist[$con->container_id][] = $con->toArray();
    }

    foreach($ctnlist as $c) {

    }

    dd($ctnlist);

});

Route::get('/log', function () {

    Activity::log('Some activity that you wish to log');
});

Route::get('/queue', function () {

    echo "This is a test queue!";

    Queue::push(function($job){
    
        $input = [
            'name' => 'Kevin SU',
            'email' => 'munhing1980@gmail.com',
            'comment' =>  'Testing queues',
            'subject' =>  'Testing Email Queues'
        ];

        Mail::queue('emails.welcome', $input, function($message) use ($input)
        {
            $message->to($input['email'], $input['name']);
            $message->subject($input['subject']);
        });

        $job->delete();
    
    });
});

Route::get('/test', function () {

    // return Redirect::route('home');

});

/*
|--------------------------------------------------------------------------
| Sessions
|--------------------------------------------------------------------------
 */

Route::post('authenticate', [
    'as' => 'authenticate',
    'uses' => 'PublicAuthController@checkAuth',
]);

Route::get('/', function () {
    // return View::make('pages/guest');
    return Redirect::route('home');
});

Route::get('login', [
    'as' => 'login',
    'uses' => 'SessionsController@login',
]);

Route::post('login', [
    'as' => 'login',
    'uses' => 'SessionsController@store',
]);

Route::get('reset', [
    'as' => 'reset',
    'uses' => 'SessionsController@reset',
]);

Route::post('reset', [
    'as' => 'reset',
    'uses' => 'SessionsController@postReset',
]);

Route::get('logout', [
    'as' => 'logout',
    'uses' => 'SessionsController@destroy',
]);

Route::get('secret_register', [
    'as' => 'secret_register',
    'uses' => 'UsersController@secretRegister',
]);

Route::post('secret_register', [
    'as' => 'secret_register',
    'uses' => 'UsersController@store',
]);

Route::post('register', [
    'as' => 'portuser_register',
    'uses' => 'UsersController@storePortUserRegister',
]);

 
/*
|--------------------------------------------------------------------------
| Password Reset
|--------------------------------------------------------------------------
 */

Route::controller('password', 'RemindersController');

/*
|--------------------------------------------------------------------------
| vue site
|--------------------------------------------------------------------------
 */
Route::group(['prefix' => 'vue'], function () {

    Route::get('/', [
        'as' => 'vue',
        'uses' => 'VueController@index'
    ]);

    Route::get('/api', [
        'as' => 'vue',
        'uses' => 'VueController@api'
    ]);    
});
/*
|--------------------------------------------------------------------------
| eTracking
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'etracking', 'before' => 'auth.portuser'], function () {

    Route::get('/', [
        'as' => 'etracking',
        'uses' => 'EtrackingController@index'
    ]);

    Route::get('/track', [
        'as' => 'etracking.track',
        'uses' => 'EtrackingController@track',
    ]);

    Route::get('/track/{container_id}', [
        'as' => 'etracking.detail',
        'uses' => 'EtrackingController@detail',
    ]);  

    Route::get('/profile', [
        'as' => 'etracking.profile',
        'uses' => 'EtrackingController@profile',
    ]); 

    Route::post('/update_profile', [
        'as' => 'etracking.profile.update',
        'uses' => 'EtrackingController@updateProfile',
    ]);  

    Route::post('/update_password', [
        'as' => 'etracking.profile.password',
        'uses' => 'EtrackingController@updatePassword',
    ]);          
});
/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'admin', 'before' => 'auth'], function () {

    // Auth::login(User::find(1));

    Route::get('/', [
        'as' => 'home',
        'uses' => 'DashboardController@index',       
    ]);

    Route::get('/search', [
        'as' => 'search',
        'uses' => 'SearchController@index',       
    ]);

    Route::get('/search/workorder', [
        'as' => 'search.workorder',
        'uses' => 'SearchController@workorder',       
    ]);

    Route::get('/search/container', [
        'as' => 'search.container',
        'uses' => 'SearchController@container',       
    ]); 

    Route::get('/search/cargo', [
        'as' => 'search.cargo',
        'uses' => 'SearchController@cargo',       
    ]); 

    Route::get('/search/manifest', [
        'as' => 'search.manifest',
        'uses' => 'SearchController@manifest',       
    ]);      
/*
|--------------------------------------------------------------------------
| Admin | Access Control
|--------------------------------------------------------------------------
 */
    // Route::group(['prefix' => 'access', 'before' => ['auth', 'permitted']], function() {

    Route::group(['prefix' => 'access', 'before' => ['permitted']], function () {

        Route::get('users', [
            'as' => 'users',
            'uses' => 'UsersController@index',
        ]);

        Route::get('users/register', [
            'as' => 'register',
            'uses' => 'UsersController@create',
        ]);

        Route::post('users/register', [
            'as' => 'register',
            'uses' => 'UsersController@store',
        ]);

        Route::post('users/update', [
            'as' => 'users.update',
            'uses' => 'UsersController@update',
        ]);

        Route::post('users/update_profile', [
            'as' => 'users.update.profile',
            'uses' => 'UsersController@updateProfile',
        ]);

        Route::post('users/update_password', [
            'as' => 'users.update.password',
            'uses' => 'UsersController@updatePassword',
        ]);

        Route::get('roles', [
            'as' => 'roles',
            'uses' => 'UsersController@indexRole',
        ]);

        Route::get('roles/create', [
            'as' => 'roles.create',
            'uses' => 'UsersController@createRole',
        ]);

        Route::post('roles/create', [
            'as' => 'roles.create',
            'uses' => 'UsersController@storeRole',
        ]);

        Route::get('roles/{role_id}/permissions', [
            'as' => 'roles.permissions',
            'uses' => 'UsersController@rolePermissions',
        ]);

        Route::post('roles/{role_id}/permissions', [
            'as' => 'roles.permissions',
            'uses' => 'UsersController@rolePermissionsUpdate',
        ]);

        Route::get('portusers', [
            'as' => 'portusers_access',
            'uses' => 'UsersController@indexPortUser',
        ]);

        Route::post('portusers/update', [
            'as' => 'portusers_access.update',
            'uses' => 'UsersController@updatePortUserRegister',
        ]);

        Route::post('portusers/approve', [
            'as' => 'portusers_access.approve',
            'uses' => 'UsersController@approvePortUser',
        ]);

        Route::post('portusers/disable', [
            'as' => 'portusers_access.disable',
            'uses' => 'UsersController@disablePortUser',
        ]);

        Route::post('portusers/enable', [
            'as' => 'portusers_access.enable',
            'uses' => 'UsersController@enablePortUser',
        ]);

        Route::get('permissions', [
            'as' => 'permissions',
            'uses' => 'UsersController@indexPermission',
        ]);

        Route::get('find', [
            'as' => 'users.find',
            'uses' => 'UsersController@getUsersByRole',
        ]); 

        Route::post('check_auth', [
            'as' => 'users.auth',
            'uses' => 'UsersController@checkAuth',
        ]);     

        Route::get('profile', [
            'as' => 'profile',
            'uses' => 'UsersController@profile',
        ]);                    
    });

/*
|--------------------------------------------------------------------------
| Admin | Manifest
|--------------------------------------------------------------------------
 */

    Route::group(['prefix' => 'manifest', 'before' => ['permitted']], function () {

        Route::any('schedule', [
            'as' => 'manifest.schedule',
            'uses' => 'VesselScheduleController@index',
        ]);

        Route::get('schedule/create', [
            'as' => 'manifest.schedule.create',
            'uses' => 'VesselScheduleController@create',
        ]);

        Route::post('schedule/create', [
            'as' => 'manifest.schedule.create',
            'uses' => 'VesselScheduleController@store',
        ]);

        Route::get('vessels', [
            'as' => 'manifest.vessels',
            'uses' => 'VesselsController@index',
        ]);

        Route::get('vessels/create', [
            'as' => 'manifest.vessels.create',
            'uses' => 'VesselsController@create',
        ]);

        Route::post('vessels/create', [
            'as' => 'manifest.vessels.create',
            'uses' => 'VesselsController@store',
        ]);

        Route::get('vessels/list', [
            'as' => 'manifest.vessels.list',
            'uses' => 'VesselsController@vesselList',
        ]);

        Route::get('schedule/{id}/edit', [
            'as' => 'manifest.schedule.edit',
            'uses' => 'VesselScheduleController@edit',
        ]);

        Route::post('schedule/{id}/edit', [
            'as' => 'manifest.schedule.edit',
            'uses' => 'VesselScheduleController@update',
        ]);

        Route::get('schedule/{id}/import', [
            'as' => 'manifest.schedule.import',
            'uses' => 'VesselScheduleController@showImport',
        ]);

        Route::get('schedule/{id}/export', [
            'as' => 'manifest.schedule.export',
            'uses' => 'VesselScheduleController@showExport',
        ]);

        Route::get('schedule/{id}/import/containers/create', [
            'as' => 'manifest.schedule.import.containers.create',
            'uses' => 'VesselScheduleController@createImportContainer',
        ]);

        Route::post('schedule/{id}/import/containers/create', [
            'as' => 'manifest.schedule.import.containers.create',
            'uses' => 'VesselScheduleController@storeImportContainer',
        ]);

        Route::post('schedule/{id}/import/containers/edit', [
            'as' => 'manifest.schedule.import.containers.edit',
            'uses' => 'VesselScheduleController@editContainer',
        ]);

        Route::post('schedule/{id}/import/containers/delete', [
            'as' => 'manifest.schedule.import.containers.delete',
            'uses' => 'VesselScheduleController@destroyImportContainer',
        ]);

        Route::get('schedule/{id}/import/cargoes/create', [
            'as' => 'manifest.schedule.import.cargoes.create',
            'uses' => 'VesselScheduleController@createImportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/create', [
            'as' => 'manifest.schedule.import.cargoes.create',
            'uses' => 'VesselScheduleController@storeImportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/delete', [
            'as' => 'manifest.schedule.import.cargoes.delete',
            'uses' => 'VesselScheduleController@deleteCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/delete', [
            'as' => 'manifest.schedule.export.cargoes.delete',
            'uses' => 'VesselScheduleController@deleteCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/containers/create', [
            'as' => 'manifest.schedule.import.cargoes.containers.create',
            'uses' => 'VesselScheduleController@addContainerToCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/item/create', [
            'as' => 'manifest.schedule.import.cargoes.item.create',
            'uses' => 'VesselScheduleController@addItemToCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/item/create', [
            'as' => 'manifest.schedule.export.cargoes.item.create',
            'uses' => 'VesselScheduleController@addItemToCargoExport',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/show', [
            'as' => 'manifest.schedule.import.cargoes.show',
            'uses' => 'VesselScheduleController@showImportCargo',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/generate', [
            'as' => 'manifest.schedule.import.cargoes.generate',
            'uses' => 'VesselScheduleController@generateDLImportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/generate', [
            'as' => 'manifest.schedule.export.cargoes.generate',
            'uses' => 'VesselScheduleController@generateDLExportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/show', [
            'as' => 'manifest.schedule.export.cargoes.show',
            'uses' => 'VesselScheduleController@showExportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/issue', [
            'as' => 'manifest.schedule.import.cargoes.issue',
            'uses' => 'VesselScheduleController@issueImportCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/issue', [
            'as' => 'manifest.schedule.export.cargoes.issue',
            'uses' => 'VesselScheduleController@issueExportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/detach', [
            'as' => 'manifest.schedule.import.cargoes.detach',
            'uses' => 'VesselScheduleController@detachImportCargo',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/edit', [
            'as' => 'manifest.schedule.import.cargoes.edit',
            'uses' => 'VesselScheduleController@editImportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/edit', [
            'as' => 'manifest.schedule.export.cargoes.edit',
            'uses' => 'VesselScheduleController@editExportCargo',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/{cargo_item_id}/edit', [
            'as' => 'manifest.schedule.import.cargoes.item.edit',
            'uses' => 'VesselScheduleController@editImportCargoItem',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/{cargo_item_id}/edit', [
            'as' => 'manifest.schedule.export.cargoes.item.edit',
            'uses' => 'VesselScheduleController@editExportCargoItem',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/item/update', [
            'as' => 'manifest.schedule.import.cargoes.item.update',
            'uses' => 'VesselScheduleController@updateImportCargoItem',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/item/update', [
            'as' => 'manifest.schedule.export.cargoes.item.update',
            'uses' => 'VesselScheduleController@updateExportCargoItem',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/update', [
            'as' => 'manifest.schedule.import.cargoes.update',
            'uses' => 'VesselScheduleController@updateImportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/edit', [
            'as' => 'manifest.schedule.export.cargoes.edit',
            'uses' => 'VesselScheduleController@editExportCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/update', [
            'as' => 'manifest.schedule.export.cargoes.update',
            'uses' => 'VesselScheduleController@updateExportCargo',
        ]);

        Route::get('schedule/search', [
            'as' => 'manifest.schedule.search',
            'uses' => 'VesselScheduleController@searchByVesselId',
        ]);

        Route::post('schedule/{schedule_id}/export/cargoes/{cargo_id}/unlink', [
            'as' => 'manifest.schedule.export.cargoes.container.unlink',
            'uses' => 'VesselScheduleController@unlinkContainer',
        ]);        
        
    });
/*
|--------------------------------------------------------------------------
| Admin | Receiving Advice
|--------------------------------------------------------------------------
 */

    Route::group(['prefix' => 'receiving', 'before' => ['permitted']], function () {

        Route::any('/', [
            'as' => 'receiving',
            'uses' => 'ReceivingController@index',
        ]);

        Route::get('{id}', [
            'as' => 'receiving.show',
            'uses' => 'ReceivingController@show',
        ]);

        Route::post('{id}', [
            'as' => 'receiving.container.delete',
            'uses' => 'ReceivingController@deleteContainer',
        ]);

        Route::get('{id}/cargo/{cargo_id}', [
            'as' => 'receiving.cargo.show',
            'uses' => 'ReceivingController@showCargo',
        ]);

        Route::post('{id}/cargo/{cargo_id}/issue', [
            'as' => 'receiving.cargo.issue',
            'uses' => 'ReceivingController@issueDL',
        ]);

        Route::post('{id}/cargo/{cargo_id}/item/create', [
            'as' => 'receiving.cargo.item.create',
            'uses' => 'ReceivingController@cargoItemCreate',
        ]);

        Route::get('{id}/cargo/{cargo_id}/item/{item_id}/edit', [
            'as' => 'receiving.cargo.item.edit',
            'uses' => 'ReceivingController@cargoItemEdit',
        ]);

        Route::post('{id}/cargo/{cargo_id}/item/update', [
            'as' => 'receiving.cargo.item.update',
            'uses' => 'ReceivingController@cargoItemUpdate',
        ]);

        Route::post('{id}/cargo/{cargo_id}', [
            'as' => 'receiving.cargo.container.unlink',
            'uses' => 'ReceivingController@unlinkContainer',
        ]);

        Route::get('{id}/cargo/{cargo_id}/edit', [
            'as' => 'receiving.cargo.edit',
            'uses' => 'ReceivingController@editCargo',
        ]);

        Route::post('{id}/cargo/{cargo_id}/edit', [
            'as' => 'receiving.cargo.edit',
            'uses' => 'ReceivingController@updateCargo',
        ]);

        Route::post('{id}/cargo/{cargo_id}/containers', [
            'as' => 'receiving.cargo.containers.create',
            'uses' => 'ReceivingController@associateContainersWithCargo',
        ]);

        Route::get('containers/create', [
            'as' => 'receiving.containers.create',
            'uses' => 'ReceivingController@createContainer',
        ]);

        Route::post('containers/create', [
            'as' => 'receiving.containers.create',
            'uses' => 'ReceivingController@storeContainer',
        ]);

        Route::post('containers/edit', [
            'as' => 'receiving.containers.edit',
            'uses' => 'ReceivingController@editContainer',
        ]);

        Route::get('cargoes/create', [
            'as' => 'receiving.cargoes.create',
            'uses' => 'ReceivingController@createCargo',
        ]);

        Route::post('cargoes/create', [
            'as' => 'receiving.cargoes.create',
            'uses' => 'ReceivingController@storeCargo',
        ]);

    });

/*
|--------------------------------------------------------------------------
| Admin | Movement
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'movement'], function () {

/*
|--------------------------------------------------------------------------
| Admin | WorkOrder
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'workorders', 'before' => ['permitted']], function () {

            Route::any('/', [
                'as' => 'workorders',
                'uses' => 'WorkOrderController@index',
            ]);

            Route::get('/create', [
                'as' => 'workorders.create',
                'uses' => 'WorkOrderController@create',
            ]);

            Route::post('/create', [
                'as' => 'workorders.create',
                'uses' => 'WorkOrderController@store',
            ]);

            Route::get('/carrier_list', [
                'as' => 'workorders.carrier_list',
                'uses' => 'WorkOrderController@carrierList',
            ]);

            Route::get('/handler_list', [
                'as' => 'workorders.handler_list',
                'uses' => 'WorkOrderController@handlerList',
            ]);

            Route::get('/container_list', [
                'as' => 'workorders.container_list',
                'uses' => 'WorkOrderController@containerList',
            ]);

            Route::get('{id}', [
                'as' => 'workorders.show',
                'uses' => 'WorkOrderController@show',
            ]);

            Route::get('{id}/generate', [
                'as' => 'workorders.generate',
                'uses' => 'WorkOrderController@generate_workorder',
            ]);

            Route::get('{id}/generate/handling', [
                'as' => 'workorders.generate.handling',
                'uses' => 'WorkOrderController@generate_handling',
            ]);

            Route::get('{id}/generate/storage', [
                'as' => 'workorders.generate.storage',
                'uses' => 'WorkOrderController@generate_storage',
            ]);

            Route::get('{id}/generate/bond', [
                'as' => 'workorders.generate.bond',
                'uses' => 'WorkOrderController@generate_bond',
            ]);

            Route::get('{id}/recalculate', [
                'as' => 'workorders.recalculate',
                'uses' => 'WorkOrderController@recalculate',
            ]);

            Route::get('{id}/recalculate_storage', [
                'as' => 'workorders.recalculate.storage',
                'uses' => 'WorkOrderController@recalculateStorage',
            ]);

            Route::get('{id}/recalculate_bond', [
                'as' => 'workorders.recalculate.bond',
                'uses' => 'WorkOrderController@recalculateBond',
            ]);

            Route::post('{id}/finalize', [
                'as' => 'workorders.finalize',
                'uses' => 'WorkOrderController@finalize',
            ]);

            Route::post('{id}', [
                'as' => 'workorders.show',
                'uses' => 'WorkOrderController@cancelContainer',
            ]);

            Route::get('/unstuffing/create', [
                'as' => 'workorders.unstuffing',
                'uses' => 'WorkOrderController@createUnstuffing',
            ]);

            Route::post('/unstuffing/create', [
                'as' => 'workorders.unstuffing',
                'uses' => 'WorkOrderController@storeUnstuffing',
            ]);

            Route::get('/stuffing/create', [
                'as' => 'workorders.stuffing',
                'uses' => 'WorkOrderController@createStuffing',
            ]);

            Route::post('/stuffing/create', [
                'as' => 'workorders.stuffing',
                'uses' => 'WorkOrderController@storeStuffing',
            ]);

            Route::post('{workorder_id}/add', [
                'as' => 'workorders.containers.add',
                'uses' => 'WorkOrderController@addContainers',
            ]);   
            Route::post('{workorder_id}/agent', [
                'as' => 'workorders.agent',
                'uses' => 'WorkOrderController@storeAgent',
            ]);                     
        });

/*
|--------------------------------------------------------------------------
| Admin | Containers
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'containers', 'before' => ['permitted']], function () {

            Route::get('/', [
                'as' => 'containers',
                'uses' => 'ContainerController@index',
            ]);

            Route::get('/report', [
                'as' => 'containers.report',
                'uses' => 'ContainerController@report',
            ]);

            Route::get('/{container_id}', [
                'as' => 'containers.show',
                'uses' => 'ContainerController@show',
            ]);

        });

/*
|--------------------------------------------------------------------------
| Admin | Container Confirmation
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'confirmation', 'before' => ['permitted']], function () {

            Route::get('/', [
                'as' => 'confirmation',
                'uses' => 'ContainerConfirmationController@index',
            ]);

            Route::post('/', [
                'as' => 'confirmation',
                'uses' => 'ContainerConfirmationController@update',
            ]);

        });

    });

/*
|--------------------------------------------------------------------------
| Admin | Cargo
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'cargo', 'before' => ['permitted']], function () {

        Route::get('/list', [
            'as' => 'cargo',
            'uses' => 'CargoController@index',
        ]);
/*
|--------------------------------------------------------------------------
| Admin | Cargo Confirmation
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'confirmation', 'before' => ['permitted']], function () {

            Route::get('import', [
                'as' => 'cargo.confirmation.import',
                'uses' => 'CargoConfirmationController@indexImport',
            ]);

            Route::post('import', [
                'as' => 'cargo.confirmation.import',
                'uses' => 'CargoConfirmationController@updateImport',
            ]);

            Route::get('export', [
                'as' => 'cargo.confirmation.export',
                'uses' => 'CargoConfirmationController@indexExport',
            ]);

            Route::post('export', [
                'as' => 'cargo.confirmation.export',
                'uses' => 'CargoConfirmationController@updateExport',
            ]);

        });

    });

/*
|--------------------------------------------------------------------------
| Admin | Tracking
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'tracking', 'before' => ['permitted']], function () {

        Route::get('/container', [
            'as' => 'tracking.container',
            'uses' => 'TrackingController@index',
        ]);

        Route::get('/container/track', [
            'as' => 'tracking.container.track',
            'uses' => 'TrackingController@track',
        ]);

        Route::get('/container/track/{container_id}', [
            'as' => 'tracking.container.detail',
            'uses' => 'TrackingController@detail',
        ]);       
    });
/*
|--------------------------------------------------------------------------
| Admin | Reports
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'reports', 'before' => ['permitted']], function () {

        Route::get('/', [
            'as' => 'reports',
            'uses' => 'ReportsController@index',
        ]);

        Route::get('/container/loading_discharging/conf', [
            'as' => 'reports.container.loading.discharging.conf',
            'uses' => 'ReportsController@containerLoadingDischargingConf',
        ]); 

        Route::get('/container/loading_discharging/rpt', [
            'as' => 'reports.container.loading.discharging.rpt',
            'uses' => 'ReportsController@containerLoadingDischargingRpt',
        ]);

        Route::get('/container/movement/conf', [
            'as' => 'reports.container.movement.conf',
            'uses' => 'ReportsController@containerMovementConf',
        ]);

        Route::get('/container/movement/rpt', [
            'as' => 'reports.container.movement.rpt',
            'uses' => 'ReportsController@containerMovementRpt',
        ]); 

        Route::get('/container/teus/conf', [
            'as' => 'reports.container.teus.conf',
            'uses' => 'ReportsController@totalTEUsConf',
        ]); 

        Route::get('/container/teus/rpt', [
            'as' => 'reports.container.teus.rpt',
            'uses' => 'ReportsController@totalTEUsRpt',
        ]);   

        Route::get('/container/total/rpt', [
            'as' => 'reports.container.total.rpt',
            'uses' => 'ReportsController@totalRpt',
        ]); 

        Route::get('/container/transfertocy3/conf', [
            'as' => 'reports.container.transfer.to.CY3.conf',
            'uses' => 'ReportsController@containerTransferToCY3Conf',
        ]); 

        Route::get('/container/transfertocy3/rpt', [
            'as' => 'reports.container.transfer.to.CY3.rpt',
            'uses' => 'ReportsController@containerTransferToCY3Rpt',
        ]);

        Route::get('/container/transfertocy1/conf', [
            'as' => 'reports.container.transfer.to.CY1.conf',
            'uses' => 'ReportsController@containerTransferToCY1Conf',
        ]); 

        Route::get('/container/transfertocy1/rpt', [
            'as' => 'reports.container.transfer.to.CY1.rpt',
            'uses' => 'ReportsController@containerTransferToCY1Rpt',
        ]);

        Route::get('/cargo/mt/conf', [
            'as' => 'reports.cargo.mt.conf',
            'uses' => 'ReportsController@cargoMtConf',
        ]);

        Route::get('/cargo/mt/rpt', [
            'as' => 'reports.cargo.mt.rpt',
            'uses' => 'ReportsController@cargoMtRpt',
        ]);

        Route::get('/cargo/containerized/mt/conf', [
            'as' => 'reports.cargo.containerized.mt.conf',
            'uses' => 'ReportsController@cargoContainerizedMtConf',
        ]);

        Route::get('/cargo/containerized/mt/rpt', [
            'as' => 'reports.cargo.containerized.mt.rpt',
            'uses' => 'ReportsController@cargoContainerizedMtRpt',
        ]);

        Route::get('/cargo/loose/mt/conf', [
            'as' => 'reports.cargo.loose.mt.conf',
            'uses' => 'ReportsController@cargoLooseMtConf',
        ]);

        Route::get('/cargo/loose/mt/rpt', [
            'as' => 'reports.cargo.loose.mt.rpt',
            'uses' => 'ReportsController@cargoLooseMtRpt',
        ]);

        Route::get('/cargo/top_import/conf', [
            'as' => 'reports.cargo.top.import.conf',
            'uses' => 'ReportsController@cargoTopImportConf',
        ]);

        Route::get('/cargo/top_import/rpt', [
            'as' => 'reports.cargo.top.import.rpt',
            'uses' => 'ReportsController@cargoTopImportRpt',
        ]);

        Route::get('/cargo/top_export/conf', [
            'as' => 'reports.cargo.top.export.conf',
            'uses' => 'ReportsController@cargoTopExportConf',
        ]);

        Route::get('/cargo/top_export/rpt', [
            'as' => 'reports.cargo.top.export.rpt',
            'uses' => 'ReportsController@cargoTopExportRpt',
        ]);

        Route::get('/cargo/list_import/conf', [
            'as' => 'reports.cargo.list.import.conf',
            'uses' => 'ReportsController@cargoListImportConf',
        ]);

        Route::get('/cargo/list_import/rpt', [
            'as' => 'reports.cargo.list.import.rpt',
            'uses' => 'ReportsController@cargoListImportRpt',
        ]);

        Route::get('/cargo/list_export/conf', [
            'as' => 'reports.cargo.list.export.conf',
            'uses' => 'ReportsController@cargoListExportConf',
        ]);

        Route::get('/cargo/list_export/rpt', [
            'as' => 'reports.cargo.list.export.rpt',
            'uses' => 'ReportsController@cargoListExportRpt',
        ]);

        Route::get('/cargo/origin/conf', [
            'as' => 'reports.cargo.origin.conf',
            'uses' => 'ReportsController@cargoOriginConf',
        ]);

        Route::get('/cargo/origin/rpt', [
            'as' => 'reports.cargo.origin.rpt',
            'uses' => 'ReportsController@cargoOriginRpt',
        ]);

        Route::get('/cargo/destination/conf', [
            'as' => 'reports.cargo.destination.conf',
            'uses' => 'ReportsController@cargoDestinationConf',
        ]);

        Route::get('/cargo/destination/rpt', [
            'as' => 'reports.cargo.destination.rpt',
            'uses' => 'ReportsController@cargoDestinationRpt',
        ]);

        Route::get('/vessel/total/conf', [
            'as' => 'reports.vessel.total.conf',
            'uses' => 'ReportsController@totalVesselConf',
        ]); 

        Route::get('/vessel/total/rpt', [
            'as' => 'reports.vessel.total.rpt',
            'uses' => 'ReportsController@totalVesselRpt',
        ]); 

        Route::get('/vessel/top/conf', [
            'as' => 'reports.vessel.top.conf',
            'uses' => 'ReportsController@vesselTopConf',
        ]);  

        Route::get('/vessel/top/rpt', [
            'as' => 'reports.vessel.top.rpt',
            'uses' => 'ReportsController@vesselTopRpt',
        ]);        

        Route::get('/vessel/top_agent/conf', [
            'as' => 'reports.vessel.top.agent.conf',
            'uses' => 'ReportsController@vesselTopAgentConf',
        ]);

        Route::get('/vessel/top_agent/rpt', [
            'as' => 'reports.vessel.top.agent.rpt',
            'uses' => 'ReportsController@vesselTopAgentRpt',
        ]);

        Route::get('/misc/top_consignee/conf', [
            'as' => 'reports.misc.consignee.top.conf',
            'uses' => 'ReportsController@consigneeTopConf',
        ]);

        Route::get('/misc/top_consignee/rpt', [
            'as' => 'reports.misc.consignee.top.rpt',
            'uses' => 'ReportsController@consigneeTopRpt',
        ]);

        Route::get('/misc/top_consignor/conf', [
            'as' => 'reports.misc.consignor.top.conf',
            'uses' => 'ReportsController@consignorTopConf',
        ]); 

        Route::get('/misc/top_consignor/rpt', [
            'as' => 'reports.misc.consignor.top.rpt',
            'uses' => 'ReportsController@consignorTopRpt',
        ]);        

                            
    });

/*
|--------------------------------------------------------------------------
| Admin | Customs Tariff
|--------------------------------------------------------------------------
 */
    Route::get('tariff', [
        'as' => 'tariff',
        'uses' => 'TariffController@index',
    ]);

    Route::get('tariff/find', [
        'as' => 'tariff.find',
        'uses' => 'TariffController@find',
    ]);
    
/*
|--------------------------------------------------------------------------
| Admin | Port Users
|--------------------------------------------------------------------------
 */
    Route::get('portusers', [
        'as' => 'portusers',
        'uses' => 'PortUsersController@index',
    ]);

    Route::get('portusers/create', [
        'as' => 'portusers.create',
        'uses' => 'PortUsersController@create',
    ]);

    Route::post('portusers/create', [
        'as' => 'portusers.create',
        'uses' => 'PortUsersController@store',
    ]);

/*
|--------------------------------------------------------------------------
| Admin | Statistics
|--------------------------------------------------------------------------
 */
    Route::get('statistics/dashboard', [
        'as' => 'statistics.dashboard',
        'uses' => 'StatisticsController@dashboard',
    ]);

/*
|--------------------------------------------------------------------------
| Admin | Settings
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'settings', 'before' => 'permitted'], function () {
        
        Route::get('fees', [
            'as' => 'settings.fees',
            'uses' => 'SettingsController@feesIndex',
        ]);

        Route::post('fees', [
            'as' => 'settings.fees',
            'uses' => 'SettingsController@feesStore',
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'mobile', 'before' => 'auth.mobile'], function () {

    Route::get('/', [
        'as' => 'mobile',
        'uses' => 'MobileController@overview',
    ]);

    Route::post('/find', [
        'as' => 'mobile.find',
        'uses' => 'MobileController@getActiveByContainerNo',
    ]);

    Route::post('/confirmation', [
        'as' => 'mobile.confirm',
        'uses' => 'MobileController@confirmation',
    ]);

    Route::post('/pwdcheck', [
        'as' => 'mobile.pwdcheck',
        'uses' => 'MobileController@pwdCheck',
    ]);

    Route::get('/refresh', [
        'as' => 'mobile.refresh',
        'uses' => 'MobileController@refresh',
    ]);

});
