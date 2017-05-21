<?php

namespace FotoJoin\GalleryBundle\Form\ChoiceLoader;

use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;


class UserChoiceList implements ChoiceLoaderInterface
{
    public function loadChoiceList($value = null)
    {
        $choices = array();
        return new ArrayChoiceList($choices);
    }

    public function loadChoicesForValues(array $values, $value = null)
    {
        $result = array();
        foreach ($values as $key => $value) {
            $result[] = 'opcion';
        }
        return $result;
    }

    public function loadValuesForChoices(array $choices, $value = null)
    {
        $result = array();
        foreach ($choices as $key => $choice) {
            $result[] = 'opcion';
        }
        return $result;
    }
}