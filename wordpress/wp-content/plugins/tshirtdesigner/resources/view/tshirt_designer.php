<?php



add_shortcode('tshirtdesigner', 'tshirt_designer');

function tshirt_designer($atts, $content=null) {

    // Extract short codes
    // that are added via pages or file
    extract( shortcode_atts(array(
        'title'=>'false',
        'description'=>'false'
    ), $atts));

    // Show or hide title
    if($title == 'true') {
       $content .= "<h1> Welcome to t shirt designer! </h1>";
     } else {
         $content .= "<h1> No title! </h1>";
     }

    // Show or hide description
    if($description == 'true') {
        $content .= "<h3> T-Shirt Designer is the best tool to design your t-shirt that you loved most and you can sell it anywhere like in social
            networking sites, facebook,twitter,instagram and etc..</h3>";
    } else {
        $content .= "<h3>No Description!</h3>";
    }

    // print design of the app
    $tshirDesign = new TshirDesign();
    $content .= $tshirDesign->skin();

    return $content;

}



class TshirDesign {

    private $content = '';
    function __construct()
    {
    }
    public function skin() {
         
        $content = '<div style="border:2px solid grey; height:700px; width: 100%; background-color:#e5e5e5"> 

            <div  class="tsd-tshirt-color">  
                <ul>
                    <li> 1 </li><li> 5 </li><li> 10 </li><li> 14 </li>
                    <li> 2 </li><li> 6 </li><li> 11 </li><li> 15 </li>
                    <li> 3 </li><li> 7 </li><li> 12 </li><li> 16 </li>
                    <li> 4 </li><li> 8 </li><li> 13 </li><li> 17 </li> 
                </ul> 
             </div> 
        </div>'; 

        return $content;
        
    }
}




