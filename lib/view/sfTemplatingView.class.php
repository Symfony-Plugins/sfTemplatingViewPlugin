<?php

class sfTemplatingView extends sfPHPView
{
  protected $engine;

  public function execute()
  {
    $this->engine = new sfTemplateEngine($this->getLoader(), $this->getRenderers(), $this->getHelperSet());
  }

  protected function getLoader()
  {
    return new sfTemplateLoaderFilesystem(sfConfig::get('sf_root_dir').'/%name%');
  }

  protected function getHelperSet()
  {
    return new sfSymfonyTemplateHelperSet(array(
      new sfTemplateHelperAssets(),
      new sfTemplateHelperJavascripts(),
      new sfTemplateHelperSymfony(),
    ));
  }

  protected function getRenderers()
  {
    return array(
      'php' => new sfTemplateRendererPhp(),
    );
  }

  public function getEngine()
  {
    return $this->engine;
  }

  public function renderFile($_sfFile)
  {
    if (sfConfig::get('sf_logging_enabled'))
    {
      $this->dispatcher->notify(new sfEvent($this, 'application.log', array(sprintf('Render "%s"', $_sfFile))));
    }

    // unfortunately, we need to load the Escaping helper since the attributeHolder
    // needs access to ESC_* constants
    //ProjectConfiguration::getActive()->loadHelpers('Escaping');
    //
    // We need to load core and standard helpers because of internal dependencies inside helpers
    $this->loadCoreAndStandardHelpers();

    return $this->getEngine()->render($_sfFile, $this->attributeHolder->toArray());
  }
}
