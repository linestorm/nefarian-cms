<?php

namespace Nefarian\CmsBundle\Configuration\Event;

use Nefarian\CmsBundle\Configuration\Form\ConfigurationSettingsForm;
use Symfony\Component\EventDispatcher\Event;

/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigFormBuildEvent extends Event
{
    /**
     * @var ConfigurationSettingsForm
     */
    protected $form;

    function __construct(ConfigurationSettingsForm $form)
    {
        $this->form = $form;
    }

    /**
     * @return ConfigurationSettingsForm
     */
    public function getForm()
    {
        return $this->form;
    }
} 
