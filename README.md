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