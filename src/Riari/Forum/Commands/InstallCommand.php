<?php namespace Riari\Forum\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command {

    protected $name        = 'forum:install';
    protected $description = 'Create default forum controllers.';

    public function fire()
    {
        $this->info('Fetching controller names from integration config...');
        $controller = class_basename(\Config::get('forum::integration.controller'));

        $this->info('Config specifies controllers: "'.$controller.'"');
        if (!$this->confirm('Proceed with controller creation (no override)? [Yes|no]'))
        {
            $this->info('Action aborted. No changes done.');
            return;
        }

        $this->installController($controller, '\Riari\Forum\Controllers\BaseController');

        $this->info('Forum installation done.');
    }

    private function installController($name, $parent)
    {
        $file = $this->laravel->path.'/controllers/'.$name.'.php';
        if(file_exists($file))
        {
            $this->info('File app/controllers/'.$name.' Exists. Action aborted.');
            return;
        }

        file_put_contents($file, $this->getControllerContent($name, $parent));
        $this->info('File app/controllers/'.$name.' Created');
    }

    public function getControllerContent($name, $parent)
    {
        $content = "<?php\n"
	        ."/* Autogenerated Forum Controller */\n"
	        ."/* Hook point of the Forum package inside your laravel application */\n"
	        ."/* Feel free to override methods here to fit your requirements */\n"
	        ."class %s extends %s {\n\n"
	        ."}\n";

        return sprintf($content, $name, $parent);
    }

}
