<?php
return array(
	//'配置项'=>'配置值'
    'URL_PATHINFO_DEPR'=>'-',
    'URL_MODEL' => 2,

    'DEFAULT_MODULE'=> 'Student',
    'MODULE_ALLOW_LIST' => array('Student', 'Worker', 'Admin', 'System'),    // 允许访问的模块列表

    'authcode'=>'mFpUUdciguw7uq5DnMb6f1FnMlgcFdCW', //加密串

    //'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息

    'TMPL_TEMPLATE_SUFFIX' => '.php',     // 默认模板文件后缀

    'COOKIE_PREFIX' => 'stusys_',      // Cookie前缀 避免冲突


    'DATA_CACHE_TIME'       =>  604800,      // 数据缓存有效期 0表示永久缓存
    'DATA_CACHE_COMPRESS' => true, // 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK' => true, // 数据缓存是否校验缓存

    //开启路由
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
        'd/:code' => array('Student/Public/detail')
    ),

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'app_stusys', // 数据库名
    'DB_USER'   => 'app_stusys', // 用户名
    'DB_PWD'    => 'Fytx526EZXIVgA1wmxHpfMF3Lg0MW7YD', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀

    // 关闭字段缓存
    //'DB_FIELDS_CACHE'=>false

    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',
);