<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor\Trait;

trait ListSplitterTrait {

	/** @var string|null */
	protected ?string $separator = null;

	/**
	 * @param string|null $separator
	 * @return static
	 */
	public function setListSeparator( ?string $separator ): static {
		$this->separator = $separator;
		return $this;
	}

	/**
	 * @param string $value
	 * @return array
	 */
	protected function splitList( string $value ): array {
		if ( $this->separator ) {
			$separators = [ $this->separator ];
		} else {
			$separators = [ ',', ';', '|' ];
		}

		// Split on separators
		$parts = preg_split( '/[' . preg_quote( implode( '', $separators ), '/' ) . ']/', $value );
		// Remove empty parts
		$parts = array_filter( $parts, 'strlen' );
		// Trim parts
		$parts = array_map( 'trim', $parts );
		return $parts;
	}
}
