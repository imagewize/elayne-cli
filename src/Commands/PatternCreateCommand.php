<?php

namespace Imagewize\ElaynePatternCli\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class PatternCreateCommand extends Command
{
    private const CATEGORIES = [
        'header',
        'footer',
        'elayne/hero',
        'elayne/features',
        'elayne/call-to-action',
        'elayne/testimonial',
        'elayne/team',
        'elayne/statistics',
        'elayne/contact',
        'elayne/posts',
        'elayne/pricing',
        'elayne/banner',
        'elayne/card-simple',
        'elayne/card-extended',
        'elayne/card-profiles',
    ];

    private const TEMPLATES = [
        'blank'                  => 'Empty pattern with header only',
        'hero-cover'             => 'Full-bleed wp:cover with bottom-center content',
        'cta-fullwidth'          => 'Full-width call-to-action band',
        'feature-grid-3col'      => 'Full-width section with 3 feature cards',
        'stats-bar-fullwidth'    => 'Dark full-width stats/numbers bar',
        'two-column-text-image'  => 'Text left, image right two-column layout',
        'header-standard'        => 'Standard header — logo, navigation, social links',
        'footer-standard'        => 'Standard footer — brand blurb, nav columns, subnav',
        'testimonials-grid'      => 'Responsive testimonial card grid with reviewer info',
        'pricing-comparison'     => 'Three-tier pricing table with elevated recommended card',
        'blog-post-columns'      => 'wp:query-driven 3-column post grid (portrait images)',
        'team-grid'              => 'Team member profile grid — photo, name, title, bio',
    ];

    protected function configure(): void
    {
        $this
            ->setName('pattern:create')
            ->setDescription('Scaffold a new Elayne block pattern')
            ->addArgument('slug', InputArgument::OPTIONAL, 'Pattern slug (without elayne/ prefix)')
            ->addOption('title', null, InputOption::VALUE_REQUIRED, 'Pattern title')
            ->addOption('template', 't', InputOption::VALUE_REQUIRED, 'Starter template (' . implode(', ', array_keys(self::TEMPLATES)) . ')')
            ->addOption('category', 'c', InputOption::VALUE_REQUIRED, 'Pattern category')
            ->addOption('keywords', 'k', InputOption::VALUE_REQUIRED, 'Comma-separated keywords')
            ->addOption('output-dir', 'o', InputOption::VALUE_REQUIRED, 'Output directory (default: ./patterns/ or ./)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        // Title
        $title = $input->getOption('title');
        if (!$title) {
            $question = new Question('<info>Pattern title</info>: ');
            $question->setValidator(static function ($value) {
                if (empty(trim((string) $value))) {
                    throw new \RuntimeException('Title cannot be empty.');
                }
                return $value;
            });
            $title = $helper->ask($input, $output, $question);
        }

        // Slug
        $slug = $input->getArgument('slug');
        if (!$slug) {
            $defaultSlug = $this->titleToSlug($title);
            $question = new Question("<info>Pattern slug</info> [<comment>{$defaultSlug}</comment>]: ", $defaultSlug);
            $slug = $helper->ask($input, $output, $question);
        }
        $slug = $this->titleToSlug((string) $slug);

        // Category
        $category = $input->getOption('category');
        if (!$category) {
            $question = new ChoiceQuestion('<info>Select category</info>:', self::CATEGORIES, 0);
            $category = $helper->ask($input, $output, $question);
        }

        // Template
        $template = $input->getOption('template');
        if (!$template) {
            $templateChoices = array_keys(self::TEMPLATES);
            $descriptions = array_values(self::TEMPLATES);
            $labelled = array_map(
                static fn($k, $v) => "{$k} — {$v}",
                $templateChoices,
                $descriptions
            );
            $question = new ChoiceQuestion('<info>Select template</info>:', $labelled, 0);
            $answer = $helper->ask($input, $output, $question);
            // Extract just the slug before " — "
            $template = explode(' — ', $answer)[0];
        }

        // Keywords
        $keywords = $input->getOption('keywords');
        if ($keywords === null) {
            $question = new Question('<info>Keywords</info> (comma-separated, optional): ', '');
            $keywords = $helper->ask($input, $output, $question);
        }

        // Output directory
        $outputDir = $input->getOption('output-dir');
        if (!$outputDir) {
            $cwd = (string) getcwd();
            $outputDir = is_dir($cwd . '/patterns') ? $cwd . '/patterns' : $cwd;
        }

        if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true) && !is_dir($outputDir)) {
            $io->error("Could not create output directory: {$outputDir}");
            return Command::FAILURE;
        }

        $content = $this->buildPattern($title, $slug, $category, (string) $keywords, (string) $template);

        $filename = rtrim($outputDir, '/') . '/' . $slug . '.php';

        if (file_exists($filename)) {
            $question = new Question("<comment>File already exists:</comment> {$filename}\n<info>Overwrite?</info> [y/N]: ", 'n');
            $confirm = $helper->ask($input, $output, $question);
            if (strtolower(trim((string) $confirm)) !== 'y') {
                $io->warning('Aborted.');
                return Command::SUCCESS;
            }
        }

        file_put_contents($filename, $content);

        $io->success("Pattern created: {$filename}");
        $io->note([
            'Slug: elayne/' . $slug,
            'Category: ' . $category,
            'Next: add content blocks inside the TODO markers, then flush WP cache.',
        ]);

        return Command::SUCCESS;
    }

    private function buildPattern(string $title, string $slug, string $category, string $keywords, string $template): string
    {
        if ($template === 'blank' || !array_key_exists($template, self::TEMPLATES)) {
            return $this->buildBlankTemplate($title, $slug, $category, $keywords);
        }

        $templatePath = __DIR__ . '/../../templates/' . $template . '.php';

        if (!file_exists($templatePath)) {
            return $this->buildBlankTemplate($title, $slug, $category, $keywords);
        }

        $content = (string) file_get_contents($templatePath);
        $content = str_replace('TODO: Pattern Title', $title, $content);
        $content = str_replace('elayne/TODO-slug', 'elayne/' . $slug, $content);
        $content = str_replace('elayne/TODO-category', $category, $content);
        $content = str_replace('TODO: One-line description', $title, $content);
        $content = str_replace('TODO keyword1, keyword2', $keywords ?: $slug, $content);

        return $content;
    }

    private function buildBlankTemplate(string $title, string $slug, string $category, string $keywords): string
    {
        $keywordsLine = $keywords ?: $slug;

        return <<<PHP
<?php
/**
 * Title: {$title}
 * Slug: elayne/{$slug}
 * Description: {$title}
 * Categories: {$category}
 * Keywords: {$keywordsLine}
 * Viewport Width: 1200
 * Block Types: core/group
 */
?>

PHP;
    }

    private function titleToSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = (string) preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = (string) preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
