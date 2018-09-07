<?php
return array(
	'admin/banners/add' => 'adminBanner/add',
	'admin/banners/update/([1-9]+)' => 'adminBanner/update/$1',
    'admin/banners/remove/([1-9]+)' => 'adminBanner/remove/$1',
    'admin/banners' => 'adminBanner/index',
        
    'admin/photo/delete/([0-9]+)' => 'adminPhoto/deleteOnePhoto/$1',
    'admin/photo/deletemassive/([0-9]+)' => 'adminPhoto/deleteMassivePhoto/$1',
	'admin/photo/edit/([0-9]+)' => 'adminPhoto/edit/$1',
	'admin/photo/add/([0-9]+)' => 'adminPhoto/add/$1',
	'admin/photo/create' => 'adminPhoto/create',
	'admin/photo/update/([0-9]+)' => 'adminPhoto/update/$1',
    'admin/photo/deletecat/([0-9]+)' => 'adminPhoto/deleteCat/$1',
    'admin/photo' => 'adminPhoto/index',
    
    'admin/music/add' => 'adminMusic/add',
	'admin/music/update/([1-9]+)' => 'adminMusic/update/$1',
    'admin/music/remove/([1-9]+)' => 'adminMusic/remove/$1',
    'admin/music' => 'adminMusic/index',    

	'admin/about/delete/([0-9]+)' => 'adminAbout/delete/$1',	
	'admin/about/update/([0-9]+)' => 'adminAbout/update/$1',	
	'admin/about/create' => 'adminAbout/create',	
	'admin/about' => 'adminAbout/index',

	'admin/video/delete/([0-9]+)' => 'adminVideo/delete/$1',	
	'admin/video/update/([0-9]+)' => 'adminVideo/update/$1',	
	'admin/video/create' => 'adminVideo/create',	
	'admin/video' => 'adminVideo/index',
	
	'admin/contacts' => 'adminContacts/index',	
	
	'admin/news/delete/([0-9]+)' => 'adminNews/delete/$1',	
	'admin/news/update/([0-9]+)' => 'adminNews/update/$1',	
	'admin/news/create' => 'adminNews/create',	
	'admin/news/page-([0-9]+)' => 'adminNews/index/$1',
	'admin/news' => 'adminNews/index',
	
	'admin/delete/([0-9]+)' => 'admin/delete/$1',	
	'admin/read/([0-9]+)' => 'admin/read/$1',	
	'admin' => 'admin/index', 
	
	'user/login' => 'user/login',
	'user/check' => 'user/check',
	'user/logout' => 'user/logout',
    'emailus' => 'home/emailUs',
    'photos/([0-9]+)' => 'photo/view/$1',
    'news/view/([0-9]+)' => 'news/view/$1',
    'news' => 'news/index',
    '' => 'home/index',
);

