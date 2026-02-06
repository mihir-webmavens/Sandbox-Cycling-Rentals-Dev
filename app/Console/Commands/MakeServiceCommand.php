<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:service {name} {--repository=}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new Service class linked to a Repository';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = trim($this->argument('name'), '/'); // e.g. "Admin/User"
        $baseName = class_basename($name);
        $repository = trim($this->option('repository'), '/'); // e.g. "Admin/User"

        if (! $repository) {
            $this->error('❌ Please provide a repository name using --repository option.');

            return Command::FAILURE;
        }

        // Build file paths
        $filePath = app_path("Services/{$name}Service.php");
        $repositoryPath = app_path("Repositories/{$repository}Repository.php");
        $directory = dirname($filePath);

        // Ensure directory exists
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Check if repository exists
        if (! File::exists($repositoryPath)) {
            $this->error("⚠️ Repository '{$repository}Repository' not found at:");
            $this->line($repositoryPath);
            $this->info('💡 Create it using:');
            $this->line("php artisan make:repository {$repository} --model=" . class_basename($repository));

            return Command::FAILURE;
        }

        // Prevent overwriting
        if (File::exists($filePath)) {
            $this->error("⚠️ Service [{$name}Service] already exists!");

            return Command::FAILURE;
        }

        // Extract namespace path (without last segment)
        $namespacePath = $this->generateNamespaceFromPath(dirname(str_replace('\\', '/', $name)));
        $repositoryNamespace = $this->generateNamespaceFromPath($repository);
        $repositoryClass = class_basename($repository);

        // Generate class content
        $stub = $this->generateServiceStub($baseName, $namespacePath, $repositoryNamespace, $repositoryClass);

        // Write file
        File::put($filePath, $stub);

        $this->info("✅ Service created successfully: {$filePath}");
        $this->info("🔗 Linked to repository: App\\Repositories\\{$repositoryNamespace}Repository");

        return Command::SUCCESS;
    }

    /**
     * Generate the content for the Service class.
     */
    private function generateServiceStub(string $baseServiceClassName, string $namespacePath, string $repositoryNamespace, string $repositoryClass): string
    {
        $namespaceLine = $namespacePath ? "App\Services\\{$namespacePath}" : "App\Services";

        return <<<PHP
        <?php

        namespace {$namespaceLine};

        use App\Repositories\\{$repositoryNamespace}Repository;

        class {$baseServiceClassName}Service
        {
            protected {$repositoryClass}Repository \$repository;

            public function __construct({$repositoryClass}Repository \$repository)
            {
                \$this->repository = \$repository;
            }

            public function all()
            {
                return \$this->repository->all();
            }

            public function find(\$id)
            {
                return \$this->repository->find(\$id);
            }

            public function create(array \$data)
            {
                return \$this->repository->create(\$data);
            }

            public function update(\$id, array \$data)
            {
                return \$this->repository->update(\$id, \$data);
            }

            public function delete(\$id)
            {
                return \$this->repository->delete(\$id);
            }
        }
        PHP;
    }

    /**
     * Convert slashes to namespace-friendly backslashes.
     */
    private function generateNamespaceFromPath(string $path): string
    {
        $normalized = str_replace('/', '\\', trim($path, '/'));

        return $normalized === '.' ? '' : $normalized;
    }
}
