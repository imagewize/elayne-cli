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
                ['blank',                 'Empty pattern with header only'],
                ['hero-cover',            'Full-bleed wp:cover with bottom-center content'],
                ['cta-fullwidth',         'Full-width call-to-action band'],
                ['feature-grid-3col',     'Full-width section with 3 feature cards'],
                ['stats-bar-fullwidth',   'Dark full-width stats/numbers bar'],
                ['two-column-text-image', 'Text left, image right two-column layout'],
            ]
        );

        $io->section('Snippets  (copy from vendor/imagewize/elayne-cli/snippets/)');
        $io->table(
            ['File', 'Description'],
            [
                ['eyebrow-heading-body.txt',  'Eyebrow label + heading + body paragraph'],
                ['3col-grid-wrapper.txt',     'Responsive 3-column grid wrapper'],
                ['stat-item.txt',             'Number + label stat card (dark background)'],
                ['testimonial-card.txt',      'Testimonial with stars, quote, author'],
                ['two-button-group.txt',      'Primary + outline button pair'],
            ]
        );

        $io->section('Pattern Categories');
        $categories = [
            'elayne/hero',
            'elayne/features',
            'elayne/call-to-action',
            'elayne/testimonial',
            'elayne/team',
            'elayne/statistics',
            'elayne/contact',
            'elayne/posts',
            'elayne/card-simple   (minimumColumnWidth: 18rem)',
            'elayne/card-extended (minimumColumnWidth: 19rem)',
            'elayne/card-profiles (minimumColumnWidth: 20rem)',
        ];

        foreach ($categories as $cat) {
            $io->writeln("  <info>{$cat}</info>");
        }

        $io->newLine();

        return Command::SUCCESS;
    }
}
