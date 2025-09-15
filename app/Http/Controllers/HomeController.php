<?php

namespace App\Http\Controllers;
use App\Models\IndustryMasterData;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homepage(){
        if(view()->exists('home/home')){
          

            return view('home/home');
        } else {
            dd('View does not exist');
        }
    }

    public function aboutpage(){
        if(view()->exists('home/about')){
             

            return view('home/about');
        } else {
            dd('View does not exist');
        }
    }
     public function pilpage(){
        if(view()->exists('home/pilerf')){
             

            return view('home/pilerf');
        } else {
            dd('View does not exist');
        }
    }
    public function actpage(){
        if(view()->exists('home/actandrule')){
             

            return view('home/actandrule');
        } else {
            dd('View does not exist');
        }
    }
    public function stakepage(){
        if(view()->exists('home/stakeholder')){
             

            return view('home/stakeholder');
        } else {
            dd('View does not exist');
        }
    }
     public function annualauditpage(){
        if(view()->exists('home/annualauditreport')){
             

            return view('home/annualauditreport');
        } else {
            dd('View does not exist');
        }
    }
    public function faqpage(){
        if(view()->exists('home/faq')){
             

            return view('home/faq');
        } else {
            dd('View does not exist');
        }
    }


}
