<?php
declare(strict_types=1);

namespace BasicApp\Tests\Template;

use BasicApp\Template\Template;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
  public function testInstantiation(): void
  {
    $template = new Template();
    $this->assertInstanceOf(Template::class, $template);
  }

  public function testRender(): void
  {
    $template = new Template();
    $this->assertIsString($template->render('404.html.tpl'));
  }

  public function testGetTemplatePath(): void
  {
    $template = new Template();
    $this->assertIsString($template->getTemplatePath('404.html.tpl'));
    $this->assertStringContainsString('404.html.tpl', $template->getTemplatePath('404.html.tpl'));
  }
}
