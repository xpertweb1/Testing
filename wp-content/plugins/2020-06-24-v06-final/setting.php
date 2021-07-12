<?php
    function add_new_menu_items()
    {
        add_menu_page(
            "MarkType Options",
            "MarkType Options",
            "manage_options",
            "marktype-options",
            "theme_options_page",
            "",
            6
        );
add_submenu_page( 'marktype-options', 'My Custom Submenu Page', 'Manage Mark Type',
    'manage_options', 'edit-tags.php?taxonomy=marktypes');

    }

    function theme_options_page()
    {
        ?>
            <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1>MarkType Options</h1>
           

            <?php
                //we check if the page is visited by click on the tabs or on the menu button.
                //then we get the active tab.
                $active_tab = "header-options";
                if(isset($_GET["tab"]))
                {
                    if($_GET["tab"] == "header-options")
                    {
                        $active_tab = "header-options";
                    }
                    else
                    {
                        $active_tab = "ads-options";
                    }
                }
            ?>
           
            <!-- wordpress provides the styling for tabs. -->
            <h2 class="nav-tab-wrapper">
                <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
                <a href="?page=marktype-options&tab=header-options" class="nav-tab <?php if($active_tab == 'header-options'){echo 'nav-tab-active';} ?> "><?php _e('Marktype Options', 'sandbox'); ?></a>
                <a href="?page=marktype-options&tab=ads-options" class="nav-tab <?php if($active_tab == 'ads-options'){echo 'nav-tab-active';} ?>"><?php _e('FaQs', 'sandbox'); ?></a>
            </h2>

            <form method="post" action="options.php">
                <?php
               
                    settings_fields("header_section");
                   
                    do_settings_sections("marktype-options");
               
                    submit_button();
                   
                ?>          
            </form>
        </div>
        <?php
    }

    add_action("admin_menu", "add_new_menu_items");

    function display_options()
    {
        add_settings_section("header_section", "Settings", "display_header_options_content", "marktype-options");

        //here we display the sections and options in the settings page based on the active tab
        if(isset($_GET["tab"]))
        {
            if($_GET["tab"] == "header-options")
            {
                add_settings_field("show_location", "Show in Post", "display_logo_form_element", "marktype-options", "header_section");
                register_setting("header_section", "show_location");



                add_settings_field("marktypcss", "Css Settings", "display_css_element", "marktype-options", "header_section");
                register_setting("header_section", "marktypcss");


                add_settings_field("post_allowed", "Select post Type you want to show Marktype", "display_post_form_element", "marktype-options", "header_section");
                register_setting("header_section", "post_allowed");
            }
            else
            {
                add_settings_field("advertising_code", "Your Faq Heading", "display_ads_form_element", "marktype-options", "header_section");      
               
                register_setting("header_section", "advertising_code");
            }
        }
        else
        {
            add_settings_field("show_location", "Show in Post", "display_logo_form_element", "marktype-options", "header_section");
            register_setting("header_section", "show_location");



                add_settings_field("marktypcss", "Css Settings", "display_css_element", "marktype-options", "header_section");
                register_setting("header_section", "marktypcss");


            add_settings_field("post_allowed", "Select post Type you want to show Marktype", "display_post_form_element", "marktype-options", "header_section");
            register_setting("header_section", "post_allowed");
        }
       
    }

        function display_header_options_content(){echo "";}


    function display_logo_form_element()
    {
        $showsloc=get_option('show_location');

        ?>
            <input type="radio" name="show_location" value="show_above" <?php if($showsloc=='show_above'){echo 'checked';} ?>   />Show Above Title<br/>
            <input type="radio" name="show_location" value="show_below" <?php if($showsloc=='show_below'){echo 'checked';} ?>  />Show Below Title<br/>
            <input type="radio" name="show_location" value="show_both" <?php if($showsloc=='show_both'){echo 'checked';} ?>  />Show on Both<br/>
        <?php
    }


     function display_css_element()
    {


            $styling='
            .con-tooltip.top p {
    margin: 0;
}


.con-tooltip.top {
    display: inline-block;
    border: 1px solid #ddd;
    color: #999;
    background-color: white;
    font-family: "Open Sans", "Source Sans Pro", "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    padding: 0.1rem .3rem !important;
    text-transform: uppercase;
    font-size: 11px;
    border-radius: 0;
    font-weight: bold;
    margin: 0 .4rem .2rem 0;
}
/*tooltip Box*/
.con-tooltip {

  position: relative;
  background: #F2D1C9;
  
  border-radius: 9px;
  padding: 0 20px;
  margin: 10px;
  
  display: inline-block;
  
  transition: all 0.3s ease-in-out;
  cursor: default;

}

/*tooltip */
.tooltip {
    font-size: 11px;
    visibility: hidden;
    font-weight: 100;
    z-index: 1;
    opacity: .40;
    text-transform: capitalize;
    width: 100%;
    padding: 10px 10px;
    background: #ddd;
    color: #000;
    position: absolute;
    bottom: 42px;
    left: 0%;
    border-radius: 9px;
    font: 16px;
    transform: translateY(9px);
    transition: all 0.3s ease-in-out;
}
.tooltip a {
    color: #000;
}

/* tooltip  after*/
.tooltip::after {
    content: " ";
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 12px 12.5px 0 12.5px;
    border-color: #ddd transparent transparent transparent;
    position: absolute;
    left: 40%;
    bottom: -9px;
}

.con-tooltip:hover .tooltip{
  visibility: visible;
  transform: translateY(-10px);
  opacity: 1;
    transition: .3s linear;
  animation: odsoky 1s ease-in-out infinite  alternate;

}
@keyframes odsoky {
  0%{
    transform: translateY(6px); 
  }

  100%{
    transform: translateY(1px); 
  }

}

.top:hover {transform: translateY(-6px);  }';


        $marktypecss=get_option('marktypcss');


//        print_r($marktypecss);

        if(!empty($marktypecss))
        {
            $styling=$marktypecss;
        }

        ?>
            <textarea name="marktypcss"  rows="10" cols="90"><?php echo $styling; ?></textarea>
        <?php
    }



    function display_post_form_element()
    {
        

                            $args = array(
                     'public'   => true,
                     '_builtin' => true
                );


                $show_post_types = get_post_types( $args );

                    foreach ( $show_post_types as $type ) {
                    if($type!='attachment')
                    {
                        $postype=get_option('post_allowed');
                        $checked='';
                        if(!empty($postype))
                        {
                                if (in_array($type, $postype))
                                {
                                    $checked='checked';
                                }    
                        }else
                        {
                            $checked='checked';
                        }
                        

                    ?>

                <input type="checkbox" name="post_allowed[]" value="<?php echo $type; ?>" <?php echo  $checked; ?> /> <?php echo $type; ?><br/>
                <?php
                    }

            }

        ?>
            








        <?php
    }





    function display_ads_form_element()
    {
        ?>
            <p>Your Content will go here</p><p>This will found in display_ads_form_elment function in setting.php</p>
        <?php
    }

    add_action("admin_init", "display_options");