<?php
    //Get location from form
    $my_location = explode('\s', $_POST['city']);
    $my_new_location = implode('_', $my_location);

    //Get weather for desired location
    $cur_weather = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$my_new_location.'&APPID=5c6a5a74f8b5c172dc9e2ecc44d5c709');
    $cur_weather = json_decode($cur_weather);
    $forecast = file_get_contents('http://api.openweathermap.org/data/2.5/forecast/daily?q='.$my_new_location.'&cnt=5&APPID=5c6a5a74f8b5c172dc9e2ecc44d5c709');
    $forecast = json_decode($forecast);

    //Get name of the location
    $location = $cur_weather->{'name'};

    //Get id, description of current weather and temp
    $cur_id = $cur_weather->{'weather'}[0]->{'id'};
    $description = $cur_weather->{'weather'}[0]->{'description'};
    $temp = $cur_weather->{'main'}->{'temp'};
    $cur_icon = get_icon($cur_id);
    $temp_f = round(($temp - 273.15)* 1.8000 + 32.00, 0);
    $current_photo = "";
    $temps = array();
    $ids = array();
    $descriptions = array();
    $five_day = $forecast->{'list'};

   foreach($five_day as $day){
       array_push($temps, round((($day->{'temp'}->{'max'}) - 273.15)* 1.8000 + 32.00, 0));
       array_push($ids, $day->{'weather'}[0]->{'id'});
       array_push($descriptions, $day->{'weather'}[0]->{'main'});
    }
    function get_icon($id){
        
        $icon = "";
        if($id < 300 && $id >= 200){
            $icon = "27.svg";
        } elseif($id >=300 && $id < 400){
            $icon = "17.svg";
        } elseif($id >= 500 && $id < 600){
            $icon = "18.svg";
        } elseif($id >= 600 && $id < 700){
            $icon = "23.svg";
        } elseif($id >= 600 && $id < 700){
            $icon = "23.svg";
        } elseif($id >= 700 && $id < 800){
            $icon = "13.svg";
        } elseif($id == 800){
            $icon = "2.svg";
        } elseif($id == 801){
            $icon = "8.svg";
        } elseif($id == 802){
            $icon = "14.svg";
        } elseif($id == 803){
            $icon = "25.svg";
        } elseif($id == 804){
            $icon = "25.svg";
        } else {
            $icon = "45.svg";
        }
        
        return $icon;
    }

?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="theme-color" content="#db5945">
        <title>Weather</title>
         <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" type="text/css" href="css/custom.css"/>

      <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto:500,900,100,300,700,400' rel='stylesheet' type='text/css'>

        <title><?php echo $location.' Weather' ?></title>
    </head>
    <body>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
 
        <div class="row">
            <div class="col s10 m6 l6 offset-s1 offset-m3 offset-l3">
            
            <div class="card indigo darken-1 medium">
                <div class="card-image white waves-effect waves-block waves-light">
                  <img class="activator" id="weather-img" src=<?php echo "img/".$cur_icon ?> >
                </div>
                <div class="card-content">
                    <span class="card-title activator white-text"><?php echo"<strong>". $location."</strong><br>".$temp_f.' degrees'?> <i class="mdi-navigation-more-vert right"></i></span>
                </div>
                <div class="card-reveal indigo darken-1">
                    <span class="card-title white-text">Details <i class="mdi-navigation-close right"></i></span>
                                   
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                          <div class="collapsible-header"><i class="mdi-image-filter-drama"></i>Current</div>
                          <div style = 'background-color: white' class="collapsible-body"><p>Current Conditons: <?php echo ucfirst($description)?> </p></div>
                        </li>
                        <li>
                          <div class="collapsible-header"><i class="mdi-device-access-time"
 ></i>Five Day Forecast</div>
                          <div style = 'background-color: white' class="collapsible-body">
                              <table>
                                  <tr>
                                      <?php
                                        
                                        foreach($ids as $days){
                                            echo "<td> <img class='forecast-img' src=img/".get_icon($days)."></td>";
                                        }
                                    
                                    ?>
                                  </tr>
                                  <tr>
                                      <?php
                                        
                                        foreach($temps as $days){
                                            echo "<td> <span class='forecast-temps'>".$days."º</span></td>";
                                        }
                                    
                                    ?>  
                                  </tr>
                                  <tr>
                                      <?php
                                        
                                        foreach($descriptions as $days){
                                            echo "<td> <span class='forecast-temps'>".$days."</span></td>";
                                        }
                                    
                                    ?>  
                                  </tr>
                              </table>
                              
                              
                            </div>
                        
                        </li>
                        <li>
                          <div class="collapsible-header"><i class="mdi-maps-map"></i>Radar</div>
                          <div class="collapsible-body" style="background-color: white"><p>Lorem ipsum dolor sit amet.</p></div>
                        </li>
                      </ul>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>