<?php

namespace Encore\TMEditor;

use Encore\Admin\Form\Field\Textarea;
use Illuminate\Support\Str;

class Editor extends Textarea
{
    protected $view = 'laravel-admin-tmeditor::editor';

    protected static $js = [
        'vendor/asm-laravel-admin-ext/tmeditor/tinymce.min.js',
    ];

    public function render()
    {
        $this->id .= Str::random(32);
        $this->id = preg_replace('/[-.?!)(,:]/', '',$this->id);
        $name = $this->formatName($this->column);
        $config = (array) TMEditor::config('config');
        foreach($config as $key=>$value){
          if(is_array($value)){
            $config[$key] = ($config[$key]);
          }
        }
        $config = json_encode(array_merge([
             'selector' => '#'.$this->id,
         ], $config));


$this->script = <<<EOT
tinymce.remove('#$this->id');
tinymce.init($config);
EOT;

        return parent::render();
    }
}
