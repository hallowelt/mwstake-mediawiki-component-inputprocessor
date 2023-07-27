<?php

if ( !defined( 'MEDIAWIKI' ) && !defined( 'MW_PHPUNIT_TEST' ) ) {
	return;
}

if ( defined( 'MWSTAKE_MEDIAWIKI_COMPONENT_INPUTPROCESSOR_VERSION' ) ) {
	return;
}

define( 'MWSTAKE_MEDIAWIKI_COMPONENT_INPUTPROCESSOR_VERSION', '1.0.0' );

MWStake\MediaWiki\ComponentLoader\Bootstrapper::getInstance()
->register( 'inputprocessor', static function () {
	$GLOBALS['wgServiceWiringFiles'][] = __DIR__ . '/includes/ServiceWiring.php';
	$GLOBALS['mwsgInputProcessorRegistry'] = [
		'integer' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\IntValue'
		],
		'integer-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\IntListValue'
		],
		'boolean' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\BoolValue'
		],
		'keyword' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\KeywordValue'
		],
		'keyword-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\KeywordListValue'
		],
		'title' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\TitleValue',
			'services' => [ 'TitleFactory', 'PermissionManager' ]
		],
		'title-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\TitleListValue',
			'services' => [ 'TitleFactory', 'PermissionManager' ]
		],
		'namespace' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\NamespaceValue',
			'services' => [ 'NamespaceInfo', 'PermissionManager' ]
		],
		'namespace-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\NamespaceListValue',
			'services' => [ 'NamespaceInfo', 'PermissionManager' ]
		],
		'category' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\CategoryValue',
			'services' => [ 'LoadBalancer', 'TitleFactory' ]
		],
		'category-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\CategoryListValue',
			'services' => [ 'LoadBalancer', 'TitleFactory' ]
		],
		'username' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\UsernameValue',
			'services' => [ 'UserFactory', 'PermissionManager', 'NamespaceInfo' ]
		],
		'username-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\UsernameListValue',
			'services' => [ 'UserFactory', 'PermissionManager', 'NamespaceInfo' ]
		],
		'usergroup' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\UsergroupValue',
			'services' => [ 'UserGroupManager' ]
		],
		'usergroup-list' => [
			'class' => 'MWStake\\MediaWiki\\Component\\InputProcessor\\UsergroupListValue',
			'services' => [ 'UserGroupManager' ]
		],
	];
} );
