<?php
namespace AC\Mutate\Presets;

//corresponding file name for this class should be "MyNewPreset.php"
use \AC\Mutate\Preset;
use \AC\Mutate\FileHandlerDefinition;

class HandbrakeAppleTV2 extends Preset {
    protected $key = 'preset_key';
    protected $name = "Human-readable name of preset";
    protected $description = "Provide a human-readable description here.";
    protected $requiredAdapter = 'required_adapter_key';

    public function configure() {
        $this->setOptions(array(
            //specify any key/val arguments to pass to the adapter
        "input_type" => "DVD",
		"encoder" => "x264",
		"video_quality" => "20.0",
		"video_rate" => "29.97",
		"audio_track" => "1,1",
		"aencoder" => "faac,copy:ac3",
		"pfr" => "true",
		"audio_bitrate" => "160,160",
		"mixdown" => "dpl2,auto",
		"audio_rate" => "Auto,Auto",
		"format" => "mp4",
		"maxWidth" => "1280",
		"large_file" => "true",
		"loose_anamorphic" => "true",
		"markers" => "true",
		));
    }

    protected function buildInputDefinition() {
        $def = new FileHandlerDefinition;

        //if you want to specify restrictions on the types of input files this preset can handle, you can set those restrictions here

        return $def;
    }

    protected function buildOutputDefinition() {
        $def = new FileHandlerDefinition;

        //if you want to specify restrictions on the types of output files this preset will allow, you can set those restrictions here

        return $def;
    }
}