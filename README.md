# MediaWiki Stakeholders Group - Components
# InputProcessor for MediaWiki

Provides a simple framework for processing user input, e.g. from tags, parserfunctions, API paramters, etc.

**This code is meant to be executed within the MediaWiki application context. No standalone usage is intended.**

## Compatibility
- `1.0.x` -> MediaWiki 1.39

## Use in a MediaWiki extension

Require this component in the `composer.json` of your extension:

```json
{
	"require": {
		"mwstake/mediawiki-component-inputprocessor": "~1"
	}
}
```

## Usage

Example:
```php
// Expected input description
$inputDesc = [
	'source-namespaces' => [
		'type' => 'namespace-list',
		'default' => [ NS_MAIN ],
		'exclude' => [ NS_MEDIAWIKI, NS_CATEGORY ]
	],
	'count' => [
		'type' => 'integer',
		'default' => 10,
		'min' => 1,
		'max' => 25
	],
	'label' => [
		'type' => 'string',
		'default' => 'My label'
	]
]

// User provided input
$paramters = [
	'source-namespaces' => '0|Help|User|Foo',
	'count' => '5'
];

// Process input
$runner = MediaWiki\MediaWikiServices::getInstance()->getService( 'MWStakeInputProcessor' );
$runner->process( $inputDesc, $parameters );
if ( $runner->hasErrors() ) {
	$errors = $runner->getErrors();
	// Do something with the errors
}
else {
	$processedInput = $runner->getProcessedInput();
	/*
	 * $processedInput = [
	 *     'source-namespaces' => [ 0, 12, 2, 4 ],
	 *     'count' => 5,
	 *     'label' => 'My label'
	 * ]
	 */
}
```
