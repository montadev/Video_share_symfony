<?php

namespace App\Utils\AbstractClasses;

use App\Twig\AppExtension;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract{

    public $entitymanager;
    public $urlgenarator;
    public $categoriesArrayFromDb;
    public $categorylist;
    public $filter;

    public function __construct(EntityManagerInterface $entitymanager,UrlGeneratorInterface $urlgenarator,AppExtension $filter)
    {
        $this->entitymanager=$entitymanager;
        $this->urlgenarator=$urlgenarator;
        $this->categoriesArrayFromDb=$this->getCategories();
        $this->filter=$filter;
    }


    abstract public function getCategoryList(array $categories_array);

    public function buildTree(int $parent_id=null )
    {
        $subcategory=[];

        foreach ($this->categoriesArrayFromDb as $category) {
            

             if($category['parent_id']==$parent_id)
             {

                

                $children=$this->buildTree($category['id']);

             //18 ligne stop //
                if($children)
                {

                    $category['children']=$children;

                    
                }

                

                $subcategory[]=$category;

                
             }
        }
        
        
        return $subcategory;
    }
    
    private function getCategories(){

        $conn=$this->entitymanager->getConnection();

        $sql="SELECT * FROM categories";

        $stmt=$conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    
}