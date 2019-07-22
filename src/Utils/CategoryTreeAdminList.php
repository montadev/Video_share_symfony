<?php
namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeAdminList extends CategoryTreeAbstract{


    public function getCategoryList(array $categories_array){

        $this->categorylist .= '<ul class="fa-ul text-left">';
        foreach ($categories_array as $value)
        {
            $catName = $value['name'];

            $catName=$this->filter->slugify($catName);

            $urledit = $this->urlgenarator->generate('edit_category');
            $urldelete=$this->urlgenarator->generate('delete_category',['id'=>$value['id']]);


            $this->categorylist .= '<li><i class="fa-li fa fa-arrow-right"></i> '.$catName.
            '<a href="'.$urledit.'"> edit</a><a onclick="return confirm(\'Are you sure?\');"
            href="'.$urldelete.'"> delete</a>';
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

}

