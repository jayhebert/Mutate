<?php
namespace AC\Mutate\Presets;
//corresponding file name for this class should be "MyNewPreset.php"
use \AC\Mutate\Preset;
use \AC\Mutate\FileHandlerDefinition;

class HandbrakeAppleTV extends Preset {
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
		"audio_track" => "1",
		"aencoder" => "faac",
		"pfr" => "true",
		"audio_bitrate" => "160",
		"mixdown" => "dpl2",
		"audio_rate" => "Auto,Auto",
		"format" => "mp4",
		"maxWidth" => "960",
		"large_file" => "true",
		"loose_anamorphic" => "true",
		"markers" => "true",
		"encopts" => "cabac=0:ref=2:me=umh:b-pyramid=none:b-adapt=2:weightb=0:trellis=0:weightp=0:vbv-maxrate=9500:vbv-bufsize=950"
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
