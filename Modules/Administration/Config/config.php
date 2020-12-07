<?php

return [
    'name' => 'Administration',

    /*Administration Configuration parameters*/

    // Avoid multiple session for a user
    'avoid_multiple_session' => true,

    // Default register profile name
    'default_profile_name' => 'Subscriber',

    // General permissions that can be assigned as roles
    'permissions' => [
        'CREATE', 'READ', 'UPDATE', 'DELETE'
    ],

    // Default role permission
    'default_role_permission' => "READ",

    // Default assignable role name
    'default_role_name' => 'USER',
];
