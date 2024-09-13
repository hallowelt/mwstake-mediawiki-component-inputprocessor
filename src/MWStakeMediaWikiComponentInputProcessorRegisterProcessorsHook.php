<?php

namespace MWStake\MediaWiki\Component\InputProcessor;

interface MWStakeMediaWikiComponentInputProcessorRegisterProcessorsHook {

	/**
	 * @param array &$registry
	 * @return void
	 */
	public function onMWStakeMediaWikiComponentInputProcessorRegisterProcessors( &$registry ): void;
}
