<?php

class sfSymfonyTemplateHelperSet extends sfTemplateHelperSet
{
  /**
   * If we have a helper class by that name we return it first
   * otherwise then we check if symfony can handle it
   */
  public function get($name)
  {
    try
    {
      return parent::get($name);
    }
    catch (InvalidArgumentException $e)
    {
      ProjectConfiguration::getActive()->loadHelpers($name);
      return $this->helpers['symfony'];
    }
  }
}
