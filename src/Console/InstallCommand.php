<?php

namespace Oe2i\Laravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oe2i:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Laravel Livewire Volt and Tailwind CSS starter kit.';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $this->info('Installing Laravel Livewire Volt and Tailwind CSS starter kit...');

        // 1. Install Laravel (This command assumes Laravel is already installed via create-project)
        //    The 'composer create-project' command handles the initial Laravel installation.
        //    This script focuses on post-Laravel installation steps.

        // 2. Install Livewire
        $this->comment('Installing Livewire...');
        $this->runCommand('composer require livewire/livewire');

        // 3. Publish Livewire config
        $this->comment('Publishing Livewire configuration...');
        $this->runCommand('php artisan livewire:publish --config');

        // 4. Require Volt
        $this->comment('Requiring Volt...');
        $this->runCommand('composer require livewire/volt');

        // 5. Install Volt
        $this->comment('Installing Volt...');
        $this->runCommand('php artisan volt:install');

        // 6. Install Node dependencies
        $this->comment('Installing Node dependencies...');
        $this->runCommand('npm install');

        // 7. Install Tailwind CSS
        $this->comment('Installing Tailwind CSS...');
        $this->runCommand('npm install -D tailwindcss postcss autoprefixer');
        $this->runCommand('npx tailwindcss init -p');

        // 8. Configure Tailwind CSS
        $this->comment('Configuring Tailwind CSS...');
        $tailwindConfigPath = base_path('tailwind.config.js');
        $tailwindConfig = file_get_contents($tailwindConfigPath);
        $tailwindConfig = str_replace(
            "content: [],",
            "content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './app/View/**/*.php',
        './app/Http/Livewire/**/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './vendor/livewire/livewire/src/Features/SupportFileUploads/TemporaryUploadedFile.php',
        './vendor/livewire/volt/**/*.php'
    ],",
            $tailwindConfig
        );
        file_put_contents($tailwindConfigPath, $tailwindConfig);

        // 9. Add Tailwind directives to app.css
        $this->comment('Adding Tailwind directives to resources/css/app.css...');
        $appCssPath = resource_path('css/app.css');
        if (!file_exists($appCssPath)) {
            (new Filesystem)->ensureDirectoryExists(dirname($appCssPath));
            file_put_contents($appCssPath, '');
        }
        $appCssContent = file_get_contents($appCssPath);
        if (strpos($appCssContent, '@tailwind base;') === false) {
            $appCssContent = "@tailwind base;
@tailwind components;
@tailwind utilities;

" . $appCssContent;
            file_put_contents($appCssPath, $appCssContent);
        }

        // 10. Compile assets
        $this->comment('Compiling assets...');
        $this->runCommand('npm run build');

        $this->info('Laravel Livewire Volt and Tailwind CSS starter kit installed successfully!');

        return Command::SUCCESS;
    }

    /**
     * Run a shell command.
     *
     * @param string $command
     * @param string|null $cwd
     * @return void
     */
    protected function runCommand(string $command, ?string $cwd = null)
    {
        $process = Process::fromShellCommandline($command, $cwd);
        $process->setTimeout(null); // No timeout
        $process->run(function ($type, $buffer) {
            echo $buffer; // Output command progress
        });

        if (!$process->isSuccessful()) {
            $this->error('The command "' . $command . '" failed.');
            $this->error($process->getErrorOutput());
            exit(1);
        }
    }
}