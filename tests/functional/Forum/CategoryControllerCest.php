<?php

use PN\Forum\Category;
use PN\Users\User;

class CategoryControllerCest
{

    public function _before(FunctionalTester $I)
    {

        //arrange
        $this->mod_user = $I->factory()->Create(User::class,[
            'level' => 2 //set user to mod
        ]);



    }

    public function _after(FunctionalTester $I)
    {

    }

    public function tryCreateCategory(FunctionalTester $I)
    {
        $I->amLoggedAs($this->mod_user);
        $I->amOnRoute('forum.index');

        $temp_category = $I->factory()->instance(Category::class);
        $I->submitForm('form[action=\''.route('forum.category.store').'\']',[
            'private' => 0,
            'title' =>  $temp_category->title,
            'description' => $temp_category->description,
            'enable_threads' => 1
        ]);

        $category = $I->grabRecord(Category::class,['title' => $temp_category->title]);
        $I->seeCurrentRouteIs('forum.category.index',[
            'category' => $category->id,
            'category_slug' => $category->title
        ]);

    }

    public function tryCreateSubCategory(FunctionalTester $I)
    {
       $parent_category = $I->factory()->create(Category::class);

        $I->amLoggedAs($this->mod_user);
        $I->amOnRoute('forum.index');
        $temp_category = $I->factory()->instance(Category::class);
        $I->submitForm('form[action=\''.route('forum.category.store').'\']',[
            'private' => 0,
            'title' =>  $temp_category->title,
            'description' => $temp_category->description,
            'enable_threads' => 1,
            'category_id' => $parent_category->id
        ]);

        $category = $I->grabRecord(Category::class,['title' => $temp_category->title]);
        $I->seeCurrentRouteIs('forum.category.index',[
            'category' => $category->id,
            'category_slug' => $category->title
        ]);
    }
    //TODO: Move Category
    //TODO: Delete Category
    //TODO: Reorder Category
    //TODO: Rename Category
    //TODO: Move Category
    //TODO: Make Category Private

}