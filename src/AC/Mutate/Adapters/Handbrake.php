<?php
namespace AC\Mutate\Adapters;
use \AC\Mutate\Adapter;
use \AC\Mutate\File;
use \AC\Mutate\Preset;
use \AC\Mutate\FileHandlerDefinition;

class Handbrake extends Adapter {
    protected $key = 'adapter_key';
    protected $name = "Handbrake Adapter";
    protected $description = "Handbrake Adapater for video transcoding.";

    public function transcodeFile(File $inFile, Preset $preset, $outputFilePath) {

        //implement your transcoding logic here, however that needs to be done.  You should not do any extra logic for figuring out
        //a proper output file name, that logic will be taken care of by the transcoder -  always assume you are getting back a properly
        //formed string $outputFilePath to use as the output.
	
	$trans = "HandBrakeCLI";
	
	foreach ($preset->options as $key=>$value) {
		$trans += " -";	// Create Starting String
		$trans += $this->lookup_key($key);	// Option Lookup
		$trans += " " + $value;
	}	

	return new File($outputFilePath);
    }
    
    protected function lookup_key($key) {
	
	$options_key = array(
	    "aencoder" => "E",
	    "audio_bitrate" => "B",
	    "audio_rate" => "R",
	    "audio_track" => "a",
	    "decomb" => "5",
	    "detelecine" => "9",
	    "dynamic_range_compression" => "D",
	    "encoder" => "e",
	    "encopts" => "x",
	    "format" => "f",
	    "input_type" => "i",
	    "large_file" => "4",
	    "loose_anamorphic" => "-loose-anamorphic",
	    "markers" => "m",
	    "maxWidth" => "X",	    
	    "mixdown" => "6",
	    "pfr" => "-pfr",
	    "strict_anamorphic" => "-strict-anamorphic",
	    "video_bitrate" => "b",
	    "video_rate" => "r",
	    "video_quality" => "q",
	    );
	

	$value = $options_key[$key];
	if ($value == null) {
	    $error = 'Paramater key not found in valid options.';
	    throw new Exception($error);
	}

	return $value;
    }

    protected function buildInputDefinition() {
        $def = new FileHandlerDefinition;

        //if you want to specify restrictions on the types of input files this adapter can handle, you can set those restrictions here

        return $def;
    }

    protected function buildOutputDefinition() {
        $def = new FileHandlerDefinition;

        //if you want to specify restrictions on the types of output files this adapter will allow, you can set those restrictions here

        return $def;
    }

    public function validatePreset(Preset $preset) {
        //if you want to specify custom preset validation logic, you can do that here
        //be sure to throw exceptions on failure, otherwise return true on success

        return true;
    }

    public function verifyEnvironment() {
        //if your adapter needs to run any checks to ensure that it can function in the current environment, for
        //instance, to check whether or not another command-line tool is installed on the system, that logic
        //should be implemented here.  Throw exceptions on failure, return `true` on success.

        return true;
    }

    public function cleanFailedTranscode($outputFilePath) {
        //if a transcode fails, the transcoder will call this method automatically
        //implement any custom logic that needs to happen here.

        //note that the transcoder will take care of deleting fails on a failed transcode, if it's mode specifies that it should
        //this method is only intended to be use for logic specific to the adapter, which the Transcoder cannot anticipate
    }
}
