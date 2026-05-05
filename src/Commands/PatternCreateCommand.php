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
        'elayne/woocommerce',
    ];

    private const TEMPLATES = [
        'blank'                       => 'Empty pattern with header only',
        'hero-cover'                  => 'Full-bleed wp:cover with bottom-center content',
        'cta-fullwidth'               => 'Full-width call-to-action band',
        'feature-grid-3col'           => 'Full-width section with 3 feature cards',
        'stats-bar-fullwidth'         => 'Dark full-width stats/numbers bar',
        'two-column-text-image'       => 'Text left, image right two-column layout',
        'header-standard'             => 'Standard header — logo, navigation, social links',
        'footer-standard'             => 'Standard footer — brand blurb, nav columns, subnav',
        'testimonials-grid'           => 'Responsive testimonial card grid with reviewer info',
        'pricing-comparison'          => 'Three-tier pricing table with elevated recommended card',
        'blog-post-columns'           => 'wp:query-driven 3-column post grid (portrait images)',
        'team-grid'                   => 'Team member profile grid — photo, name, title, bio',
        // WooCommerce store templates
        'woo-hero'                    => 'WooCommerce — two-column hero: text + CTA left, decorative cover right',
        'woo-ticker'                  => 'WooCommerce — server-rendered marquee ticker bar (needs render_block filter)',
        'woo-shop-categories'         => 'WooCommerce — CSS bento grid: one large featured card + four smaller cards',
        'woo-featured-products'       => 'WooCommerce — section header with View All + product-collection 4-col grid',
        'woo-our-story'               => 'WooCommerce — two-column brand story: monogram watermark left, text + stats right',
        'woo-testimonials'            => 'WooCommerce — three-column testimonial cards with star ratings and avatar circles',
        'woo-newsletter'              => 'WooCommerce — full-bleed newsletter signup with decorative eyebrow',
        'woo-shop-landing'            => 'WooCommerce — store homepage shell that composes sub-patterns in sequence',
        'woo-cart'                    => 'WooCommerce — full-width cart page wrapper (Inserter: false)',
        'woo-checkout'                => 'WooCommerce — full-width checkout page wrapper (Inserter: false)',
        'woo-filters-sidebar'         => 'WooCommerce — sticky sidebar: price slider + colour-chip attribute + two checkbox-list attributes',
        'woo-product-grid'            => 'WooCommerce — filter-aware product-collection grid with sort toolbar + pagination',
    ];

    protected function configure(): void
    {
        $this
            ->setName('pattern:create')
            ->setDescription('Scaffold a new Elayne block pattern')
            ->addArgument('slug', InputArgument::OPTIONAL, 'Pattern slug (without elayne/ prefix)')
            ->addOption('title', null, InputOption::VALUE_REQUIRED, 'Pattern title')
            ->addOption('slug', null, InputOption::VALUE_REQUIRED, 'Pattern slug (with or without elayne/ prefix)')
            ->addOption('template', 't', InputOption::VALUE_REQUIRED, 'Starter template (' . implode(', ', array_keys(self::TEMPLATES)) . ')')
            ->addOption('category', 'c', InputOption::VALUE_REQUIRED, 'Pattern category')
            ->addOption('keywords', 'k', InputOption::VALUE_REQUIRED, 'Comma-separated keywords')
            ->addOption('output-dir', 'o', InputOption::VALUE_REQUIRED, 'Output directory (default: ./patterns/ or ./)')
            ->addOption('with-style', null, InputOption::VALUE_NONE, 'Also create a CSS file in the style directory')
            ->addOption('style-dir', null, InputOption::VALUE_REQUIRED, 'CSS output directory (default: assets/styles/block-styles/)');
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

        // Slug — --slug option takes priority over positional argument
        $slug = $input->getOption('slug') ?? $input->getArgument('slug');
        if (!$slug) {
            $defaultSlug = $this->titleToSlug($title);
            $question = new Question("<info>Pattern slug</info> [<comment>{$defaultSlug}</comment>]: ", $defaultSlug);
            $slug = $helper->ask($input, $output, $question);
        }
        $slug = (string) $slug;
        if (str_starts_with($slug, 'elayne/')) {
            $slug = substr($slug, 7);
        }
        $slug = $this->titleToSlug($slug);

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

        // Create CSS file if --with-style flag is set
        $withStyle = $input->getOption('with-style');
        if ($withStyle) {
            $styleDir = $input->getOption('style-dir');
            if (!$styleDir) {
                $cwd = (string) getcwd();
                $styleDir = is_dir($cwd . '/assets/styles/block-styles') 
                    ? $cwd . '/assets/styles/block-styles' 
                    : $cwd . '/assets/styles/block-styles';
            }

            if (!is_dir($styleDir) && !mkdir($styleDir, 0755, true) && !is_dir($styleDir)) {
                $io->warning("Could not create style directory: {$styleDir}");
            } else {
                $cssFilename = rtrim($styleDir, '/') . '/elayne-' . $slug . '.css';
                $cssContent = $this->buildStyleCss($slug, $title);
                file_put_contents($cssFilename, $cssContent);
                $io->writeln(" <info>Style file created: {$cssFilename}</info>");
            }
        }

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

    private function buildStyleCss(string $slug, string $title): string
    {
        $blockClass = '.wp-block-woocommerce-product-filters.is-style-elayne-' . $slug;

        return <<<CSS
/* ── Elayne {$title} ── */

/* Sticky sidebar positioning */
.elayne-{$slug} {
	position: sticky;
	top: 2rem;
	align-self: flex-start;
}

/* ── Product Filters Container ── */
{$blockClass} {
	--wc-product-filter-price-slider: var(--wp--preset--color--primary);
	--wc-product-filter-price-slider-handle: var(--wp--preset--color--primary);
	--wc-product-filter-price-slider-handle-border: var(--wp--preset--color--primary);
	--wc-product-filter-checkbox-list-option-element-border: currentColor;
	--wc-product-filter-checkbox-list-option-element-selected: var(--wp--preset--color--primary);
}

/* Filter group sections — divider + spacing */
{$blockClass} .wc-block-product-filters__overlay-content {
	display: flex;
	flex-direction: column;
	gap: 0;
	padding: 0;
	overflow: visible;
}

{$blockClass} .wp-block-woocommerce-product-filter-price,
{$blockClass} .wp-block-woocommerce-product-filter-attribute {
	padding-bottom: 1.5rem;
	margin-bottom: 1.5rem;
	border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

{$blockClass} .wp-block-woocommerce-product-filter-attribute:last-child {
	padding-bottom: 0;
	margin-bottom: 0;
	border-bottom: none;
}

/* ── Filter group headings ── */
{$blockClass} .wp-block-heading,
{$blockClass} legend {
	font-size: 0.68rem;
	font-weight: 600;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: var(--wp--preset--color--main);
	margin-bottom: 1rem;
}

/* ── Price slider labels ── */
{$blockClass} .wc-block-product-filter-price-slider .text input[type="text"] {
	font-size: 0.75rem;
	border: 1px solid rgba(0, 0, 0, 0.12);
	border-radius: 0;
	padding: 0.4rem 0.6rem;
	max-width: 64px;
	color: var(--wp--preset--color--main);
}

/* ── Checkbox list ── */
{$blockClass} .wc-block-product-filter-checkbox-list__item {
	margin-bottom: 0.6rem;
}

{$blockClass} .wc-block-product-filter-checkbox-list__text-wrapper {
	font-size: 0.82rem;
	color: var(--wp--preset--color--main-accent);
}

{$blockClass} .wc-block-product-filter-checkbox-list__count {
	font-size: 0.72rem;
	color: var(--wp--preset--color--main-accent);
	opacity: 0.65;
}

/* ── Colour swatches (chips display) ── */
{$blockClass} .wc-block-product-filter-chips {
	display: flex;
	flex-wrap: wrap;
	gap: 0.5rem;
}

{$blockClass} .wc-block-product-filter-chips__item {
	width: 28px;
	height: 28px;
	min-width: 28px;
	border-radius: 0;
	border: 2px solid transparent;
	font-size: 0;
	overflow: hidden;
	transition: border-color 0.2s;
}

{$blockClass} .wc-block-product-filter-chips__item:is([aria-pressed="true"], .is-active) {
	border-color: var(--wp--preset--color--primary);
}

{$blockClass} .wc-block-product-filter-chips__item button {
	width: 100%;
	height: 100%;
	padding: 0;
	font-size: 0;
	border: none;
	cursor: pointer;
}

/* ── Mobile: overlay button hidden on narrow sidebar ── */
@media (min-width: 601px) {
	{$blockClass} .wc-block-product-filters__open-overlay {
		display: none;
	}
}

CSS;
    }
}
