<?php

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');

Route::resource('devices', 'DeviceController');

Route::resource('pushLogs', 'PushLogController');

Route::resource('pushLogDetails', 'PushLogDetailController');