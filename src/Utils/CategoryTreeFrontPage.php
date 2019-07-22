<?php

namespace App\Utils;

use App\Entity\Category;
use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract{

    public function getCategoryList(array $categories_array){

        $this->categorylist .= '<ul>';
        foreach ($categories_array as $value)
        {
            $catName = $value['name'];

            $catName=$this->filter->slugify($catName);

            $url = $this->urlgenarator->generate('video-list', ['categoryname'=>$catName, 'id'=>$value['id']]);
            $this->categorylist .= '<li>' . '<a href="' . $url . '">' . $catName . '</a>';
          //if(!empty($value['children']))
            
          if (array_key_exists("children",$value))
            {
                $this->getCategoryList($value['children']);
            }
            
            $this->categorylist.='</li>';
        }
        $this->categorylist .= '</ul>';
        return $this->categorylist;
       }


       public function getMaincategory($id)
    {
        
        $categoryRepo=$this->entitymanager->getRepository(Category::class);

        $category=$categoryRepo->find($id);

        return $category;

        
    }

    

    
    
}