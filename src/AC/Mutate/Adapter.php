<?php

namespace AC\Mutate;

abstract class Adapter {
	
	/**
	 * Machine key for this adapter.  Should be lower cased with underscores.
	 *
	 * @var string
	 */
	protected $key = false;
	
	/**
	 * Human readable name of adapter.
	 *
	 * @var string
	 */
	protected $name = false;
	
	/**
	 * Human-readable description of adapter
	 *
	 * @var string
	 */
	protected $description = false;
	
	/**
	 * Instance of FileDefinitionHandler used to restrict input formats.
	 *
	 * @var \AC\Mutate\FileDefinitionHandler
	 */
	protected $inputDefinition = false;
		
	/**
	 * Instance of FileDefinitionHandler used to define allowed output formats.
	 *
	 * @var \AC\Mutate\FileDefinitionHandler
	 */
	protected $outputDefinition = false;

	/**
	 * Boolean whether or not the Adapter has been verified - determined automatically in Adapter::verify()
	 *
	 * @var boolean
	 */
	private $verified = null;
	
	/**
	 * Error string from exception caught during Adapter::verify()
	 *
	 * @var string
	 */
	private $verificationError = false;

	/**
	 * Return a custom FileHandlerDefinition for input restriction.
	 *
	 * @return AC\Mutate\FileHandlerDefinition
	 */
	protected function buildInputDefinition() {
		return new FileHandlerDefinition;
	}

	/**
	 * Return a custom FileHandlerDefinition for output restriction.
	 *
	 * @return AC\Mutate\FileHandlerDefinition
	 */
	protected function buildOutputDefinition() {
		return new FileHandlerDefinition;
	}

	/**
	 * Get the input FileHandlerDefinition
	 *
	 * @return AC\Mutate\FileHandlerDefinition
	 */
	public function getInputDefinition() {
		if(!$this->inputDefinition) {
			$this->inputDefinition = $this->buildInputDefinition();
		}
		
		return $this->inputDefinition;
	}
	
	/**
	 * Get the output FileHandlerDefinition
	 *
	 * @return AC\Mutate\FileHandlerDefinition
	 */
	public function getOutputDefinition() {
		if(!$this->outputDefinition) {
			$this->outputDefinition = $this->buildOutputDefinition();
		}
		
		return $this->outputDefinition;
	}

	/**
	 * Transcodes a file, given a preset and an output path.
	 *
	 * @param File $file 			- instance of AC\Mutate\File
	 * @param Preset $preset 		- instance of AC\Mutate\Preset
	 * @param string $outFilePath 	- string output file path (must be valid)
	 * @return AC\Mutate\File on success, exception thrown otherwise
	 */
	public function transcodeFile(File $file, Preset $preset, $outFilePath) {
		throw new \RuntimeException("Adapter::transcodeFile must be implemented by an extending class.");
	}
	
	/**
	 * Gets called by the Transcoder when a transcode process fails.
	 *
	 * @param string $outFilePath 
	 */
	public function cleanFailedTranscode($outFilePath) {
		return;
	}
	
	/**
	 * Implement custom Preset validation logic here - this is called by the Transcoder before any transcode process runs.
	 *
	 * @param Preset $preset 
	 * @return boolean true on success, throw exception otherwise.
	 */
	public function validatePreset(Preset $preset) {
		return true;
	}
	
	/**
	 * Uses input FileHandlerDefinition to validate input file.
	 *
	 * @param File $file 
	 * @return true on success, throws exception otherwise.
	 */
	public function validateInputFile(File $file) {
		$this->getInputDefinition()->validateFile($file);
		return true;
	}
	
	/**
	 * Uses output FileHandlerDefinition to validate output file.
	 *
	 * @param File $file 
	 * @return true on success, throws exception otherwise.
	 */
	public function validateOutputFile(File $file) {
		$this->getOutputDefinition()->validateFile($file);

		return true;
	}
	
	/**
	 * Returns true/false if given file is acceptible input
	 *
	 * @param File $file 
	 * @return true on success, false otherwise
	 */
	public function acceptsInputFile(File $file) {
		return $this->getInputDefinition()->acceptsFile($file);
	}

	/**
	 * Returns true/false if given file is acceptible output
	 *
	 * @param File $file 
	 * @return true on success, false otherwise
	 */
	public function acceptsOutputFile(File $file) {
		return $this->getOutputDefinition()->acceptsFile($file);
	}

	/**
	 * Called by the Transcoder to make the Adapter verify it's current status in the environment.
	 *
	 * @return true on success, false otherwise
	 */
	public function verify() {
		if(is_null($this->verified)) {
			try {
				$this->verified = (bool) $this->verifyEnvironment();
				if(!$this->verified) {
					throw new Exception\EnvironmentException("The adapter could not properly validate its environment.");
				}
			} catch (\Exception $e) {
				$this->verificationError = $e->getMessage();
				$this->verified = false;
			}
		}
		
		return $this->verified;
	}
	
	/**
	 * Get string verification error message from any exception caught during the verification process.
	 *
	 * @return false if verified, otherwise string error message
	 */
	public function getVerificationError() {
		return $this->verificationError;
	}
	
	/**
	 * For extending classes to implement custom environment validation logic.  Should throw exceptions on failure, or return true on success.
	 *
	 * @return boolean
	 */
	protected function verifyEnvironment() {
		return true;
	}
	
	
	/**
	 * Return the key for this adapter
	 *
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}
	
	/**
	 * Return string name of this adapter, the key will be returned if a name is not defined.
	 *
	 * @return string
	 */
	public function getName() {
		if(!$this->name) {
			return $this->key;
		}
		
		return $this->name;
	}
	
	/**
	 * Return human readable description of what this adapter is generally for.
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
}
