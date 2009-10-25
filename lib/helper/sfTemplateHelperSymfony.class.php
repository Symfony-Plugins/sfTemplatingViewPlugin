<?php

class sfTemplateHelperSymfony extends sfTemplateHelper
{
  public function getName()
  {
    return 'symfony';
  }

  public function __call($method, $args)
  {
    if (!function_exists($method))
    {
      throw new InvalidArgumentException(sprintf('Helper function "%s" does not exist', $method));
    }

    return call_user_func_array($method, $args);
  }
}
