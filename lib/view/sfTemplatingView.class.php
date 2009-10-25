<?php

class sfTemplatingView extends sfPHPView
{
  protected $engine;

  public function execute()
  {
    $loader = new sfTemplateLoaderFilesystem(sfConfig::get('sf_root_dir').'/%name%');
    $this->engine = new sfTemplateEngine($loader);
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

    $this->loadCoreAndStandardHelpers();

    return $this->getEngine()->render($_sfFile, $this->attributeHolder->toArray());
  }
}
