<?php
namespace AC\Mutate\Presets;

//corresponding file name for this class should be "MyNewPreset.php"
use \AC\Mutate\Preset;
use \AC\Mutate\FileHandlerDefinition;

class HandbrakeWebClassic extends Preset {
    protected $key = 'preset_key';
    protected $name = "Human-readable name of preset";
    protected $description = "Provide a human-readable description here.";
    protected $requiredAdapter = 'required_adapter_key';

    public function configure() {
        $this->setOptions(array(
            //specify any key/val arguments to pass to the adapter
        	"input_type" => "DVD",
		"video_bitrate" => "1000",
		"audio_track" => "1",
		"aencoder" => "faac",
		"audio_bitrate" => "160",
		"mixdown" => "dpl2",
		"audio_rate" => "Auto",
		"dynamic_range_compression" => "0.0",
		"format" => "mp4",
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
