<?php

namespace MWStake\MediaWiki\Component\InputProcessor\Processor;

use Language;
use MWStake\MediaWiki\Component\InputProcessor\ProcessorBase;
use Status;

class NamespaceListValue extends ProcessorBase {

	/** @var Language */
	private $contentLanguage = null;

	/** @var NamespaceInfo */
	private $namespaceInfo = null;

	/**
	 * @param NamespaceInfo $namespaceInfo
	 * @param Language $contentLanguage
	 */
	public function __construct( $contentLanguage, $namespaceInfo ) {
		parent::__construct();
		$this->contentLanguage = $contentLanguage;
		$this->namespaceInfo = $namespaceInfo;
	}

	protected function doProcess( $value ) {
		/*
		// FROM https://github.com/wikimedia/mediawiki-extensions-BlueSpiceFoundation/blob/4b10509d680ca3e2e72cc5ba02bf8ece76ccc8eb/includes/utility/NamespaceHelper.class.php#L189-L250
		if ( !isset( $sCSV ) || !is_string( $sCSV ) ) {
			throw new \MWException(
				__CLASS__ . ":" . __METHOD__ . ' - expects comma separated string'
			);
		}
		$contLang = MediaWikiServices::getInstance()->getContentLanguage();
		$sCSV = trim( $sCSV );
		// make namespaces case insensitive
		$sCSV = mb_strtolower( $sCSV );

		if ( in_array( $sCSV, [ 'all', '-', '' ] ) ) {
			// for compatibility reason the '-' is equivalent to 'all'
			return array_keys( $contLang->getNamespaces() );
		}

		$aAmbiguousNS = explode( ',', $sCSV );
		$aAmbiguousNS = array_map( 'trim', $aAmbiguousNS );
		$aValidNamespaceIntIndexes = [];
		$aInvalidNamespaces = [];

		foreach ( $aAmbiguousNS as $vAmbiguousNS ) {
			if ( is_numeric( $vAmbiguousNS ) ) {
				// Given value is a namespace id.
				if ( $contLang->getNsText( $vAmbiguousNS ) === false ) {
					// Does a namespace with the given id exist?
					$aInvalidNamespaces[] = $vAmbiguousNS;
				} else {
					$aValidNamespaceIntIndexes[] = $vAmbiguousNS;
				}
			} else {
				if ( $vAmbiguousNS == wfMessage( 'bs-ns_main' )->plain()
					|| strcmp( $vAmbiguousNS, "main" ) === 0 ) {
					$iNamespaceIdFromText = 0;
				} elseif ( $vAmbiguousNS == '' ) {
					$iNamespaceIdFromText = 0;
				} else {
					// Given value is a namespace text.
					// 'Bluespice talk' -> 'Bluespice_talk'
					$vAmbiguousNS = str_replace( ' ', '_', $vAmbiguousNS );
					// Does a namespace id for the given namespace text exist?
					$iNamespaceIdFromText = $contLang->getNsIndex( $vAmbiguousNS );
				}
				if ( $iNamespaceIdFromText === false ) {
					$aInvalidNamespaces[] = $vAmbiguousNS;
				} else {
					$aValidNamespaceIntIndexes[] = $iNamespaceIdFromText;
				}
			}
		}

		// Does the given CSV list contain any invalid namespaces?
		if ( !empty( $aInvalidNamespaces ) ) {
			$oInvalidNamespaceException = new BsInvalidNamespaceException();
			$oInvalidNamespaceException->setListOfInvalidNamespaces( $aInvalidNamespaces );
			$oInvalidNamespaceException->setListOfValidNamespaces( $aValidNamespaceIntIndexes );
			throw $oInvalidNamespaceException;
		}

		// minify the Array, rearrange indexes and return it
		return array_values( array_unique( $aValidNamespaceIntIndexes ) );
		*/
		$this->status = Status::newFatal( 'Not implemented' );
	}
}

