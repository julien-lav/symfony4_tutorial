<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('embed', array($this, 'embedFilter')),
        );
    }
    public function embedFilter($string)
    {
        $cutMe = 'watch?v=';
    	$orMe = 'youtu.be';
    	$newString = str_replace($cutMe, "embed/", $string); 	
    	$resultString = str_replace($orMe, "www.youtube.com/embed", $newString);
    	return $resultString;
    }
}
