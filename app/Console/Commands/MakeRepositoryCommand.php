<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Example:
     * php artisan make:repository Admin/User --model=User
     */
    protected $signature = 'make:repository {name} {--model=}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new Repository class with basic CRUD methods';

    /**
     * Handle command execution.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name')); // Normalize case
        $this->name = $name;

        $baseName = class_basename($name);
        $model = $this->option('model');

        if (! $model) {
            $this->error('❌ Please provide a model name using --model option.');

            return Command::FAILURE;
        }

        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        $repositoryDir = dirname($repositoryPath);

        // Ensure directory exists
        File::ensureDirectoryExists($repositoryDir, 0755, true);

        // Prevent overwriting existing file
        if (File::exists($repositoryPath)) {
            $this->error("⚠️ Repository [{$name}Repository] already exists!");

            return Command::FAILURE;
        }

        $modelName = $this->guessModelName($model);

        // Verify model existence
        $modelPath = app_path("Models/{$modelName}.php");
        if (! File::exists($modelPath)) {
            $this->error("❌ Model [App\\Models\\{$modelName}] does not exist!");

            return Command::FAILURE;
        }

        // Build file content
        $stub = $this->generateCrudStub($baseName, $modelName);

        // Write repository file
        File::put($repositoryPath, $stub);

        $this->info('✅ Repository created successfully:');
        $this->line("📁 Path: {$repositoryPath}");
        $this->line("🔗 Linked Model: App\\Models\\{$modelName}");

        return Command::SUCCESS;
    }

    /**
     * Generate CRUD Repository stub.
     */
    private function generateCrudStub(string $className, string $model): string
    {
        $namespace = $this->generateNamespace();

        return <<<PHP
        <?php

        namespace App\Repositories{$namespace};

        use App\Models\\{$model};

        class {$className}Repository
        {
            public function query()
            {
                return {$model}::query();
            }

            public function all()
            {
                return {$model}::all();
            }

            public function find(\$id)
            {
                return {$model}::findOrFail(\$id);
            }

            public function create(array \$data)
            {
                return {$model}::create(\$data);
            }

            public function update(\$id, array \$data)
            {
                \$record = {$model}::findOrFail(\$id);
                \$record->update(\$data);
                return \$record;
            }

            public function delete(\$id)
            {
                \$record = {$model}::findOrFail(\$id);
                \$record->delete();
                return \$record;
            }
        }

        PHP;
    }

    /**
     * Guess model name from argument.
     */
    private function guessModelName(string $name): string
    {
        return Str::studly(str_replace('Repository', '', $name));
    }

    /**
     * Build the namespace based on nested folder path.
     * Example: "Admin/User" → "\Admin"
     */
    private function generateNamespace(): string
    {
        $normalized = str_replace('\\', '/', $this->name);
        $namespacePath = dirname($normalized);

        if ($namespacePath === '.' || $namespacePath === '') {
            return '';
        }

        return '\\' . str_replace('/', '\\', $namespacePath);
    }
}
