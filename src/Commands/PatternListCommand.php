<?php

namespace Imagewize\ElaynePatternCli\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PatternListCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('pattern:list')
            ->setDescription('List available pattern templates, snippets, and categories');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Elayne Pattern CLI');

        $io->section('Templates  (use with: vendor/bin/elayne pattern:create --template=<name>)');
        $io->table(
            ['Name', 'Description'],
            [
                ['blank',                       'Empty pattern with header only'],
                ['hero-cover',                  'Full-bleed wp:cover with bottom-center content'],
                ['cta-fullwidth',               'Full-width call-to-action band'],
                ['feature-grid-3col',           'Full-width section with 3 feature cards'],
                ['stats-bar-fullwidth',         'Dark full-width stats/numbers bar'],
                ['two-column-text-image',       'Text left, image right two-column layout'],
                ['header-standard',             'Standard header — logo, navigation, social links'],
                ['footer-standard',             'Standard footer — brand blurb, nav columns, subnav'],
                ['testimonials-grid',           'Responsive testimonial card grid with reviewer info'],
                ['pricing-comparison',          'Three-tier pricing table with elevated recommended card'],
                ['blog-post-columns',           'wp:query-driven 3-column post grid (portrait images)'],
                ['team-grid',                   'Team member profile grid — photo, name, title, bio'],
                // WooCommerce store templates
                ['woo-hero-split',              'WooCommerce — two-column hero: text + CTA left, decorative cover right'],
                ['woo-ticker-band',             'WooCommerce — server-rendered marquee ticker bar (needs render_block filter)'],
                ['woo-categories-bento',        'WooCommerce — CSS bento grid: one large featured card + four smaller cards'],
                ['woo-product-grid',            'WooCommerce — section header with View All + product-collection 4-col grid'],
                ['woo-text-image-watermark',    'WooCommerce — two-column brand story: monogram watermark left, text + stats right'],
                ['woo-testimonials-grid',       'WooCommerce — three-column testimonial cards with star ratings and avatar circles'],
                ['woo-newsletter-band',         'WooCommerce — full-bleed newsletter signup with decorative eyebrow'],
                ['woo-landing-shell',           'WooCommerce — store homepage shell that composes sub-patterns in sequence'],
                ['woo-cart-page',               'WooCommerce — full-width cart page wrapper (Inserter: false)'],
                ['woo-checkout-page',           'WooCommerce — full-width checkout page wrapper (Inserter: false)'],
            ]
        );

        $io->section('Snippets  (copy from vendor/imagewize/elayne-cli/snippets/)');
        $io->table(
            ['File', 'Description'],
            [
                ['eyebrow-heading-body.txt',          'Eyebrow label + heading + body paragraph'],
                ['3col-grid-wrapper.txt',             'Responsive 3-column grid wrapper'],
                ['stat-item.txt',                     'Number + label stat card (dark background)'],
                ['testimonial-card.txt',              'Testimonial with stars, quote, author'],
                ['two-button-group.txt',              'Primary + outline button pair'],
                ['overlay-grid-cover-card.txt',       'Portrait cover image card + floating badge (use wp:cover, NOT wp:image)'],
            ]
        );

        $io->section('Style Variations  (use with: vendor/bin/elayne style:create)');
        $io->writeln('  Scaffold a <info>styles/*.json</info> theme variation with a pre-wired color palette.');
        $io->table(
            ['Vertical', 'Description'],
            [
                ['custom',        'Enter your own hex color values'],
                ['legal',         'Navy blue + gold'],
                ['plumbing',      'Dark blue + orange'],
                ['spa',           'Sage green + sand'],
                ['food-beverage', 'Burgundy + gold'],
            ]
        );

        $io->section('Pattern Categories');
        $categories = [
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
            'elayne/card-simple   (minimumColumnWidth: 18rem)',
            'elayne/card-extended (minimumColumnWidth: 19rem)',
            'elayne/card-profiles (minimumColumnWidth: 20rem)',
            'elayne/woocommerce',
        ];

        foreach ($categories as $cat) {
            $io->writeln("  <info>{$cat}</info>");
        }

        $io->newLine();

        return Command::SUCCESS;
    }
}
