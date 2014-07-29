<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Nefarian\CmsBundle\Editor;


class EditorManager
{
    protected $editors = array();

    /**
     * @param array $editors
     */
    public function setEditors(array $editors)
    {
        foreach($editors as $editor)
        {
            $this->addEditor($editor);
        }
    }

    public function addEditor(EditorInterface $editor)
    {
        $this->editors[$editor->getName()] = $editor;
    }

    public function getEditor($name)
    {
        return $this->editors[$name];
    }

    /**
     * @return array
     */
    public function getEditors()
    {
        return $this->editors;
    }


} 
