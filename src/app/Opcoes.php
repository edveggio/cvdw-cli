<?php

namespace Manzano\CvdwCli;

use Manzano\CvdwCli\Services\Ambientes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Manzano\CvdwCli\Services\Console\CvdwSymfonyStyle;

// Classe de exemplo de comando para listar comandos
class Opcoes extends Command
{
    protected static $defaultName = 'opcoes';

    /**
     * @var string[]
     */
    public array $opcoes = [];

    protected function configure()
    {
        $this->setDescription('Lista os comandos disponíveis.')
            ->setHelp('Este comando lista os comandos disponíveis no aplicativo CVDW-CLI.')
            ->addOption(
                'dir',
                'diretorio',
                InputOption::VALUE_NONE, // Modo: VALUE_REQUIRED, VALUE_OPTIONAL, VALUE_NONE
                'Imprime o diretorio onde o CVDW-CLI está instalado.', 
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new CvdwSymfonyStyle($input, $output);

        $ambientesObj = new Ambientes();
        $versaoCVDW = $ambientesObj->retornarVersao();

        // Aqui você pode personalizar a saída do comando de ajuda
        $io->title('Manzano // CVDW CLI '.$versaoCVDW );

        if ($input->getOption('dir')) {
            $dir = __DIR__;
            // Remover /src/app de $dir
            $dir = str_replace('/src/app', '', $dir);
            $io->section('Instalação:');
            $io->text([
                'Diretório: ' . $dir
            ]);
        }

        $io->section('Como usar:');
        $io->text([
            'cvdw [comando] [opcao] [argumento]'
        ]);

        $io->section('Opções:');
        $io->listing([
            '-h, --help                   - Mostra uma ajuda para o comando selecionado.',
            '-q, --quiet                  - Não mostra nenhum mensagem no output.',
            '-V, --version                - Exibe a versão da aplicação.',
            '--ansi|--no-ansi             - Força (ou desabilita --no-ansi) ANSI output.',
            '-n, --no-interaction         - Não faz nenhuma pergunta na execução do comando.'
        ]);

        $io->section('Comandos disponíveis:');
        $io->listing([
            'cvdw configurar              - Configurações do aplicativo',
            'cvdw executar                - Executar o CVDW-CLI'
        ]);

        $io->section('Exemplos do Executar:');
        $io->listing([
            'cvdw executar listar-opcoes  - Lista todos os objetos disponíveis no CVDW-CLI',
            'cvdw executar all            - Executa todos os objetos disponíveis no CVDW-CLI',
            'cvdw executar -q all         - Executa todos os objetos disponíveis sem mostrar mensagens no output',
            'cvdw executar [objeto]       - Executa um objeto especifico no CVDW-CLI'
        ]);

        return Command::SUCCESS;
    }

}