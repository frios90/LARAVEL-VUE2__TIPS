<?php
    Route::get('/',         'Auth\LoginController@index');
    Route::get('login',    'Auth\LoginController@index')->name('login');
    Route::post('/sing-in', [ 'as' => '/sing-in', 'uses' => 'Auth\LoginController@singIn']);
    Route::post('/log-out', [ 'as' => '/log-out', 'uses' => 'Auth\LoginController@logOut']);
    Route::get('/test-mail', function () {
        $data_user['rut']        = '174828350-0';
        $data_user['name']       = 'Francisco Rios Castillo ';
        $data_user['address']    = 'Club Hípico 475'; 
        $data_user['phone']      = '949500353';
        $data_user['email']      = 'franciscorios.castillo2q@gmail.com';
        $data_user['profile_id'] = '5';
        $data_user['company_id'] = 2;
        $data_user['password']   = '17482835';
        $data_user['company_name']           = 'Fejhus Bar';
        $data_user['company_rut']            = '77.200.200-8';
        $data_user['company_address']        = 'providencia 4567';
        $data_user['company_license']        = 'Licencia PRO';
        $data_user['company_qty_staff']      = '50';    
        $data_user['company_qty_user']       = '1';    
        $data_user['company_qty_work_month'] = '500';    
        return view('mails.new_user_mail', ['user'=>$data_user]);
    });

    /**Rutas de EMPRESAS */
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['middleware' => ['god']], function () {
            Route::get('/company',                      'Tips\CompanyController@index');
            Route::get('/get-company',                  'Tips\CompanyController@getCompany')->name('/get-company');
            Route::get('/company/create',               'Tips\CompanyController@index');
            Route::get('/company/edit/{id}',            'Tips\CompanyController@index');
            Route::post('/company-store',               'Tips\CompanyController@store');
            Route::post('/company-update',              'Tips\CompanyController@update');
            Route::post('/company-status',              'Tips\CompanyController@status');
            Route::get('/company-table-list',           'Tips\CompanyController@getTableList');
            Route::get('/company-select-list',          'Tips\CompanyController@getList')->name('/company-select-list'); 
            Route::get('/company/{id}/users',           'Tips\CompanyController@index')->name('comapany.users');
            Route::get('/company/{company_id}/users/edit/{id}',  'Tips\CompanyController@index');
            Route::group(['middleware' => ['licenseUser']], function () {   
                Route::get('/company/{company_id}/users/create',  'Tips\CompanyController@index');
            });
            Route::post('/user-store',                  'Tips\UserController@store');
            Route::get('/company-get-users',            'Tips\UserController@getUsersCompany')->name('/company-get-users');
            Route::get('/company-get-user',             'Tips\UserController@getUserCompany')->name('/company-get-user');
            Route::post('/user-update',                 'Tips\UserController@update');
            Route::post('/user-status',                 'Tips\UserController@status');
        });
        Route::get('/home', 'Tips\HomeController@index')->name('home');

        Route::get('/validate-god-menu',                'Tips\UserController@validateGodMenu')->name('/validate-god-menu');
        
        /**Rutas de LICENCIAS */
        Route::get('/license',            'Tips\LicenseController@index')->name('license');
        Route::get('/licenses-list',      'Tips\LicenseController@getList')->name('/licenses-list');
        Route::get('/license-allowed',    'Tips\LicenseController@getLicenseAllowed')->name('/license-allowed');
        Route::post('/license-store',     'Tips\LicenseController@store');
        Route::get('/license/edit/{id}',  'Tips\LicenseController@index');       
        Route::post('/license-update',    'Tips\LicenseController@update');
        Route::post('/license-status',    'Tips\LicenseController@status');
        Route::get('/license-table-list', 'Tips\LicenseController@getTableList');
        Route::get('/get-license',        'Tips\LicenseController@getLicense')->name('/get-license');
        /**User me */
        Route::get('/me',                               'Tips\CompanyController@index');
        Route::post('/user-me-update',                  'Tips\UserController@updateMe');
        Route::post('/user-me-update-two',              'Tips\UserController@updateMePass');
        Route::post('/reset-pass',                      'Tips\UserController@resetPass');
        

        Route::get('/get-user-me', 'Tips\UserController@getUserMe')->name('/get-user-me');
        /**Rutas de STAFF */
        Route::get('/staff',                            'Tips\StaffController@index')->name('staff');
        Route::get('/get-staff',                        'Tips\StaffController@getStaff')->name('/get-staff');
        Route::group(['middleware' => ['licenseStaff']], function () {   
            Route::get('/staff/create',                 'Tips\StaffController@index');
        });
        Route::post('/staff-store',                     'Tips\StaffController@store');
        Route::get('/staff/edit/{id}',                  'Tips\StaffController@index');       
        Route::post('/staff-update',                    'Tips\StaffController@update');
        Route::post('/staff-status',                    'Tips\StaffController@status');
        Route::get('/staff-table-list',                 'Tips\StaffController@getTableList');
        Route::get('/staff-select-list-with-trashed',   'Tips\StaffController@getListWithTrashed')->name('/staff-select-list-with-trashed');
        Route::get('/staff-select-list',                'Tips\StaffController@getList')->name('/staff-select-list');
        Route::get('/staff-percentages',                'Tips\StaffController@getStaffPercentages')->name('/staff-percentages');

        /**Rutas para tips */
        Route::group(['middleware' => ['licenseTipWork']], function () {   
            Route::get('/tips',                          'Tips\TipController@index');
            Route::post('/tips-store',                   'Tips\TipController@store');
        });
        Route::post('/tips-store',                       'Tips\TipController@store');
        Route::get('/tip-table-list',                    'Tips\TipController@getTableList');
        Route::get('/tip/see/{id}',                      'Tips\TipController@index');
        Route::get('/get-tip-work',                      'Tips\TipController@getTipWork')->name('/get-tip-work');
        Route::post('/tips-update',                      'Tips\TipController@update');
        
        /**Rutas de región */
        Route::get('/region-list',                       'Tips\RegionController@getList')->name('/region-list');

        /**Rutas de comunas */
        Route::get('/commune-list',                      'Tips\CommuneController@getList')->name('/commune-list');
        
        Route::get('/profile-list',                      'Tips\ProfileController@getList')->name('/profile-list');
      
        /**Rutas de porcentaje */
        Route::post('/percentage-update',                'Tips\StaffTypeController@percentageUpdate')->name('/percentage-update');

        /**reportes  */
        Route::get('/get-info-charts-percentage',        'Tips\ReportsController@getUserChartPercentages')->name('/get-info-charts-percentage');
        Route::get('/get-charts-total-tips',             'Tips\ReportsController@getChartTotalTips')->name('/get-charts-total-tips');
        Route::get('/get-charts-progress-week',          'Tips\ReportsController@getChartProgressWeek')->name('/get-charts-progress-week');
        Route::get('/get-info-total-reports',            'Tips\ReportsController@getInfoTotalReports')->name('/get-info-total-reports');
        Route::get('/get-global-chart',                         'Tips\ReportsController@getGlobalChart')->name('/get-global-chart');
        Route::get('/get-charts-licenses',               'Tips\ReportsController@getChartLicenses')->name('/get-charts-licenses');
        Route::get('/get-chart-staff-week',              'Tips\ReportsController@getChartStaffWeek')->name('/get-chart-staff-week');
    });




