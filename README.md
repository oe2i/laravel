# Your Laravel Livewire Volt Tailwind CSS Starter Kit

This is a custom Laravel starter kit designed to quickly set up a new Laravel project with Livewire, Volt, and Tailwind CSS pre-installed and configured.

## Installation

To use this starter kit, you'll first need to create a new Composer package repository (e.g., a private Git repository or a local path repository for development).

### 1. Create the Package

**a. Directory Structure:**
Create a new directory for your starter kit (e.g., `my-laravel-kit`). Inside it, create the following structure:

```
my-laravel-kit/
├── composer.json
├── src/
│   ├── Console/
│   │   └── InstallCommand.php
│   └── StarterKitServiceProvider.php
└── bin/
    └── laravel
└── README.md
```

**b. Populate Files:**
Copy the content provided in the code editor for `composer.json`, `src/StarterKitServiceProvider.php`, `src/Console/InstallCommand.php`, `bin/laravel`, and `README.md` into their respective files.

**c. Update Placeholders:**
**IMPORTANT:** In `composer.json`, `src/StarterKitServiceProvider.php`, and `bin/laravel`, replace `your-vendor` and `your-oe2i-name` with your desired Composer vendor name and package name (e.g., `acme/livewire-volt-kit`).

### 2. Make `bin/laravel` Executable

```bash
chmod +x my-laravel-kit/bin/laravel
```

### 3. Using the Starter Kit (Development/Local)

During development, you can use a local path repository in your Composer configuration.

**a. Add a Path Repository:**
In your global `composer.json` or a project's `composer.json` where you want to test the kit, add a `repositories` section:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./path/to/my-laravel-kit" // Adjust this path to your kit's directory
        }
    ],
    "require": {
        "oe2i/laravel": "@dev" // Use the name you defined in your kit's composer.json
    }
}
```

**b. Create a New Project:**
Now you can create a new Laravel project using your starter kit.

```bash
composer create-project oe2i/laravel my-new-app
```

This command will:
1.  Create a new directory `my-new-app`.
2.  Install your starter kit package into it.
3.  Because your package type is `laravel-oe2i`, Composer will automatically run the `post-create-project-cmd` scripts, which includes the `php artisan oe2i:install` command.

### 4. Running the Installation Command Manually (if needed)

If for any reason the automatic installation doesn't run, or you need to re-run it, navigate into your new project directory and execute:

```bash
cd my-new-app
php artisan oe2i:install
```

This command will perform the following actions:
* Install `livewire/livewire`
* Publish Livewire's configuration file
* Install `livewire/volt`
* Install Volt's scaffolding
* Install Node.js dependencies
* Install Tailwind CSS, PostCSS, and Autoprefixer
* Initialize Tailwind CSS configuration
* Configure `tailwind.config.js` to purge Laravel Blade, Livewire, and Volt files
* Add Tailwind directives to `resources/css/app.css`
* Compile assets using `npm run build`

## Publishing to Packagist (for public use)

If you want to make your starter kit publicly available, you'll need to publish it to [Packagist](https://packagist.org/). This typically involves pushing your code to a public Git repository (e.g., GitHub) and then submitting it to Packagist.

## Customization

You can extend `src/Console/InstallCommand.php` to add more steps to your installation process, such as:
* Installing other Composer packages.
* Running database migrations.
* Copying custom stubs or assets.
* Running additional NPM commands.

Remember to adjust the `your-vendor` and `your-oe2i-name` placeholders to reflect your actual package details.