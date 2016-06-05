<?php

Config::set('site_name',"Your site name");

// Routes. Route name => method prefix

Config::set('routes', array(
        'default'=>'',
    'admin'=>'admin_',
));

Config::set('default_route', 'default');
Config::set('default_controller', 'main');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', "");
Config::set('db.db_name', 'module');

Config::set('salt','2345ferg83horh3hfwq');
Config::set('perPage','5');