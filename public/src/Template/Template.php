<?php
declare(strict_types=1);

namespace BasicApp\Template;

use BasicApp\Exception\FileNotFoundException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * A very lightweight template engine with PHP.
 *
 * Resource: https://codeshack.io/lightweight-template-engine-php/
 */
class Template
{
  public const TEMPLATE_DIR = 'template';
  public const CACHE_DIR = '.var/cache';

  private bool $cache;
  private array $blocks = [];
  private string $templateDir;
  private string $cacheDir;
  private LoggerInterface $logger;
  private string $content = '';
  private int $contentLength = 0;

  public function __construct(string $templateDir = null, string $cacheDir = null, bool $cache = false, LoggerInterface $logger = null)
  {
    if (null === $logger) {
      $this->logger = new NullLogger();
    } else {
      $this->logger = $logger;
    }

    if (null === $templateDir) {
      $this->templateDir = dirname(__DIR__, 2) . '/' . self::TEMPLATE_DIR;
    } else {
      $this->templateDir = $templateDir;
    }

    $this->logger->info("The template directory is set to \"$this->templateDir\"");

    if (!is_dir($this->templateDir)) {
      $message = "The given template directory \"$this->templateDir\" used as root folder for templates not found!";
      $this->logger->warning($message);
    }

    if (null === $cacheDir) {
      $this->cacheDir = dirname(__DIR__, 2) . '/' . self::CACHE_DIR;
    } else {
      $this->cacheDir = $cacheDir;
    }

    $this->logger->info("The cache directory is set to \"$this->cacheDir\"");

    if (!is_dir($this->cacheDir)) {
      mkdir($this->cacheDir, 0744, true);
      $this->logger->notice("The cache directory \"$this->cacheDir\" not found and was created!");
    }

    $this->cache = $cache;
  }

  public function content(): string
  {
    return $this->content;
  }

  public function contentLength(): int
  {
    return $this->contentLength;
  }

  public function clearCache(): void
  {
    foreach (glob($this->cacheDir . '*') as $file) {
      unlink($file);
    }

    $this->logger->info('The cache cleared successful');
  }

  /**
   * @throws FileNotFoundException
   */
  public function render(string $file, array $data = []): string
  {
    $this->logger->info("Starting to render template file \"$file\"");

    ob_start();

    $code = $this->includeFiles($file);
    $code = $this->compileCode($code);

    $cacheFile = $this->cacheCodeToFile($code, $file);

    extract($data, EXTR_SKIP);
    extract($this->blocks, EXTR_SKIP);

    require $cacheFile;

    $this->content = ob_get_contents();
    $this->contentLength = ob_get_length();
    ob_end_clean();

    $this->logger->info('Content rendering done!');

    return $this->content;
  }

  public function view(string $file, array $data = []): void
  {
    echo $this->render($file, $data);

    $this->logger->info('Output of rendered contend done!');
  }

  /**
   * @param string $code
   */
  public function compileComments($code): string
  {
    return preg_replace('~\{#\s*(.+?)\s*\#}~is', '', $code);
  }

  private function cacheCodeToFile(string $code, string $file): string
  {
    $cacheFile = $this->cacheDir . '/' . str_replace(['/', '.html'], ['_', ''], $file . '.php');

    $this->logger->info("Caching code from template path \"$file\" into \"$cacheFile\" file");

    file_put_contents($cacheFile, trim('<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code));

    /*
    if (!self::$cache_enabled || !file_exists($cached_file) || filemtime($cached_file) < filemtime($file)) {
        $code = self::includeFiles($file);
        $code = self::compileCode($code);
        file_put_contents($cached_file, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
    }
    */

    return $cacheFile;
  }

  /**
   * @throws FileNotFoundException
   */
  private function includeFiles(string $file): string
  {
    $templateFilePath = $this->templateDir . '/' . $file;

    $this->logger->info("Including the template from path \"$templateFilePath\"");

    if (!is_file($templateFilePath)) {
      $massage = "The given template file \"$templateFilePath\" not found!";
      $this->logger->critical($massage);

      throw new FileNotFoundException($massage);
    }

    $code = file_get_contents($this->templateDir . '/' . $file);
    preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);

    foreach ($matches as $value) {
      $code = str_replace($value[0], self::includeFiles($value[2]), $code);
    }

    return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $code);
  }

  private function compileCode(string $code): string
  {
    $this->logger->info('Start to compile the code');

    $code = $this->compileComments($code);
    $code = $this->compileBlock($code);
    $code = $this->compileYield($code);
    $code = $this->compileEscapedEchos($code);
    $code = $this->compileEchos($code);
    $code = $this->compilePHP($code);

    return $code;
  }

  private function compileBlock(string $code): string
  {
    $this->logger->info('Start to compile blocks');

    preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);

    foreach ($matches as $value) {
      if (!array_key_exists($value[1], $this->blocks)) {
        $this->blocks[$value[1]] = '';
      }

      if (!str_contains($value[2], '@parent')) {
        $this->blocks[$value[1]] = $value[2];
      } else {
        $this->blocks[$value[1]] = str_replace('@parent', $this->blocks[$value[1]], $value[2]);
      }

      $code = str_replace($value[0], '', $code);
    }

    return $code;
  }

  private function compileYield(string $code): string
  {
    $this->logger->info('Start to compile yield');

    foreach ($this->blocks as $block => $value) {
      $code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
    }

    return preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
  }

  private function compileEscapedEchos(string $code): string
  {
    $this->logger->info('Start to compile escaped echos');

    return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
  }

  private function compileEchos(string $code): string
  {
    $this->logger->info('Start to compile echos');

    return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
  }

  private function compilePHP(string $code): string
  {
    $this->logger->info('Start to compile PHP code');

    return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $code);
  }
}
