<div class="sidebar" data-color="blue" data-image="assets/img/sidebar-4.jpg">

<!-- Color support: "blue | azure | green | orange | red | purple" -->


    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.aftab.com" class="simple-text">
                    Aftab Feed Products
                </a>
                <h6>Amtola ,Khulna</h6>
            </div>

            <ul class="nav">
            <?php
            function DashboardMenu($fileName)
            {
                $xml = simplexml_load_file('./config/'.$fileName);
                $menu = "";
                foreach($xml->items as $item)
                {
                    if(basename($_SERVER['PHP_SELF'])==$item->link)
                    {
                        $menu .= '<li class="active"> <a href="'.$item->link.'"><i class="'.$item->icon.'"></i> '.$item->title.'</a></li>';
                    }
                    else
                    {
                        $menu .= '<li> <a href="'.$item->link.'"><i class="'.$item->icon.'"></i> '.$item->title.'</a></li>';
                    }
                }
                return $menu;

                }
                echo DashboardMenu('menu.xml');

            ?>
				
            </ul>
    	</div>
    </div>
