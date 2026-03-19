<?php

declare(strict_types=1);

namespace App\Controller\Dev;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Yaml\Yaml;

#[Route('/dev/crud-entity-translations')]
class CrudEntityTranslationsController extends AbstractController
{
    /**
     *     @see \App\Form\DepartmentType.php
     */
    #[Route('/create', name: 'dev_entity_translations_create')]
    public function create(EntityManagerInterface $em, KernelInterface $kernel): Response
    {
        if ('dev' !== $kernel->getEnvironment()) {
            throw $this->createNotFoundException();
        }

        $conn = $em->getConnection();
        $schemaManager = $conn->createSchemaManager();

        $tables = $schemaManager->listTableNames();

        $ignore = [
            'doctrine_migration_versions',
            'messenger_messages',
            'messenger_transports',
            'messenger_stats',
            'messenger_restart_positions',
            'migration_versions',
            'sessions',
        ];
        $tables = array_filter($tables, fn ($t) => !in_array($t, $ignore));
        sort($tables);

        $translationDir = $this->getParameter('kernel.project_dir').'/translations';
        $files = glob($translationDir.'/*.yaml');
        $locales = array_map(fn ($f) => explode('.', basename($f))[1], $files);

        $translations = [];
        $test = [];
        foreach ($tables as $table) {
            $columns = $schemaManager->listTableColumns($table);
            $columnNames = array_keys($columns);

            foreach ($locales as $locale) {
                $translations[$locale] ??= [];

                $file = $this->getParameter('kernel.project_dir')."/translations/messages.$locale.yaml";
                $data = file_exists($file) ? Yaml::parseFile($file) : [];

                foreach ($columnNames as $col) {
                    $translations[$locale]['entity']['default'][$col] = ($data['entity']['default'][$col] ?? "~$col");
                }
                // Merge also manually added fields
                foreach ($data['entity']['default'] as $k => $v) {
                    if (!isset($translations[$locale]['entity']['default'][$k])) {
                        $translations[$locale]['entity']['default'][$k] = $v;
                    }
                }
            }
        }

        foreach ($locales as $locale) {
            ksort($translations[$locale]['entity']['default']);
        }

        $yamlOutput = Yaml::dump($translations, 4, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK | Yaml::DUMP_FORCE_DOUBLE_QUOTES_ON_VALUES);

        $yamlOutput = preg_replace('/^(\s*)"([^"]+)":/m', '$1$2:', $yamlOutput);

        return new Response($yamlOutput, 200, [
            'Content-Type' => 'text/yaml',
        ]);
    }
}
